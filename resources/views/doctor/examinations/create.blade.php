@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Tambah Pemeriksaan</h2>

        <form action="{{ route('doctor.examinations.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Pilih Pasien -->
            <div class="mb-3">
                <label class="form-label">Pilih Pasien</label>
                <select name="patient_id" class="form-control select2">
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->name }} - {{ $patient->id }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Pilihan Upload Surat -->
            <div class="mb-3">
                <label class="form-label">Apakah pasien membawa surat?</label>
                <select id="hasLetter" name="has_letter" class="form-control">
                    <option value="no">Tidak</option>
                    <option value="yes">Ya</option>
                </select>
            </div>

            <!-- Input Upload Surat -->
            <div id="uploadLetter" class="mb-3" style="display: none;">
                <label class="form-label">Unggah Surat Pemeriksaan</label>
                <input type="file" name="examination_letter" class="form-control">
            </div>

            <!-- Input Manual Jika Tidak Membawa Surat -->
            <div id="manualInput">
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
                    <select name="medicine_ids[]" class="form-control select2" multiple>
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

@section('scripts')
<!-- Tambahkan Select2 untuk UI yang lebih baik -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Pilih",
            allowClear: true
        });

        $('#hasLetter').change(function() {
            if ($(this).val() === 'yes') {
                $('#uploadLetter').show();
                $('#manualInput').hide();
            } else {
                $('#uploadLetter').hide();
                $('#manualInput').show();
            }
        });
    });
</script>
@endsection
