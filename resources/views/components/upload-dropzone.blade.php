{{-- Upload Dropzone Component (design.md §4.3) --}}
{{-- Drag & drop area untuk upload foto camera trap --}}

<div class="relative" id="dropzone-wrapper">
    <form method="POST" action="{{ url('/deteksi/upload') }}" enctype="multipart/form-data" id="upload-form">
        @csrf

        {{-- Dropzone area --}}
        <div id="dropzone"
             class="relative border-2 border-dashed border-canopy-500/40 rounded-2xl p-8 lg:p-12
                    bg-white hover:border-canopy-500 hover:bg-canopy-500/5
                    transition-all duration-300 cursor-pointer text-center group"
             role="button" tabindex="0" aria-label="Upload foto camera trap">

            {{-- Default state --}}
            <div id="dropzone-default" class="space-y-4">
                <div class="w-16 h-16 mx-auto bg-canopy-500/10 rounded-2xl flex items-center justify-center
                            group-hover:bg-canopy-500/20 transition-colors duration-300">
                    <svg class="w-8 h-8 text-canopy-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                    </svg>
                </div>
                <div>
                    <p class="text-lg font-semibold text-forest-900">
                        Seret foto ke sini atau klik untuk memilih
                    </p>
                    <p class="text-sm text-text-500 mt-1">
                        Format: JPG, JPEG, PNG (maks. 10MB)
                    </p>
                </div>
            </div>

            {{-- Preview state --}}
            <div id="dropzone-preview" class="hidden">
                <div class="max-w-md mx-auto">
                    <div class="aspect-[4/3] rounded-xl overflow-hidden bg-cream-100 mb-4 shadow-inner">
                        <img id="preview-image" src="" alt="Preview" class="w-full h-full object-contain">
                    </div>
                    <p id="preview-filename" class="text-sm font-medium text-forest-900 truncate"></p>
                    <p id="preview-filesize" class="text-xs text-text-500 mt-1"></p>
                </div>
            </div>

            {{-- Drag overlay --}}
            <div id="dropzone-dragover"
                 class="hidden absolute inset-0 bg-canopy-500/10 border-2 border-canopy-500 border-dashed
                        rounded-2xl flex items-center justify-center z-10">
                <p class="text-canopy-500 font-semibold text-lg">Lepaskan file di sini</p>
            </div>

            {{-- Hidden file input --}}
            <input type="file" name="foto" id="file-input" accept="image/jpeg,image/jpg,image/png"
                   class="hidden" required>
        </div>

        {{-- Error message --}}
        @error('foto')
            <div class="mt-3 px-4 py-3 bg-alert-500/10 border border-alert-500/20 rounded-xl
                        text-alert-500 text-sm font-medium" role="alert" id="upload-error">
                {{ $message }}
            </div>
        @enderror

        {{-- Actions --}}
        <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-4">
            <button type="submit" id="submit-btn" disabled
                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5
                           bg-canopy-500 text-cream-50 font-semibold rounded-xl
                           hover:bg-forest-700 active:scale-95 transition-all duration-300
                           shadow-md hover:shadow-lg disabled:opacity-40 disabled:cursor-not-allowed
                           disabled:hover:bg-canopy-500 disabled:active:scale-100">
                {{-- Default text --}}
                <span id="btn-text">Analisis Foto</span>
                {{-- Loading spinner --}}
                <svg id="btn-spinner" class="hidden w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                <svg id="btn-arrow" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </button>

            <button type="button" id="reset-btn" class="hidden w-full sm:w-auto px-6 py-3.5
                           bg-cream-100 text-text-900 font-semibold rounded-xl border border-cream-100
                           hover:bg-cream-50 active:scale-95 transition-all duration-300">
                Ganti Foto
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('file-input');
    const defaultState = document.getElementById('dropzone-default');
    const previewState = document.getElementById('dropzone-preview');
    const dragOverlay = document.getElementById('dropzone-dragover');
    const previewImg = document.getElementById('preview-image');
    const previewName = document.getElementById('preview-filename');
    const previewSize = document.getElementById('preview-filesize');
    const submitBtn = document.getElementById('submit-btn');
    const resetBtn = document.getElementById('reset-btn');
    const btnText = document.getElementById('btn-text');
    const btnSpinner = document.getElementById('btn-spinner');
    const btnArrow = document.getElementById('btn-arrow');
    const form = document.getElementById('upload-form');

    // Click to open file dialog
    dropzone.addEventListener('click', function (e) {
        if (e.target.closest('#reset-btn')) return;
        fileInput.click();
    });

    // Keyboard support
    dropzone.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            fileInput.click();
        }
    });

    // Drag events
    ['dragenter', 'dragover'].forEach(function (event) {
        dropzone.addEventListener(event, function (e) {
            e.preventDefault();
            e.stopPropagation();
            dragOverlay.classList.remove('hidden');
        });
    });

    ['dragleave', 'drop'].forEach(function (event) {
        dropzone.addEventListener(event, function (e) {
            e.preventDefault();
            e.stopPropagation();
            dragOverlay.classList.add('hidden');
        });
    });

    dropzone.addEventListener('drop', function (e) {
        var files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFile(files[0]);
        }
    });

    // File input change
    fileInput.addEventListener('change', function () {
        if (this.files.length > 0) {
            handleFile(this.files[0]);
        }
    });

    function handleFile(file) {
        // Validate type
        var validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        if (!validTypes.includes(file.type)) {
            showError('Format file tidak didukung. Gunakan JPG atau PNG.');
            return;
        }
        // Validate size (10MB)
        if (file.size > 10 * 1024 * 1024) {
            showError('Ukuran file terlalu besar. Maksimal 10MB.');
            return;
        }

        // Show preview
        var reader = new FileReader();
        reader.onload = function (e) {
            previewImg.src = e.target.result;
            previewName.textContent = file.name;
            previewSize.textContent = formatFileSize(file.size);

            defaultState.classList.add('hidden');
            previewState.classList.remove('hidden');
            submitBtn.disabled = false;
            resetBtn.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }

    function formatFileSize(bytes) {
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(1) + ' MB';
    }

    function showError(msg) {
        var existing = document.getElementById('upload-error');
        if (existing) existing.remove();

        var errorDiv = document.createElement('div');
        errorDiv.id = 'upload-error';
        errorDiv.className = 'mt-3 px-4 py-3 bg-alert-500/10 border border-alert-500/20 rounded-xl text-alert-500 text-sm font-medium';
        errorDiv.setAttribute('role', 'alert');
        errorDiv.textContent = msg;
        dropzone.parentNode.insertBefore(errorDiv, dropzone.nextSibling);

        setTimeout(function () {
            errorDiv.style.transition = 'opacity 0.3s';
            errorDiv.style.opacity = '0';
            setTimeout(function () { errorDiv.remove(); }, 300);
        }, 4000);
    }

    // Reset
    resetBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        fileInput.value = '';
        previewImg.src = '';
        defaultState.classList.remove('hidden');
        previewState.classList.add('hidden');
        submitBtn.disabled = true;
        resetBtn.classList.add('hidden');
    });

    // Loading state on submit
    form.addEventListener('submit', function () {
        btnText.textContent = 'Menganalisis...';
        btnSpinner.classList.remove('hidden');
        btnArrow.classList.add('hidden');
        submitBtn.disabled = true;
    });
});
</script>
