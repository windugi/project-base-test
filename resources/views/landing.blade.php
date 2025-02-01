<!-- resources/views/landing.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container text-center" style="margin-top: 100px;">
        <h1>Selamat Datang di Aplikasi Resep Obat</h1>
        <p>Pilih opsi login Anda:</p>
        <a href="{{ route('login.doctor') }}" class="btn btn-primary">Login sebagai Dokter</a>
        <a href="{{ route('login.pharmacist') }}" class="btn btn-success">Login sebagai Apoteker</a>
    </div>
</body>
</html>