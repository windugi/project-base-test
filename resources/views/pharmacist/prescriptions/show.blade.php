@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Resep</h2>
    <div class="card">
        <div class="card-body">
            <h5>Nama Pasien: {{ $prescription->patient->name }}</h5>
            <p>Dokter: {{ $prescription->doctor->name }}</p>
            <p>Status: {{ $prescription->status }}</p>
            <h5>Daftar Obat:</h5>
            <ul>
                @foreach ($obatDetails as $obat)
                    <li>{{ $obat['name'] }} - {{ $obat['price'] }}</li>
                @endforeach
            </ul>
            <h5>Total Harga: {{ $totalHarga }}</h5>

            <a href="{{ route('pharmacist.dashboard') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
