@extends('adminlte::page')

@section('title', 'Dashboard Dokter')

@section('content_header')
    <h1>Dashboard Dokter</h1>
@endsection

@section('content')
    <h3>Daftar Pasien</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Usia</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($patients as $patient)
                <tr>
                    <td>{{ $patient->name }}</td>
                    <td>{{ $patient->gender }}</td>
                    <td>{{ \Carbon\Carbon::parse($patient->dob)->age }} tahun</td>
                    <td>
                        <a href="#" data-toggle="modal" data-target="#examinationModal-{{ $patient->id }}" class="btn btn-primary">Tambah Pemeriksaan</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @foreach($patients as $patient)
    <div class="modal fade" id="examinationModal-{{ $patient->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('doctor.storeExamination', $patient->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Pemeriksaan untuk {{ $patient->name }}</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <label>Tanda Vital</label>
                        <textarea name="vital_signs" class="form-control" required></textarea>

                        <label>Hasil Pemeriksaan</label>
                        <textarea name="diagnosis" class="form-control" required></textarea>

                        <label>Resep Obat</label>
                        <select name="prescription[]" class="form-control" multiple>
                            @foreach($medicines as $medicine)
                                <option value="{{ $medicine['id'] }}">{{ $medicine['name'] }}</option>
                            @endforeach
                        </select>

                        <label>Apakah membawa surat rujukan?</label>
                        <select id="referralSelect-{{ $patient->id }}" class="form-control" onchange="toggleReferralUpload('{{ $patient->id }}')">
                            <option value="no">Tidak</option>
                            <option value="yes">Ya</option>
                        </select>

                        <div id="referralUpload-{{ $patient->id }}" style="display: none;">
                            <label>Unggah Surat Rujukan</label>
                            <input type="file" name="referral_letter" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endforeach
@endsection

@section('js')
<script>
    function toggleReferralUpload(patientId) {
        let select = document.getElementById('referralSelect-' + patientId);
        let uploadDiv = document.getElementById('referralUpload-' + patientId);
        uploadDiv.style.display = (select.value === 'yes') ? 'block' : 'none';
    }
</script>
@endsection
