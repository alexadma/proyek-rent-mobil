@extends('layouts.mainadmin')

@section('head')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    :root {
        --primary: #6366f1;
        --primary-dark: #4f46e5;
        --primary-light: #818cf8;
        --primary-bg: rgba(99, 102, 241, 0.1);
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --dark: #0f172a;
        --dark-2: #1e293b;
        --dark-3: #334155;
        --dark-4: #475569;
        --light: #f8fafc;
        --border: #e2e8f0;
        --text-muted: #64748b;
        --text-light: #f1f5f9;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        --radius-sm: 0.375rem;
        --radius: 0.5rem;
        --radius-lg: 0.75rem;
        --radius-xl: 1rem;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        background: #f1f5f9;
        font-family: 'Inter', sans-serif;
        color: var(--dark);
        line-height: 1.5;
    }

    .page-wrap {
        min-height: 100vh;
        padding: 2rem 1.5rem;
        display: flex;
        align-items: flex-start;
        justify-content: center;
    }

    .form-card {
        width: 100%;
        max-width: 900px;
        background: white;
        border-radius: var(--radius-xl);
        box-shadow: var(--shadow-xl);
        overflow: hidden;
        animation: slideUp 0.5s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Header Styles */
    .form-header {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        padding: 1.5rem 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .header-icon {
        width: 56px;
        height: 56px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(8px);
        border-radius: var(--radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        color: white;
        box-shadow: var(--shadow);
    }

    .header-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: white;
        margin: 0;
        letter-spacing: -0.02em;
    }

    .header-sub {
        font-size: 0.875rem;
        color: rgba(255, 255, 255, 0.8);
        margin: 0.25rem 0 0 0;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.625rem 1.25rem;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 9999px;
        color: white;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        transform: translateX(-4px);
    }

    /* Body Styles */
    .form-body {
        padding: 2rem;
    }

    /* Section Label */
    .section-label {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin: 1.5rem 0 1rem 0;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--primary);
    }

    .section-label:first-of-type {
        margin-top: 0;
    }

    .section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: linear-gradient(to right, var(--primary), transparent);
    }

    /* Form Groups */
    .fgroup {
        margin-bottom: 1.25rem;
    }

    .fgroup label {
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--dark-4);
    }

    .fcontrol {
        width: 100%;
        padding: 0.75rem 1rem;
        background: white;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
        color: var(--dark);
        transition: all 0.2s;
    }

    .fcontrol:hover {
        border-color: var(--primary-light);
    }

    .fcontrol:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px var(--primary-bg);
    }

    .fcontrol::placeholder {
        color: var(--text-muted);
        opacity: 0.5;
    }

    select.fcontrol {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23475569'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1.25rem;
        padding-right: 2.5rem;
    }

    textarea.fcontrol {
        resize: vertical;
        min-height: 100px;
    }

    /* Input Group */
    .input-prefix {
        display: flex;
        align-items: stretch;
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        transition: all 0.2s;
    }

    .input-prefix:focus-within {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px var(--primary-bg);
    }

    .prefix-text {
        padding: 0.75rem 1.25rem;
        background: #f8fafc;
        color: var(--primary);
        font-weight: 600;
        font-size: 0.875rem;
        border-right: 1px solid var(--border);
        white-space: nowrap;
        display: flex;
        align-items: center;
    }

    .prefix-input {
        flex: 1;
        padding: 0.75rem 1rem;
        border: none;
        font-family: 'Inter', sans-serif;
        font-size: 0.95rem;
        outline: none;
    }

    /* Grid Layouts */
    .grid-2 {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.25rem;
    }

    .grid-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
    }

    /* File Upload */
    .file-upload-wrap {
        position: relative;
        background: #f8fafc;
        border: 2px dashed var(--border);
        border-radius: var(--radius-lg);
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .file-upload-wrap:hover {
        border-color: var(--primary);
        background: var(--primary-bg);
    }

    .file-upload-wrap input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .file-upload-icon {
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
        color: var(--primary);
    }

    .file-upload-text {
        font-size: 0.875rem;
        color: var(--text-muted);
    }

    .file-upload-text span {
        color: var(--primary);
        font-weight: 600;
    }

    /* Divider */
    .divider {
        height: 1px;
        background: linear-gradient(to right, transparent, var(--border), transparent);
        margin: 2rem 0;
    }

    /* Submit Button */
    .btn-submit {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        width: 100%;
        padding: 1rem 2rem;
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        border: none;
        border-radius: var(--radius);
        color: white;
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.2s;
        box-shadow: var(--shadow-lg);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-xl);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    /* Alert */
    .alert-errors {
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        background: #fef2f2;
        border: 1px solid #fee2e2;
        border-radius: var(--radius);
        color: var(--danger);
        font-size: 0.875rem;
    }

    .alert-errors ul {
        margin: 0.5rem 0 0 1.5rem;
        padding: 0;
    }

    .alert-errors li {
        margin-bottom: 0.25rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-wrap {
            padding: 1rem;
        }

        .form-header {
            padding: 1.25rem;
        }

        .form-body {
            padding: 1.25rem;
        }

        .header-title {
            font-size: 1.25rem;
        }

        .header-icon {
            width: 48px;
            height: 48px;
            font-size: 1.5rem;
        }

        .grid-2,
        .grid-3 {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
    }

    /* Loading State */
    .btn-submit.loading {
        position: relative;
        color: transparent;
    }

    .btn-submit.loading::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        border: 2px solid white;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f5f9;
    }

    ::-webkit-scrollbar-thumb {
        background: var(--primary-light);
        border-radius: 9999px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: var(--primary);
    }
</style>
@endsection

@section('container')
<div class="page-wrap">
    <div class="form-card">
        <!-- HEADER -->
        <div class="form-header">
            <div class="header-left">
                <div class="header-icon">
                    <i class="fas fa-car"></i>
                </div>
                <div>
                    <h2 class="header-title">Tambah Armada Baru</h2>
                    <p class="header-sub">Lengkapi semua data kendaraan dengan benar</p>
                </div>
            </div>
            <a href="{{ route('mobil.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>

        <!-- BODY -->
        <div class="form-body">
            @if($errors->any())
            <div class="alert-errors">
                <i class="fas fa-exclamation-circle" style="margin-right: 0.5rem;"></i>
                <strong>Terdapat kesalahan:</strong>
                <ul>
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="post" action="{{ route('mobil.store') }}" enctype="multipart/form-data" id="formMobil">
                @csrf

                <!-- SECTION 1: INFORMASI KENDARAAN -->
                <div class="section-label">
                    <i class="fas fa-info-circle"></i>
                    Informasi Kendaraan
                </div>
                
                <div class="grid-2">
                    <div class="fgroup">
                        <label for="nama_mobil">
                            <i class="fas fa-car" style="margin-right: 0.5rem; color: var(--primary);"></i>
                            Nama Mobil
                        </label>
                        <input type="text" class="fcontrol" id="nama_mobil" name="nama_mobil"
                            value="{{ old('nama_mobil') }}" placeholder="Contoh: Toyota Avanza" required>
                    </div>
                    
                    <div class="fgroup">
                        <label for="type_id">
                            <i class="fas fa-tag" style="margin-right: 0.5rem; color: var(--primary);"></i>
                            Tipe Mobil
                        </label>
                        <select class="fcontrol" id="type_id" name="type_id" required>
                            <option value="">Pilih Tipe Mobil</option>
                            @foreach($types as $type)
                                <option {{ old('type_id') == $type->id ? 'selected' : '' }} value="{{ $type->id }}">
                                    {{ $type->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="fgroup">
                    <label for="price">
                        <i class="fas fa-money-bill-wave" style="margin-right: 0.5rem; color: var(--primary);"></i>
                        Harga Sewa (Per Hari)
                    </label>
                    <div class="input-prefix">
                        <span class="prefix-text">Rp</span>
                        <input type="number" class="prefix-input" id="price" name="price"
                            value="{{ old('price') }}" placeholder="0" min="0" required>
                    </div>
                </div>

                <!-- SECTION 2: SPESIFIKASI -->
                <div class="section-label">
                    <i class="fas fa-cog"></i>
                    Spesifikasi
                </div>
                
                <div class="grid-3">
                    <div class="fgroup">
                        <label for="pintu">
                            <i class="fas fa-car-door" style="margin-right: 0.5rem; color: var(--primary);"></i>
                            Jumlah Pintu
                        </label>
                        <input type="number" class="fcontrol" id="pintu" name="pintu"
                            value="{{ old('pintu', 4) }}" placeholder="4" min="1" required>
                    </div>
                    
                    <div class="fgroup">
                        <label for="penumpang">
                            <i class="fas fa-users" style="margin-right: 0.5rem; color: var(--primary);"></i>
                            Kapasitas Penumpang
                        </label>
                        <input type="number" class="fcontrol" id="penumpang" name="penumpang"
                            value="{{ old('penumpang', 5) }}" placeholder="5" min="1" required>
                    </div>
                    
                    <div class="fgroup">
                        <label for="status">
                            <i class="fas fa-circle" style="margin-right: 0.5rem; color: var(--primary);"></i>
                            Status Mobil
                        </label>
                        <select class="fcontrol" id="status" name="status" required>
                            @foreach($statuses as $no => $status)
                                <option {{ old('status') == $no ? 'selected' : '' }} value="{{ $no }}">
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- SECTION 3: MEDIA & DESKRIPSI -->
                <div class="section-label">
                    <i class="fas fa-image"></i>
                    Media & Deskripsi
                </div>
                
                <div class="fgroup">
                    <label for="image">
                        <i class="fas fa-camera" style="margin-right: 0.5rem; color: var(--primary);"></i>
                        Foto Mobil
                    </label>
                    <div class="file-upload-wrap" id="uploadWrap">
                        <input type="file" id="image" name="image" accept="image/*" onchange="updateLabel(this)">
                        <div class="file-upload-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </div>
                        <div class="file-upload-text" id="fileLabel">
                            <span>Klik untuk pilih foto</span> atau drag & drop di sini
                        </div>
                        <div style="margin-top: 0.5rem; font-size: 0.75rem; color: var(--text-muted);">
                            Format: JPG, PNG, GIF (Max. 2MB)
                        </div>
                    </div>
                </div>
                
                <div class="fgroup">
                    <label for="description">
                        <i class="fas fa-align-left" style="margin-right: 0.5rem; color: var(--primary);"></i>
                        Deskripsi Tambahan
                    </label>
                    <textarea class="fcontrol" id="description" name="description"
                        placeholder="Fitur unggulan, kondisi kendaraan, atau catatan penting...">{{ old('description') }}</textarea>
                </div>

                <div class="divider"></div>
                
                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="fas fa-save"></i>
                    Simpan Data Armada
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function updateLabel(input) {
    const label = document.getElementById('fileLabel');
    if (input.files && input.files[0]) {
        const fileName = input.files[0].name;
        const fileSize = (input.files[0].size / 1024).toFixed(2);
        label.innerHTML = `<span>${fileName}</span> (${fileSize} KB)`;
    } else {
        label.innerHTML = '<span>Klik untuk pilih foto</span> atau drag & drop di sini';
    }
}

// Form submission loading state
document.getElementById('formMobil').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    submitBtn.classList.add('loading');
    submitBtn.disabled = true;
});

// Drag & drop functionality
const dropZone = document.getElementById('uploadWrap');

['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

['dragenter', 'dragover'].forEach(eventName => {
    dropZone.addEventListener(eventName, highlight, false);
});

['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, unhighlight, false);
});

function highlight(e) {
    dropZone.classList.add('border-primary');
}

function unhighlight(e) {
    dropZone.classList.remove('border-primary');
}

dropZone.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    const input = document.getElementById('image');
    
    input.files = files;
    updateLabel(input);
}

// Number input validation
document.querySelectorAll('input[type="number"]').forEach(input => {
    input.addEventListener('wheel', function(e) {
        e.preventDefault();
    });
});
</script>
@endsection