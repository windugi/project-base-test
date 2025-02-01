@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Resep</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID Resep</th>
                <th>Nama Pasien</th>
                <th>Dokter</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prescriptions as $prescription)
            <tr>
                <td>{{ $prescription->id }}</td>
                <td>{{ $prescription->patient->name }}</td>
                <td>{{ $prescription->doctor->name }}</td>
                @if($prescription->status == 'paid')
                    <td>Sudah dilayani</td>
                @elseif($prescription->status == 'pending')
                    <td>Belum dilayani</td>
                @endif
                <td>
                    @if($prescription->status == 'pending')
                        <form action="{{ route('pharmacist.prescriptions.process', $prescription->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success">Layani</button>
                        </form>
                    @endif
                    <a href="{{ route('pharmacist.prescriptions.invoice', $prescription->id) }}" class="btn btn-primary">Cetak Resi</a>
                    <a href="{{ route('pharmacist.prescriptions.show', $prescription->id) }}" class="btn btn-info">
                        Lihat Resep
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
