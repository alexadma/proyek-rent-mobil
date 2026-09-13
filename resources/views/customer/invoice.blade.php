<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Invoice</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        body { background: #111111; }
        .invoice-card { background: #1a1a1a; border: 1px solid rgba(201,168,76,0.2); }
        .invoice-card td, .invoice-card th { color: #e5e5e5; border-color: #333; }
        .invoice-card th { background: #222; color: #C9A84C; }
        .invoice-card .text-muted { color: #999; }
    </style>
    <script>
    function previewImage() {
        const image = document.querySelector('#bukti');
        const imgPreview = document.querySelector('.img-preview');
        imgPreview.style.display = 'block';
        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);
        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
    </script>
</head>

<body>
    <div class="container mx-auto p-10">
        <div class="invoice-card text-gray-100 rounded-xl shadow-lg p-8">
            <div class="flex items-center mb-2">
                <div class="font-bold text-yellow-300 text-[15px] mr-3">DVJR</div>
            </div>
            <h1 class="text-3xl font-bold mb-5 text-white">Invoice #{{ $sewa->no_invoice }}</h1>
            <div class="flex justify-between items-center mb-5">
                <div>
                    <h2 class="text-xl font-bold mb-3 text-white">Rincian Pemesanan</h2>
                    <table>
                        <tbody>
                            <tr>
                                <td class="text-gray-300">Nama</td>
                                <td class="text-gray-300">: {{ $sewa->nama_customer }}</td>
                            </tr>
                            <tr>
                                <td class="text-gray-300">Nomor Telepon</td>
                                <td class="text-gray-300">: {{ $sewa->nohp }}</td>
                            </tr>
                            <tr>
                                <td class="text-gray-300">Alamat</td>
                                <td class="text-gray-300">: {{ $sewa->alamat }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div>
                    <h2 class="text-xl font-bold mb-3 text-white">Tanggal</h2>
                    <p class="text-gray-300">{{ $sewa->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
            <table class="table-auto w-full mb-5">
                <thead>
                    <tr>
                        <th class="border border-gray-600 px-4 py-2 text-left"></th>
                        <th class="border border-gray-600 px-4 py-2 text-left">Keterangan</th>
                        <th class="border border-gray-600 px-4 py-2 text-left">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-600 px-4 py-2 font-bold text-gray-200">Mobil</td>
                        <td class="border border-gray-600 px-4 py-2 text-gray-200">{{ $sewa->nama_mobil }}</td>
                        @if(isset($sewa) && isset($mobil) && $sewa->nama_mobil == $mobil->nama_mobil)
                        <td class="border border-gray-600 px-4 py-2 text-gray-200">Rp {{ number_format($mobil->sewa, 0, ',', '.') }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td class="border border-gray-600 px-4 py-2 font-bold text-gray-200">Supir</td>
                        <td class="border border-gray-600 px-4 py-2 text-gray-200">{{ $sewa->nama_supir }}</td>
                        @if(isset($sewa) && isset($supir) && $sewa->nama_supir == $supir->nama)
                        <td class="border border-gray-600 px-4 py-2 text-gray-200">Rp {{ number_format($supir->sewa, 0, ',', '.') }}</td>
                        @endif
                    </tr>
                    <tr>
                        <td class="border border-gray-600 px-4 py-2 font-bold text-gray-200">Tanggal Ambil</td>
                        <td class="border border-gray-600 px-4 py-2 text-blue-400">{{ $sewa->tanggal_pinjam }}</td>
                        <td class="border border-gray-600 px-4 py-2" rowspan=2></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-600 px-4 py-2 font-bold text-gray-200">Tanggal Kembali</td>
                        <td class="border border-gray-600 px-4 py-2 text-red-400">{{ $sewa->tanggal_kembali }}</td>
                    </tr>
                    <tr>
                        <td colspan=2 class="border border-gray-600 px-4 py-2 font-bold text-right text-gray-200">Total</td>
                        <td class="border border-gray-600 px-4 py-2 font-bold text-green-400">Rp {{ number_format($sewa->total_biaya, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan=2 class="border border-gray-600 px-4 py-2 font-bold text-right text-gray-200">DP (25%)</td>
                        <td class="border border-gray-600 px-4 py-2 font-bold text-yellow-300">Rp {{ number_format($sewa->total_biaya * 0.25, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="flex justify-between p-4">
                <div>
                    <h3 class="text-xl text-red-400 font-bold mb-2">Harap Diperhatikan :</h3>
                    <ul class="text-sm text-gray-300 list-disc list-inside space-y-1">
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
                    <h3 class="text-gray-300 font-bold">No. Rekening: </h3>
                    <div class="text-4xl italic text-indigo-400 font-bold">123456789</div>
                    <h6 class="text-gray-400 mt-1"><i>*rekening atas nama AJITAMA JAYA</i></h6>
                </div>
            </div>
            <div class="p-4">
                <form action="{{ route('invoice') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <label class="block mb-2 text-sm font-medium text-gray-200" for="bukti">Upload Bukti Transfer</label>
                    <img class="img-preview" style="display: none; max-width: 200px; margin-top: 10px; border-radius: 8px;">
                    <input id="bukti" name="bukti" onchange="previewImage()"
                        class="block w-full text-sm text-gray-200 border border-gray-500 rounded-lg cursor-pointer bg-gray-700 focus:outline-none focus:border-yellow-400"
                        aria-describedby="file_input_help" type="file">
                    <p class="mt-1 text-sm text-gray-400" id="file_input_help">SVG, PNG, JPG or GIF (MAX. 800x400px).</p>
                    <button class="mt-2 px-6 py-2 text-sm font-bold text-black bg-yellow-400 rounded-lg hover:bg-yellow-300 transition">Kirim</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>