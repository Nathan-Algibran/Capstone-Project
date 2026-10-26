<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Deteksi — SIMAKSI</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        @page {
            size: A4;
            margin: 20mm;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1a1a1a;
            line-height: 1.6;
            background: #fff;
            font-size: 11pt;
        }

        .report-header {
            text-align: center;
            border-bottom: 3px double #1b5e20;
            padding-bottom: 16px;
            margin-bottom: 24px;
        }

        .report-header h1 {
            font-size: 18pt;
            color: #1b5e20;
            letter-spacing: 2px;
            margin-bottom: 4px;
        }

        .report-header p {
            font-size: 9pt;
            color: #666;
        }

        .report-title {
            font-size: 14pt;
            font-weight: 700;
            color: #2e7d32;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 1px solid #e0e0e0;
        }

        .section {
            margin-bottom: 24px;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .info-item {
            padding: 10px 14px;
            background: #f5f5f5;
            border-left: 3px solid #2e7d32;
            border-radius: 0 4px 4px 0;
        }

        .info-item .label {
            font-size: 8pt;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #888;
            margin-bottom: 2px;
        }

        .info-item .value {
            font-size: 11pt;
            font-weight: 600;
            color: #1a1a1a;
        }

        .info-item.full-width {
            grid-column: 1 / -1;
        }

        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 9pt;
            font-weight: 600;
        }

        .badge-high { background: #c8e6c9; color: #1b5e20; }
        .badge-medium { background: #fff3e0; color: #e65100; }
        .badge-low { background: #ffcdd2; color: #b71c1c; }

        .badge-kritis { background: #ffcdd2; color: #b71c1c; }
        .badge-terancam { background: #ffe0b2; color: #e65100; }
        .badge-rentan { background: #fff9c4; color: #f57f17; }
        .badge-risiko-rendah { background: #c8e6c9; color: #2e7d32; }

        .photo-container {
            text-align: center;
            margin: 16px 0;
        }

        .photo-container img {
            max-width: 100%;
            max-height: 300px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
            margin-top: 8px;
        }

        table th {
            background: #2e7d32;
            color: #fff;
            padding: 8px 10px;
            text-align: left;
            font-weight: 600;
        }

        table td {
            padding: 7px 10px;
            border-bottom: 1px solid #e0e0e0;
        }

        table tr:nth-child(even) { background: #f9f9f9; }

        .stats-row {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
        }

        .stat-box {
            flex: 1;
            text-align: center;
            padding: 12px;
            background: #e8f5e9;
            border-radius: 6px;
        }

        .stat-box .number {
            font-size: 20pt;
            font-weight: 700;
            color: #1b5e20;
        }

        .stat-box .desc {
            font-size: 8pt;
            color: #555;
            text-transform: uppercase;
        }

        .footer {
            margin-top: 32px;
            padding-top: 12px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 8pt;
            color: #999;
        }

        .no-print {
            position: fixed;
            top: 16px;
            right: 16px;
            z-index: 100;
            display: flex;
            gap: 8px;
        }

        .btn-print, .btn-back {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 10pt;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-print {
            background: #1b5e20;
            color: #fff;
        }

        .btn-back {
            background: #e0e0e0;
            color: #333;
        }

        @media print {
            .no-print { display: none !important; }
            body { background: #fff; }
        }
    </style>
</head>
<body>
    {{-- Tombol print (tidak muncul di cetak) --}}
    <div class="no-print">
        <a href="{{ route('deteksi.hasil', $detection->id) }}" class="btn-back">← Kembali</a>
        <button class="btn-print" onclick="window.print()">🖨️ Cetak / Save PDF</button>
    </div>

    {{-- Header Laporan --}}
    <div class="report-header">
        <h1>SIMAKSI</h1>
        <p>Sistem Informasi Monitoring dan Analisis Konflik Satwa Liar Indonesia</p>
        <p>Laporan Hasil Deteksi • Dicetak {{ now()->format('d M Y, H:i') }} WIB</p>
    </div>

    {{-- Judul --}}
    <div class="report-title">
        Laporan Deteksi Spesies #{{ $detection->id }}
    </div>

    {{-- Foto Deteksi --}}
    <div class="section">
        <div class="photo-container">
            <img src="{{ asset('storage/' . $detection->foto_url) }}" alt="Foto deteksi">
        </div>
    </div>

    {{-- Info Deteksi --}}
    <div class="section">
        <div class="info-grid">
            <div class="info-item">
                <div class="label">Spesies Terdeteksi</div>
                <div class="value">{{ $detection->species?->nama_umum ?? 'Tidak Teridentifikasi' }}</div>
            </div>
            <div class="info-item">
                <div class="label">Nama Ilmiah</div>
                <div class="value" style="font-style: italic;">{{ $detection->species?->nama_ilmiah ?? '-' }}</div>
            </div>
            <div class="info-item">
                <div class="label">Tingkat Keyakinan</div>
                <div class="value">
                    @if($detection->confidence)
                        @php $pct = round($detection->confidence * 100, 1); @endphp
                        {{ $pct }}%
                        <span class="badge {{ $pct >= 80 ? 'badge-high' : ($pct >= 50 ? 'badge-medium' : 'badge-low') }}">
                            {{ $pct >= 80 ? 'Tinggi' : ($pct >= 50 ? 'Sedang' : 'Rendah') }}
                        </span>
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="info-item">
                <div class="label">Status Konservasi</div>
                <div class="value">
                    @if($detection->species)
                        @php $status = $detection->species->status_konservasi; @endphp
                        <span class="badge
                            {{ str_contains($status, 'Kritis') ? 'badge-kritis' : '' }}
                            {{ str_contains($status, 'Terancam') ? 'badge-terancam' : '' }}
                            {{ str_contains($status, 'Rentan') ? 'badge-rentan' : '' }}
                            {{ str_contains($status, 'Risiko Rendah') ? 'badge-risiko-rendah' : '' }}
                        ">{{ $status }}</span>
                    @else
                        -
                    @endif
                </div>
            </div>
            <div class="info-item">
                <div class="label">Tanggal Deteksi</div>
                <div class="value">{{ $detection->created_at->format('d M Y, H:i') }} WIB</div>
            </div>
            <div class="info-item">
                <div class="label">Tipe Lahan</div>
                <div class="value">{{ $detection->land_class_label ?? 'Belum diklasifikasi' }}</div>
            </div>
        </div>
    </div>

    {{-- Deskripsi Spesies --}}
    @if($detection->species)
    <div class="section">
        <div class="report-title" style="font-size: 12pt;">Profil Spesies</div>
        <div class="info-item full-width" style="background: #fff; border-left: 3px solid #66bb6a;">
            <div class="label">Deskripsi</div>
            <div style="font-size: 10pt; color: #333;">{{ $detection->species->deskripsi }}</div>
        </div>
        <div class="info-grid" style="margin-top: 12px;">
            <div class="info-item">
                <div class="label">Habitat</div>
                <div class="value" style="font-size: 10pt;">{{ $detection->species->habitat }}</div>
            </div>
            <div class="info-item">
                <div class="label">Ancaman Utama</div>
                <div class="value" style="font-size: 10pt;">{{ $detection->species->ancaman_utama }}</div>
            </div>
        </div>
    </div>
    @endif

    {{-- Statistik Konflik --}}
    @if(!empty($conflictStats))
    <div class="section">
        <div class="report-title" style="font-size: 12pt;">Data Konflik Terkait</div>
        <div class="stats-row">
            <div class="stat-box">
                <div class="number">{{ $conflictStats['total'] }}</div>
                <div class="desc">Total Insiden</div>
            </div>
            <div class="stat-box">
                <div class="number">{{ $conflictStats['terakhir'] }}</div>
                <div class="desc">Insiden Terakhir</div>
            </div>
        </div>

        @if($conflicts->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>Sumber</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($conflicts->take(15) as $i => $c)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $c->tanggal->format('d/m/Y') }}</td>
                    <td>{{ Str::limit($c->lokasi_nama, 40) }}</td>
                    <td>{{ Str::limit($c->sumber, 25) }}</td>
                    <td>{{ Str::limit($c->deskripsi, 60) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if($conflicts->count() > 15)
            <p style="font-size: 8pt; color: #999; margin-top: 8px; text-align: center;">
                Menampilkan 15 dari {{ $conflicts->count() }} insiden.
            </p>
        @endif
        @endif
    </div>
    @endif

    {{-- Footer --}}
    <div class="footer">
        <p>Dokumen ini di-generate oleh SIMAKSI — Sistem Informasi Monitoring dan Analisis Konflik Satwa Liar Indonesia</p>
        <p>Data bersumber dari BKSDA, Mongabay Indonesia, KLHK, dan media konservasi nasional.</p>
    </div>
</body>
</html>
