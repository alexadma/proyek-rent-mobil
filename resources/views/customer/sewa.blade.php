<link rel="stylesheet" href="/css/sewa.css" class="">
@extends('layouts.mainsewa')

@section('container')
<div class="bg-black ">
    <div class="layout">
        <h1 class="judul">Formulir Pengisian Penyewaan Mobil</h1>

        <form action="{{ route('sewa') }}" method="POST">
            @csrf
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label class="block text-white text-sm font-bold mb-2" for="nama">
                        {{ __('Nama')}}
                    </label>
                    <input
                        class="nama shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="nama" name="nama" type="text" value="{{ old('nama', $customer->nama ?? '') }}" required>
                </div>
                <div>
                    <label class="block text-white text-sm font-bold mb-2" for="nohp">
                        {{ __('No. Hp')}}
                    </label>
                    <input
                        class="nohp shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="nohp" name="nohp" type="text" value="{{ old('nohp', $customer->nohp ?? '') }}" required>
                </div>
                <div>
                    <label class="block text-white text-sm font-bold mb-2" for="tgl_pjm">
                        {{ __('Waktu Peminjaman')}}
                    </label>
                    <input
                        class="tgl_pjm shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('tgl_pjm') is-invalid @enderror"
                        id="tgl_pjm" name="tgl_pjm" type="datetime-local" required>
                    @error('tgl_pjm')
                    <div class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>

                <div>
                    <label class="block text-white text-sm font-bold mb-2" for="alamat">
                        {{ __('Alamat')}}
                    </label>
                    <input
                        class="alamat shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        name="alamat" id="alamat" type="text" value="{{ old('alamat', $customer->alamat ?? '') }}" required>
                </div>

                <div>
                    <label class="block text-white text-sm font-bold mb-2" for="jaminan">
                        {{ __('Jaminan')}}
                    </label>
                    <input
                        class="jaminan cursor-not-allowed shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        name="jaminan" id="jaminan" type="text" value="KTP" readonly>
                </div>


                <div>
                    <label for="mobil" class="text-white">Pilih Mobil:</label>
                    <select name="mobil" id="mobil"
                        class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        @foreach($mobils as $mobil)
                        <option value="{{$mobil->nama_mobil}}" data-price="{{$mobil->sewa}}" data-nopol="{{ $mobil->nopol }}">
                            {{ $mobil->nama_mobil }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="supir" class="text-white">Pilih Supir:</label>
                    <select name="supir" id="supir"
                        class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        @foreach($supirs as $supir)
                        <option value="{{ $supir->nama }}" data-price="{{$supir->sewa}}">{{ $supir->nama}}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="durasi" class="text-white">Durasi Sewa (Jam):</label>
                    <input
                        class="durasi shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        name="durasi" id="durasi" type="number" min="1" max="720" value="{{ old('durasi', 24) }}" required>
                </div>

                <div>
                    <input name="nopol" id="nopol" type="hidden" value="">
                </div>

                <div>
                    <label for="total" class="text-white font-bold">TOTAL BAYAR:</label>
                    <input
                        class="total cursor-not-allowed shadow appearance-none border rounded py-2 px-3 text-black text-center font-bold focus:outline-none focus:shadow-outline"
                        name="total" id="total" type="text" value="0" readonly>

                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script>
                    $(document).ready(function() {
                        function hitungTotal() {
                            var mobil_price = parseInt($('#mobil option:selected').data('price')) || 0;
                            var supir_price = parseInt($('#supir option:selected').data('price')) || 0;
                            var durasi = parseInt($('#durasi').val()) || 24;
                            var hari = Math.max(1, Math.ceil(durasi / 24));
                            var total = (mobil_price + supir_price) * hari;
                            $('#total').val(total.toLocaleString('id-ID'));

                            var nopol = $('#mobil option:selected').data('nopol') || '';
                            $('#nopol').val(nopol);
                        }

                        // Isi nilai awal berdasarkan pilihan pertama
                        hitungTotal();

                        // Ketika pilihan mobil, supir, atau durasi berubah
                        $('#mobil, #supir, #durasi').on('change input', function() {
                            hitungTotal();
                        });
                    });
                    </script>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </div>



        </form>

    </div>
</div>
@endsection