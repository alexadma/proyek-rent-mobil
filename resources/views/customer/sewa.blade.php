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
                    <!-- @foreach ($customers as $customer) -->
                    @if(isset($customer) && $customer->username == auth()->user()->username)
                    <input
                        class="nama shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="nama" name="nama" type="text" value="{{ $customer->nama}}" required>
                    @endif
                    <!-- @endforeach -->
                </div>
                <div>
                    <label class="block text-white text-sm font-bold mb-2" for="nohp">
                        {{ __('No. Hp')}}
                    </label>
                    @if(isset($customer) && $customer->username == auth()->user()->username)
                    <input
                        class="nohp shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        id="nohp" name="nohp" type="text" value="{{ $customer->nohp}}" required>
                    @endif
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
                    @if(isset($customer) && $customer->username == auth()->user()->username)
                    <input
                        class="alamat shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        name="alamat" id="alamat" type="text" value="{{ $customer->alamat}}" required>
                    @endif
                </div>

                <div>
                    <label class="block text-white text-sm font-bold mb-2" for="jaminan">
                        {{ __('Jaminan')}}
                    </label>
                    <input
                        class="jaminan cursor-not-allowed shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        name="jaminan" id="jaminan" type="text" value="KTP" disable readonly>
                </div>


                <div>
                    <label for="mobil" class="text-white">Pilih Mobil:</label>
                    <select name="mobil" id="mobil"
                        class="block appearance-none w-full bg-white border border-gray-400 hover:border-gray-500 px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline">
                        @foreach($mobils as $mobil)
                        <option value="{{$mobil->nama_mobil}}" data-price="{{$mobil->sewa}}">
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
                    <input
                        class="durasi cursor-not-allowed shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        name="durasi" id="durasi" type="hidden" value="24">
                </div>

                <div>
                    <label for="total" class="text-white font-bold">TOTAL BAYAR:</label>
                    <input
                        class="total cursor-not-allowed shadow appearance-none border rounded py-2 px-3 text-black text-center font-bold focus:outline-none focus:shadow-outline"
                        name="total" id="total" type="text" value="{{ $mobil->sewa + $supir->sewa}}" readonly>

                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script>
                    $(document).ready(function() {
                        // Ketika pilihan mobil atau supir berubah
                        $('#mobil, #supir').change(function() {
                            // Ambil harga dari pilihan mobil dan supir
                            var mobil_price = $('#mobil option:selected').data('price');
                            var supir_price = $('#supir option:selected').data('price');


                            // Hitung total harga
                            var total = mobil_price + supir_price;

                            // Update total harga
                            $('#total').val(total);

                        });
                    });
                    </script>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                </div>

                <div>
                    <label class="block text-white text-sm font-bold mb-2" for="nopol">
                        @foreach($mobils as $mobil)
                        <input
                            class="nopol cursor-not-allowed shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            name="nopol" id="nopol" type="hidden" value="{{$mobil->nopol}}">
                        @endforeach
                    </label>

                </div>



        </form>

    </div>
</div>
@endsection