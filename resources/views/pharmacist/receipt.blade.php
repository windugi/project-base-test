<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resi Pembayaran</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 80%; margin: auto; padding: 20px; border: 1px solid #ddd; }
        h2 { text-align: center; }
        .info { margin-bottom: 20px; }
        .info p { margin: 5px 0; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table, .table th, .table td { border: 1px solid black; }
        .table th, .table td { padding: 10px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Resi Pembayaran</h2>
        <div class="info">
            <p><strong>Nama Pasien:</strong> {{ $prescription->patient_name }}</p>
            <p><strong>Status:</strong> {{ $prescription->status }}</p>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Obat</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach (json_decode($prescription->medications) as $med)
                    <tr>
                        <td>{{ $med }}</td>
                        <td>1</td>
                        <td>Rp 50.000</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p style="text-align:right; margin-top:20px;"><strong>Total: Rp 50.000</strong></p>
    </div>
</body>
</html>
