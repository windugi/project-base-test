@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Tambah Pemeriksaan</h2>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <form action="{{ route('doctor.examinations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Pilih Pasien -->
            <div class="mb-3">
                <label class="form-label">Pilih Pasien</label>
                <select name="patient_id" class="form-control select2" required>
                    <option value="">Pilih Pasien</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->name }} - {{ $patient->id }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Input Upload Surat -->
            <div id="uploadLetter" class="mb-3" >
                <label class="form-label">Unggah Surat Pemeriksaan (Jika tidak bawa surat bisa dikosongkan)</label>
                <input type="file" name="examination_letter" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
            </div>

            <!-- Input Manual Jika Tidak Membawa Surat -->
            <div id="manualInput" >
                <div class="mb-3">
                    <label class="form-label">Tanda Vital</label>
                    <input type="text" name="vital_signs" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Hasil Pemeriksaan</label>
                    <textarea name="examination_result" class="form-control"></textarea>
                </div>

                <!-- Select Multiple Obat dari API -->
                <div class="mb-3">
                    <label class="form-label">Pilih Obat</label>
                    <select name="medicine_ids[]" class="form-control select2" multiple required>
                        @foreach($medicines as $medicine)
                            <option value="{{ $medicine['id'] }}">{{ $medicine['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Pemeriksaan</button>
        </form>
    </div>
@endsection

