@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Pemeriksaan</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('doctor.prescriptions.update', $prescription->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Pilih Pasien -->
            <div class="mb-3">
                <label class="form-label">Pilih Pasien</label>
                <select name="patient_id" class="form-control select2" required>
                    <option value="">Pilih Pasien</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ $prescription->patient_id == $patient->id ? 'selected' : '' }}>
                            {{ $patient->name }} - {{ $patient->id }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Input Upload Surat -->
            <div id="uploadLetter" class="mb-3">
                <label class="form-label">Unggah Surat Pemeriksaan</label>
                <input type="file" name="examination_letter" class="form-control" accept=".pdf,.doc,.docx,.jpg,.png">
                @if($prescription->examination_letter)
                    <p>File saat ini: <a href="{{ asset($prescription->examination_letter) }}" target="_blank">Lihat Surat</a></p>
                    <img src="{{ asset($prescription->examination_letter) }}" alt="Surat Pemeriksaan" style="max-width: 50%; height: auto;">
                @endif
            </div>

            <!-- Input Manual -->
            <div id="manualInput">
                <div class="mb-3">
                    <label class="form-label">Tanda Vital</label>
                    <input type="text" name="vital_signs" class="form-control" value="{{ old('vital_signs', $prescription->vital_signs) }}" >
                </div>

                <div class="mb-3">
                    <label class="form-label">Hasil Pemeriksaan</label>
                    <textarea name="examination_result" class="form-control" >{{ old('examination_result', $prescription->examination_result) }}</textarea>
                </div>

                <!-- Select Multiple Obat dari API -->
                <div class="mb-3">
                    <label class="form-label">Pilih Obat</label>
                    <select name="medicine_ids[]" class="form-control select2" multiple>
                        @foreach($medicines as $medicine)
                            @foreach($medicineIds as $medicineID)
                                <option value="{{ $medicine['id'] }}" <?php if ($medicine['id'] == $medicineID) { echo 'selected="selected"'; } ?>>{{ $medicine['name'] }}</option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Perbarui Pemeriksaan</button>
        </form>
    </div>
@endsection