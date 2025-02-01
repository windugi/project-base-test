@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Pasien</h2>
    <form action="{{ route('patients.update', $patient->id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" value="{{ $patient->name }}" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select name="gender" class="form-control">
                <option value="">Pilih Kelamin</option>
                <option value="Male" <?php if ($patient->gender == 'Male') { echo 'selected="selected"'; } ?> >Male</option>
                <option value="Female" <?php if ($patient->gender == 'Female') { echo 'selected="selected"'; } ?> >Female</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" value="{{ $patient->phone }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Address</label>
            <input type="text" name="address" value="{{ $patient->address }}" class="form-control">
        </div>
        <div class="mb-3">
            <label>Birt Date</label>
            <input type="date" name="birth_date" value="{{ $patient->birth_date }}" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
