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
                    <li>{{ $obat['name'] }} - {{ formatRupiah($obat['price']) }}</li>
                @endforeach
            </ul>
            <h5>Total Harga: {{ formatRupiah($totalHarga) }}</h5>

            <!-- Menampilkan file yang diunggah jika ada -->
            @if($prescription->examination_letter)
                <h5>File Surat Pemeriksaan:</h5>
                <a href="{{ asset($prescription->examination_letter) }}" target="_blank">Lihat Surat</a>
                <img src="{{ asset($prescription->examination_letter) }}" alt="Surat Pemeriksaan" style="max-width: 50%; height: auto;">
            @else
                <p>Tidak ada file surat pemeriksaan yang diunggah.</p>
            @endif

            <a href="{{ route('pharmacist.dashboard') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection