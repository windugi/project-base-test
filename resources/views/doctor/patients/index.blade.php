@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Pasien</h2>
    <a href="#" data-toggle="modal" data-target="#addPatientModal" class="btn btn-primary mb-3">Tambah Pasien</a>

    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Gender</th>
                <th>Telepon</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
            <tr>
                <td>{{ $patient->name }}</td>
                <td>{{ $patient->gender }}</td>
                <td>{{ $patient->phone }}</td>
                <td>
                    <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-info">Lihat</a>
                    <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('patients.delete', $patient->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah Pasien -->
<div class="modal fade" id="addPatientModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('doctor.patients.store') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pasien</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class ="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="gender" class="form-control">
                            <option value="">Pilih Kelamin</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="text" name="phone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <input type="text" name="address" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="birth_date" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
