@extends('layouts.mainadmin')

@section('container')
<div class="m-6">

    <h2 class="text-white">Update Supir</h2>

    <form class="max-w-sm mx-auto" method="post" action="/supir/{{ $supir->noktp }}" enctype="multipart/form-data">
        @method('put')
        @csrf
        <div class="mb-5">
            <label for="noktp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No.KTP</label>
            <input name="noktp" type="text" id="base-input"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('noktp') is-invalid @enderror"
                required value="{{ $supir->noktp }}">
            @error('noktp')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>

        <div class="mb-5">
            <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama Supir</label>
            <input name="nama" type="text" id="base-input"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('nama') is-invalid @enderror"
                required value="{{ $supir->nama }}">
            @error('nama')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>

        <div class="mb-5">
            <label for="alamat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat</label>
            <input name="alamat" type="text" id="base-input"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('alamat') is-invalid @enderror"
                required value="{{ $supir->alamat }}">
            @error('alamat')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>

        <div class="mb-5">
            <label for="nohpsupir" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">No.Hp</label>
            <input name="nohpsupir" type="text" id="base-input"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 @error('nohpsupir') is-invalid @enderror"
                required value="{{ $supir->nohpsupir }}">
            @error('nohpsupir')
            <div class="invalid-feedback">
                {{$message}}
            </div>
            @enderror
        </div>

        <div class="mb-5">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="foto">Upload Gambar
                Mobil</label>
            <input type="hidden" name="oldimage" value="{{ $supir->image }}">
            @if($supir->image)
            <img src="{{ asset('storage/' . $supir->image) }}" class="img-preview"
                style="display: block; max-width: 200px; margin-top: 10px;">
            @else
            <img class="img-preview" style="display: none; max-width: 200px; margin-top: 10px;">
            @endif
            <input id="image" name="image" onchange="previewImage()"
                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                aria-describedby="file_input_help" id="file_input" type="file">
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF (MAX.
                800x400px).
            </p>
        </div>

        <button type="submit"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update
            Supir</button>

    </form>
</div>

<script>
    function previewImage() {
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();

        // Change 'imge' to 'image' in the line below
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function (oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>
@endsection