<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resi Pembayaran Resep</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Resi Pembayaran Resep</h1>
    <h2>Data Pemeriksaan</h2>
    <p>ID Pemeriksaan: {{ $resep->id }}</p>
    <p>Detail Pemeriksaan: {{ $resep->examination_result }}</p>
    <p>Waktu Kunjungan: {{ $resep->created_at }}</p>
    <p>Divalidasi: {{ $resep->tanggal_diterima }}</p>

    <!-- Menampilkan file yang diunggah jika ada -->
    @if($resep->examination_letter)
        <h2>File Surat Pemeriksaan:</h2>
        <img src="{{ public_path($resep->examination_letter) }}" alt="Surat Pemeriksaan" style="max-width: 50%; height: auto;">
    @else
        <p>Tidak ada file surat pemeriksaan yang diunggah.</p>
    @endif

    <h2>Daftar Obat</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Obat</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($obatDetails as $obat)
                <tr>
                    <td>{{ $obat['name'] }}</td>
                    <td>{{ formatRupiah($obat['price']) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total Harga:  {{ formatRupiah($totalHarga) }}</h3>
</body>
</html>