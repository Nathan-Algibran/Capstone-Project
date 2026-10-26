"""
API untuk pipeline deteksi + klasifikasi spesies satwa liar.
Dijalankan LOKAL di komputer kamu (bukan di Colab), supaya bisa jalan terus
berdampingan dengan Laravel.

CARA SETUP:
1. Download 'best_model.pth' dari Google Drive ke folder yang sama dengan
   file ini, taruh di dalam folder bernama 'models/' (buat foldernya kalau
   belum ada): models/best_model.pth

2. Install semua library yang dibutuhkan:
   py -m pip install fastapi uvicorn python-multipart torch torchvision PytorchWildlife pillow

3. Jalankan API dengan:
   py -m uvicorn api:app --reload --port 8001

4. Buka browser ke http://127.0.0.1:8001/docs untuk test API langsung
   lewat antarmuka Swagger bawaan FastAPI (bisa upload gambar dari situ).
"""

import io
import os
import torch
import torch.nn as nn
from torchvision import models, transforms
from PIL import Image
from fastapi import FastAPI, File, UploadFile, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel

from PytorchWildlife.models import detection as pw_detection

# ============ KONFIGURASI ============
CLASSIFIER_PATH = os.path.join("models", "best_model.pth")
DETECTION_VERSION = "MDV6-yolov9-e"
DETECTION_CONFIDENCE_THRESHOLD = 0.1
UNKNOWN_CONFIDENCE_THRESHOLD = 0.5
CLASSIFIER_INPUT_SIZE = 224
# ======================================

app = FastAPI(title="Wildlife Detection & Classification API")

# CORS: izinkan Laravel (atau frontend lain) memanggil API ini.
# Kalau nanti Laravel manggil dari server-side (pakai Guzzle/HTTP client PHP),
# CORS sebenarnya tidak wajib. Tapi kalau ada kemungkinan JS di browser
# manggil API ini langsung, middleware ini diperlukan.
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # untuk development; batasi ke domain Laravel kamu saat production
    allow_methods=["*"],
    allow_headers=["*"],
)

device = torch.device("cuda" if torch.cuda.is_available() else "cpu")
print(f"[startup] Menggunakan device: {device}")

# --- Load MegaDetector ---
print("[startup] Memuat MegaDetector ...")
detection_model = pw_detection.MegaDetectorV6(version=DETECTION_VERSION)
print("[startup] MegaDetector siap.")

# --- Load classifier ResNet50 ---
print("[startup] Memuat model klasifikasi ...")
if not os.path.exists(CLASSIFIER_PATH):
    raise FileNotFoundError(
        f"File model tidak ditemukan di '{CLASSIFIER_PATH}'. "
        "Pastikan sudah download best_model.pth dari Google Drive "
        "dan taruh di folder models/."
    )

checkpoint = torch.load(CLASSIFIER_PATH, map_location=device)
class_names = checkpoint["class_names"]

classifier = models.resnet50(weights=None)
classifier.fc = nn.Linear(classifier.fc.in_features, len(class_names))
classifier.load_state_dict(checkpoint["model_state_dict"])
classifier = classifier.to(device)
classifier.eval()
print(f"[startup] Classifier siap. Kelas: {class_names}")

classify_transform = transforms.Compose([
    transforms.Resize(256),
    transforms.CenterCrop(CLASSIFIER_INPUT_SIZE),
    transforms.ToTensor(),
    transforms.Normalize(mean=[0.485, 0.456, 0.406], std=[0.229, 0.224, 0.225]),
])


# --- Skema response, biar konsisten & terdokumentasi otomatis di /docs ---
class Detection(BaseModel):
    bbox: list[int]  # [x1, y1, x2, y2]
    detection_confidence: float
    species: str
    classification_confidence: float


class PredictResponse(BaseModel):
    filename: str
    num_detections: int
    detections: list[Detection]


def classify_crop(pil_image_crop: Image.Image):
    tensor = classify_transform(pil_image_crop.convert("RGB")).unsqueeze(0).to(device)
    with torch.no_grad():
        outputs = classifier(tensor)
        probs = torch.softmax(outputs, dim=1)
        confidence, pred_idx = torch.max(probs, dim=1)

    confidence_value = confidence.item()

    if confidence_value < UNKNOWN_CONFIDENCE_THRESHOLD:
        return "tidak_teridentifikasi", confidence_value

    return class_names[pred_idx.item()], confidence_value


def run_pipeline(pil_image: Image.Image, temp_path: str):
    result = detection_model.single_image_detection(temp_path)
    detections = result.get("detections", None)

    final_results = []
    if detections is None or len(detections.xyxy) == 0:
        return final_results

    # PENTING: classifier (ResNet50) dilatih dengan FOTO UTUH (bukan hasil
    # crop ketat ke bounding box), jadi di sini kita klasifikasi foto ASLI
    # untuk tiap deteksi -- bounding box cuma dipakai untuk info lokasi &
    # tampilan, BUKAN sebagai input ke classifier. Ini menghindari domain
    # mismatch yang bikin akurasi klasifikasi jauh lebih rendah dari hasil
    # evaluasi (87%) waktu testing dengan foto utuh.
    species, cls_confidence = classify_crop(pil_image)

    for i in range(len(detections.xyxy)):
        class_id = int(detections.class_id[i])
        det_confidence = float(detections.confidence[i])

        if class_id != 0 or det_confidence < DETECTION_CONFIDENCE_THRESHOLD:
            continue

        x1, y1, x2, y2 = detections.xyxy[i]

        final_results.append(
            {
                "bbox": [int(x1), int(y1), int(x2), int(y2)],
                "detection_confidence": round(det_confidence, 4),
                "species": species,
                "classification_confidence": round(cls_confidence, 4),
            }
        )

    return final_results


@app.get("/")
def root():
    return {"status": "ok", "message": "Wildlife Detection API is running", "classes": class_names}


@app.post("/predict", response_model=PredictResponse)
async def predict(file: UploadFile = File(...)):
    if not file.content_type.startswith("image/"):
        raise HTTPException(status_code=400, detail="File yang diupload harus berupa gambar.")

    contents = await file.read()

    try:
        pil_image = Image.open(io.BytesIO(contents)).convert("RGB")
    except Exception:
        raise HTTPException(status_code=400, detail="Gagal membaca file gambar.")

    # MegaDetector (versi PytorchWildlife) butuh path file, jadi kita simpan
    # sementara ke disk dulu.
    temp_path = f"_temp_{file.filename}"
    pil_image.save(temp_path)

    try:
        detections = run_pipeline(pil_image, temp_path)
    finally:
        if os.path.exists(temp_path):
            os.remove(temp_path)

    return {
        "filename": file.filename,
        "num_detections": len(detections),
        "detections": detections,
    }