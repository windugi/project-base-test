@extends('adminlte::page')

@section('title', 'Dashboard Dokter')

@section('content_header')
    <h1>Daftar Resep Pasien</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Resep Pasien</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pasien</th>
                        <th>Tanggal Periksa</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prescriptions as $key => $prescription)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $prescription->patient->name }}</td>
                            <td>{{ \Carbon\Carbon::parse($prescription->created_at)->format('d M Y') }}</td>
                            <td>
                                @if($prescription->status == 'pending')
                                    <span class="badge badge-warning">Menunggu</span>
                                @else
                                    <span class="badge badge-success">Diproses</span>
                                @endif
                            </td>
                            <td>
                                @if($prescription->status == 'pending')
                                    <a href="{{ route('doctor.prescriptions.edit', $prescription->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                @else
                                    <button class="btn btn-sm btn-secondary" disabled>Sudah Diproses</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
