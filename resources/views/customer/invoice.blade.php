<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script>
    function previewImage() {
        const image = document.querySelector('#bukti');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();

        // Change 'imge' to 'image' in the line below
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
    </script>
</head>

<body class="bg-black">
    <div class="container mx-auto p-10">
        <div class="bg-black text-white border-solid border-2 border-white rounded shadow p-8">
            <div class="flex items-center">
                <div class="font-bold text-yellow-300 text-[15px] mr-3">DVJR</div>
            </div>
            <h1 class="text-3xl font-bold mb-5">Invoice #{{ $sewa->no_invoice }}</h1>
            <div class="flex justify-between items-center mb-5">
                <div>
                    <h2 class="text-xl font-bold mb-3">Rincian Pemesanan</h2>
                    <table>
                        <tbody>
                            <tr>
                                <td>Nama: </td>
                                <td>: {{ $sewa->nama_customer }}</td>
                            </tr>
                            <tr>
                                <td>Nomor Telepon </td>
                                <td> : {{ $sewa->nohp }}</td>
                            </tr>
                            <tr>
                                <td>Alamat </td>
                                <td>: {{ $sewa->alamat }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <h2 class="text-xl font-bold mb-3">Tanggal</h2>
                    <p>{{ $sewa->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
            <table class="table-auto w-full mb-5">
                <tbody>
                    <tr>
                        <td class="border px-4 py-2 font-bold"></td>
                        <td class="border px-4 py-2 font-bold">Keterangan</td>
                        <td class="border px-4 py-2 font-bold">Harga</td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2 font-bold">Mobil</td>
                        <td class="border px-4 py-2">{{ $sewa->nama_mobil }}</td>
                        @if(isset($sewa) && isset($mobil) && $sewa->nama_mobil == $mobil->nama_mobil)
                        <td class="border px-4 py-2">Rp. {{ $mobil->sewa }}</td>
                        @endif
                    </tr>
                </tbody>
                <tbody>
                    <tr>
                        <td class="border px-4 py-2 font-bold">Supir</td>
                        <td class="border px-4 py-2">{{ $sewa->nama_supir }}</td>
                        @if(isset($sewa) && isset($supir) && $sewa->nama_supir == $supir->nama)
                        <td class="border px-4 py-2">Rp. {{ ($supir->sewa) }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td class="border px-4 py-2 font-bold">Tanggal Ambil</td>
                        <td class="border px-4 py-2 text-blue-500">{{ $sewa->tanggal_pinjam}}</td>
                        <td class="border px-4 py-2" rowspan=2></td>
                    </tr>
                    <tr>
                        <td class="border px-4 py-2 font-bold">Tanggal Kembali</td>
                        <td class="border px-4 py-2 text-red-500"> {{ $sewa->tanggal_kembali}}</td>
                    </tr>
                    <tr>
                        <td colspan=2 class="border px-4 py-2 font-bold text-right">Total</td>
                        <td class="border px-4 py-2 font-bold">Rp. {{ $sewa->total_biaya }}</td>
                    </tr>
                    <tr>
                        <td colspan=2 class="border px-4 py-2 font-bold text-right">DP</td>
                        <td class="border px-4 py-2 font-bold">Rp. {{ number_format($sewa->total_biaya * 0.25, 2) }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="flex justify-between p-4">
                <div>
                    <h3 class="text-xl text-red-600">Harap Diperhatikan :</h3>
                    <ul class="text-xs list-disc list-inside">
                        <li>Bawa nota ini pada saat pengambilan mobil (Capture Invoice ini).</li>
                        <li>Riwayat pemesanan anda dapat dibatalkan jika terindikasi melakukan penipuan (Mengirimkan
                            bukti transfer palsu).</li>
                        <li>Jika anda tidak melakukan pembayaran sampai tanggal pengambilan, maka transaksi dianggap
                            hangus.</li>
                        <li>Pembayaran DP dapat dilakukan dengan transfer ke nomor rekening yang ada.</li>
                        <li>Silakan unggah bukti transfer ke submission dibawah ini.</li>
                    </ul>
                </div>
                <div class="p-4">
                    <h3>No. Rekening: </h3>
                    <div class="text-4xl italic text-indigo-500">123456789</div>
                    <h6><i>*rekening atas nama AJITAMA JAYA</i></h6>
                </div>
            </div>
            <div class="p-4">
                <form action="{{ route('invoice') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <label class="block mb-2 text-sm font-medium text-white dark:text-white" for="bukti">Upload
                        bukti</label>
                    <img class="img-preview" style="display: none; max-width: 200px; margin-top: 10px;">
                    <input id="bukti" name="bukti" onchange="previewImage()"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        aria-describedby="file_input_help" id="file_input" type="file">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG or GIF
                        (MAX. 800x400px).</p>
                    <button class="px-4 py-2 text-sm text-white bg-blue-500">Kirim</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>