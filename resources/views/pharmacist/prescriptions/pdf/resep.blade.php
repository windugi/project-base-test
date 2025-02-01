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
    <p>Detail Pemeriksaan: {{ $resep->examination_result }}</p> <!-- Sesuaikan dengan field yang ada di model Examination -->
    <p>Waktu Kunjungan: {{ $resep->created_at }}</p> <!-- Sesuaikan dengan field yang ada di model Examination -->
    <p>Divalidasi: {{ $resep->tanggal_diterima }}</p> <!-- Sesuaikan dengan field yang ada di model Examination -->

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
                    <td>{{ $obat['price'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total Harga: {{ $totalHarga }}</h3> <!-- Menampilkan total harga -->
</body>
</html>