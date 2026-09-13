@extends('layouts.mainsewa')

@section('container')
<style>
    :root {
        --gold: #facc15;
        --gold-dark: #eab308;
        --dark: #0a0a0a;
        --dark-card: #141414;
        --dark-input: #1e1e1e;
        --border: #2a2a2a;
        --text-primary: #f5f5f5;
        --text-secondary: #a3a3a3;
        --text-muted: #6b6b6b;
        --danger: #ef4444;
        --success: #22c55e;
    }

    .sewa-wrapper {
        min-height: calc(100vh - 80px);
        background: var(--dark);
        padding: 2rem 0;
    }

    .sewa-container {
        max-width: 960px;
        margin: 0 auto;
        padding: 0 1rem;
    }

    .sewa-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }
    .sewa-header h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }
    .sewa-header h1 span {
        color: var(--gold);
    }
    .sewa-header p {
        color: var(--text-secondary);
        font-size: 0.95rem;
    }

    .sewa-card {
        background: var(--dark-card);
        border: 1px solid var(--border);
        border-radius: 1rem;
        padding: 1.75rem;
        margin-bottom: 1.5rem;
    }
    .sewa-card-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border);
    }
    .sewa-card-header .icon-box {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--gold), var(--gold-dark));
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .sewa-card-header .icon-box i {
        color: #000;
        font-size: 1rem;
    }
    .sewa-card-header h2 {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .sewa-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
    }
    .sewa-grid .full-width {
        grid-column: 1 / -1;
    }

    .sewa-group {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }
    .sewa-group label {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .sewa-group label .required {
        color: var(--danger);
        margin-left: 2px;
    }

    .sewa-input,
    .sewa-select {
        width: 100%;
        padding: 0.7rem 0.9rem;
        background: var(--dark-input);
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        color: var(--text-primary);
        font-size: 0.95rem;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
    }
    .sewa-input:focus,
    .sewa-select:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(250, 204, 21, 0.1);
    }
    .sewa-input:read-only {
        opacity: 0.8;
        cursor: not-allowed;
    }
    .sewa-input.error,
    .sewa-select.error {
        border-color: var(--danger);
    }

    .sewa-select {
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23a3a3a3' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.9rem center;
        padding-right: 2.5rem;
        cursor: pointer;
    }
    .sewa-select option {
        background: var(--dark-card);
        color: var(--text-primary);
    }

    .sewa-error {
        color: var(--danger);
        font-size: 0.8rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }
    .sewa-error i { font-size: 0.75rem; }

    .durasi-display {
        background: var(--dark-input);
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        padding: 0.7rem 0.9rem;
        min-height: 44px;
        display: flex;
        align-items: center;
    }
    .durasi-display .durasi-text {
        font-size: 0.95rem;
        color: var(--gold);
        font-weight: 600;
    }
    .durasi-display .durasi-placeholder {
        font-size: 0.9rem;
        color: var(--text-muted);
        font-style: italic;
    }

    .summary-card {
        background: linear-gradient(145deg, #1a1a1a, #111);
        border: 1px solid var(--gold);
        border-radius: 1rem;
        padding: 1.75rem;
        margin-bottom: 1.5rem;
    }
    .summary-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.25rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border);
    }
    .summary-header .icon-box {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--gold), var(--gold-dark));
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .summary-header .icon-box i { color: #000; font-size: 1rem; }
    .summary-header h2 { font-size: 1.1rem; font-weight: 600; color: var(--text-primary); margin: 0; }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.6rem 0;
        border-bottom: 1px solid rgba(255,255,255,0.04);
    }
    .summary-row:last-child { border-bottom: none; }
    .summary-row .label { color: var(--text-secondary); font-size: 0.9rem; }
    .summary-row .value { color: var(--text-primary); font-size: 0.9rem; font-weight: 500; text-align: right; }
    .summary-row .value.gold { color: var(--gold); font-weight: 600; }

    .summary-divider {
        border: none;
        border-top: 1px solid var(--border);
        margin: 0.75rem 0;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: rgba(250, 204, 21, 0.08);
        border: 1px solid rgba(250, 204, 21, 0.2);
        border-radius: 0.75rem;
        margin-top: 0.75rem;
    }
    .summary-total .total-label {
        font-size: 1rem;
        font-weight: 700;
        color: var(--text-primary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .summary-total .total-value {
        font-size: 1.35rem;
        font-weight: 800;
        color: var(--gold);
    }

    .sewa-submit {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, var(--gold), var(--gold-dark));
        border: none;
        border-radius: 0.75rem;
        color: #000;
        font-size: 1rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .sewa-submit:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(250, 204, 21, 0.3);
    }
    .sewa-submit:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    .sewa-submit:active:not(:disabled) {
        transform: translateY(0);
    }

    .sewa-alert {
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .sewa-alert.alert-danger {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        color: #fca5a5;
    }

    .pickup-icon { color: var(--gold); margin-right: 3px; }
    .return-icon { color: var(--gold); margin-right: 3px; }

    @media (max-width: 768px) {
        .sewa-grid { grid-template-columns: 1fr; }
        .sewa-card, .summary-card { padding: 1.25rem; }
        .sewa-header h1 { font-size: 1.35rem; }
        .summary-total .total-value { font-size: 1.15rem; }
    }

    @media (max-width: 480px) {
        .sewa-wrapper { padding: 1rem 0; }
        .sewa-card, .summary-card { padding: 1rem; border-radius: 0.75rem; }
    }
</style>

<div class="sewa-wrapper">
    <div class="sewa-container">
        <div class="sewa-header">
            <h1>Formulir <span>Penyewaan Mobil</span></h1>
            <p>Lengkapi data di bawah untuk melakukan pemesanan kendaraan</p>
        </div>

        @if ($errors->any())
            <div class="sewa-alert alert-danger">
                <i class="fas fa-exclamation-circle"></i>
                <span>Terjadi kesalahan. Silakan periksa kembali form Anda.</span>
            </div>
        @endif

        <form action="{{ route('sewa') }}" method="POST" id="sewaForm">
            @csrf

            {{-- ====== DATA PENYEWA ====== --}}
            <div class="sewa-card">
                <div class="sewa-card-header">
                    <div class="icon-box"><i class="fas fa-user"></i></div>
                    <h2>Data Penyewa</h2>
                </div>
                <div class="sewa-grid">
                    <div class="sewa-group">
                        <label for="nama">Nama Lengkap <span class="required">*</span></label>
                        <input class="sewa-input @error('nama') error @enderror" type="text" id="nama" name="nama"
                            value="{{ old('nama', $customer->nama ?? '') }}" placeholder="Masukkan nama lengkap" required>
                        @error('nama')
                            <div class="sewa-error"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sewa-group">
                        <label for="nohp">No. Handphone <span class="required">*</span></label>
                        <input class="sewa-input @error('nohp') error @enderror" type="text" id="nohp" name="nohp"
                            value="{{ old('nohp', $customer->nohp ?? '') }}" placeholder="Contoh: 08123456789" required>
                        @error('nohp')
                            <div class="sewa-error"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sewa-group full-width">
                        <label for="alamat">Alamat <span class="required">*</span></label>
                        <input class="sewa-input @error('alamat') error @enderror" type="text" id="alamat" name="alamat"
                            value="{{ old('alamat', $customer->alamat ?? '') }}" placeholder="Masukkan alamat lengkap" required>
                        @error('alamat')
                            <div class="sewa-error"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sewa-group">
                        <label for="jaminan">Jaminan <span class="required">*</span></label>
                        <input class="sewa-input" type="text" id="jaminan" name="jaminan"
                            value="{{ old('jaminan', 'KTP') }}" readonly style="cursor:not-allowed; opacity:0.7;">
                    </div>
                </div>
            </div>

            {{-- ====== DETAIL PENYEWAAN ====== --}}
            <div class="sewa-card">
                <div class="sewa-card-header">
                    <div class="icon-box"><i class="fas fa-car"></i></div>
                    <h2>Detail Penyewaan</h2>
                </div>
                <div class="sewa-grid">
                    <div class="sewa-group">
                        <label for="pickup_datetime">
                            <i class="fas fa-calendar-check pickup-icon"></i>
                            Tanggal & Waktu Pengambilan <span class="required">*</span>
                        </label>
                        <input class="sewa-input @error('pickup_datetime') error @enderror" type="datetime-local"
                            id="pickup_datetime" name="pickup_datetime"
                            value="{{ old('pickup_datetime') }}" required>
                        @error('pickup_datetime')
                            <div class="sewa-error"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sewa-group">
                        <label for="return_datetime">
                            <i class="fas fa-calendar-minus return-icon"></i>
                            Tanggal & Waktu Pengembalian <span class="required">*</span>
                        </label>
                        <input class="sewa-input @error('return_datetime') error @enderror" type="datetime-local"
                            id="return_datetime" name="return_datetime"
                            value="{{ old('return_datetime') }}" required>
                        @error('return_datetime')
                            <div class="sewa-error"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sewa-group">
                        <label for="mobil">Pilih Mobil <span class="required">*</span></label>
                        <select class="sewa-select @error('mobil') error @enderror" name="mobil" id="mobil" required>
                            <option value="">-- Pilih Kendaraan --</option>
                            @foreach($mobils as $mobil)
                                <option value="{{ $mobil->nama_mobil }}"
                                    data-price="{{ $mobil->sewa }}"
                                    data-nopol="{{ $mobil->nopol }}"
                                    {{ old('mobil') == $mobil->nama_mobil ? 'selected' : '' }}>
                                    {{ $mobil->nama_mobil }} — Rp {{ number_format($mobil->sewa, 0, ',', '.') }}/hari
                                </option>
                            @endforeach
                        </select>
                        @error('mobil')
                            <div class="sewa-error"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sewa-group">
                        <label for="supir">Pilih Supir <span class="required">*</span></label>
                        <select class="sewa-select @error('supir') error @enderror" name="supir" id="supir" required>
                            <option value="TANPA SUPIR" data-price="0"
                                {{ old('supir', 'TANPA SUPIR') == 'TANPA SUPIR' ? 'selected' : '' }}>
                                🚫 Tanpa Supir (Rp 0)
                            </option>
                            @foreach($supirs as $supir)
                                <option value="{{ $supir->nama }}"
                                    data-price="{{ $supir->sewa }}"
                                    {{ old('supir') == $supir->nama ? 'selected' : '' }}>
                                    {{ $supir->nama }} — Rp {{ number_format($supir->sewa, 0, ',', '.') }}/hari
                                </option>
                            @endforeach
                        </select>
                        @error('supir')
                            <div class="sewa-error"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="sewa-group full-width">
                        <label>
                            <i class="fas fa-clock" style="color:var(--gold);margin-right:3px;"></i>
                            Durasi Sewa
                        </label>
                        <div class="durasi-display" id="durasiDisplay">
                            <span class="durasi-placeholder" id="durasiPlaceholder">Pilih tanggal pengambilan & pengembalian</span>
                            <span class="durasi-text" id="durasiText" style="display:none;"></span>
                        </div>
                    </div>

                    <input type="hidden" name="nopol" id="nopol" value="{{ old('nopol') }}">
                </div>
            </div>

            {{-- ====== RINGKASAN PEMBAYARAN ====== --}}
            <div class="summary-card">
                <div class="summary-header">
                    <div class="icon-box"><i class="fas fa-receipt"></i></div>
                    <h2>Ringkasan Pembayaran</h2>
                </div>

                <div class="summary-row">
                    <span class="label">Mobil</span>
                    <span class="value" id="sumMobil">-</span>
                </div>
                <div class="summary-row">
                    <span class="label">Supir</span>
                    <span class="value" id="sumSupir">-</span>
                </div>
                <div class="summary-row">
                    <span class="label">Durasi</span>
                    <span class="value" id="sumDurasi">-</span>
                </div>

                <hr class="summary-divider">

                <div class="summary-row">
                    <span class="label">Harga Mobil</span>
                    <span class="value gold" id="sumHargaMobil">Rp 0</span>
                </div>
                <div class="summary-row">
                    <span class="label">Biaya Supir</span>
                    <span class="value" id="sumHargaSupir">Rp 0</span>
                </div>
                <div class="summary-row">
                    <span class="label">Harga × Durasi</span>
                    <span class="value" id="sumPerhitungan">Rp 0 × 1 Hari</span>
                </div>

                <div class="summary-total">
                    <span class="total-label">Total Bayar</span>
                    <span class="total-value" id="sumTotal">Rp 0</span>
                </div>
            </div>

            <div class="sewa-submit-wrapper">
                <button type="submit" class="sewa-submit" id="submitBtn">
                    <i class="fas fa-paper-plane"></i>
                    Ajukan Penyewaan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
(function() {
    const mobilSelect = document.getElementById('mobil');
    const supirSelect = document.getElementById('supir');
    const pickupInput = document.getElementById('pickup_datetime');
    const returnInput = document.getElementById('return_datetime');
    const submitBtn = document.getElementById('submitBtn');
    const nopolInput = document.getElementById('nopol');

    const durasiPlaceholder = document.getElementById('durasiPlaceholder');
    const durasiText = document.getElementById('durasiText');
    const sumMobil = document.getElementById('sumMobil');
    const sumSupir = document.getElementById('sumSupir');
    const sumDurasi = document.getElementById('sumDurasi');
    const sumHargaMobil = document.getElementById('sumHargaMobil');
    const sumHargaSupir = document.getElementById('sumHargaSupir');
    const sumPerhitungan = document.getElementById('sumPerhitungan');
    const sumTotal = document.getElementById('sumTotal');

    function formatRupiah(num) {
        return 'Rp ' + num.toLocaleString('id-ID');
    }

    function calcDuration(pickup, returnDt) {
        if (!pickup || !returnDt) return null;
        var diffMs = new Date(returnDt) - new Date(pickup);
        if (diffMs <= 0) return null;
        var totalHours = Math.ceil(diffMs / (1000 * 60 * 60));
        if (totalHours < 1) totalHours = 1;
        var days = Math.floor(totalHours / 24);
        var hours = totalHours % 24;
        var text = '';
        if (days > 0) text += days + ' Hari';
        if (hours > 0) text += (days > 0 ? ' ' : '') + hours + ' Jam';
        if (!text) text = '1 Hari';
        return { totalHours: totalHours, days: days, hours: hours, text: text, hari: Math.max(1, Math.ceil(totalHours / 24)) };
    }

    function updateSummary() {
        var mobilOpt = mobilSelect.options[mobilSelect.selectedIndex];
        var supirOpt = supirSelect.options[supirSelect.selectedIndex];
        var mobilPrice = parseInt(mobilOpt.getAttribute('data-price')) || 0;
        var supirPrice = parseInt(supirOpt.getAttribute('data-price')) || 0;
        var mobilName = mobilSelect.value || '-';
        var supirName = supirSelect.value === 'TANPA SUPIR' ? 'Tanpa Supir' : (supirSelect.value || '-');
        var nopol = mobilOpt.getAttribute('data-nopol') || '';
        nopolInput.value = nopol;

        var pickup = pickupInput.value;
        var returnDt = returnInput.value;
        var durasi = calcDuration(pickup, returnDt);

        // Durasi display
        if (durasi) {
            durasiPlaceholder.style.display = 'none';
            durasiText.style.display = 'inline';
            durasiText.textContent = durasi.text + ' (' + durasi.totalHours + ' Jam)';
        } else {
            durasiPlaceholder.style.display = 'inline';
            durasiText.style.display = 'none';
        }

        var hari = durasi ? durasi.hari : 1;
        var total = (mobilPrice + supirPrice) * hari;

        sumMobil.textContent = mobilName;
        sumSupir.textContent = supirName;
        sumDurasi.textContent = durasi ? durasi.text : '-';
        sumHargaMobil.textContent = formatRupiah(mobilPrice);
        sumHargaSupir.textContent = supirSelect.value === 'TANPA SUPIR' ? 'Rp 0' : formatRupiah(supirPrice);
        sumPerhitungan.textContent = formatRupiah(mobilPrice + supirPrice) + ' × ' + hari + ' Hari';
        sumTotal.textContent = formatRupiah(total);

        // Validate return after pickup
        if (pickup && returnDt) {
            if (new Date(returnDt) <= new Date(pickup)) {
                returnInput.setCustomValidity('Tanggal pengembalian harus setelah tanggal pengambilan.');
                submitBtn.disabled = true;
            } else {
                returnInput.setCustomValidity('');
                submitBtn.disabled = false;
            }
        } else {
            submitBtn.disabled = false;
        }
    }

    // Set minimum dates
    function setMinDates() {
        var now = new Date();
        var yyyy = now.getFullYear();
        var mm = String(now.getMonth() + 1).padStart(2, '0');
        var dd = String(now.getDate()).padStart(2, '0');
        var hh = String(now.getHours()).padStart(2, '0');
        var mi = String(now.getMinutes()).padStart(2, '0');
        var minStr = yyyy + '-' + mm + '-' + dd + 'T' + hh + ':' + mi;
        pickupInput.setAttribute('min', minStr);

        if (pickupInput.value) {
            returnInput.setAttribute('min', pickupInput.value);
        }
    }

    mobilSelect.addEventListener('change', updateSummary);
    supirSelect.addEventListener('change', updateSummary);
    pickupInput.addEventListener('change', function() {
        if (pickupInput.value) {
            var pickupDate = new Date(pickupInput.value);
            var yyyy = pickupDate.getFullYear();
            var mm = String(pickupDate.getMonth() + 1).padStart(2, '0');
            var dd = String(pickupDate.getDate()).padStart(2, '0');
            var hh = String(pickupDate.getHours()).padStart(2, '0');
            var mi = String(pickupDate.getMinutes()).padStart(2, '0');
            returnInput.setAttribute('min', yyyy + '-' + mm + '-' + dd + 'T' + hh + ':' + mi);
        }
        updateSummary();
    });
    returnInput.addEventListener('change', updateSummary);

    setMinDates();
    updateSummary();
})();
</script>
@endsection
