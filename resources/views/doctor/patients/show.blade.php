@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Pasien</h2>
    <table class="table">
        <tr>
            <th>ID</th>
            <td>{{ $patient->id }}</td>
        </tr>
        <tr>
            <th>Nama</th>
            <td>{{ $patient->name }}</td>
        </tr>
        <tr>
            <th>Usia</th>
            <td>{{ $age }} Tahun</td>
        </tr>
        <tr>
            <th>Jenis Kelamin</th>
            <td>{{ $patient->gender }}</td>
        </tr>
        <tr>
            <th>Alamat</th>
            <td>{{ $patient->address }}</td>
        </tr>
        <tr>
            <th>No. Telepon</th>
            <td>{{ $patient->phone }}</td>
        </tr>
    </table>
    <a href="{{ route('doctor.patients.index') }}" class="btn btn-primary">Kembali</a>
</div>
@endsection
