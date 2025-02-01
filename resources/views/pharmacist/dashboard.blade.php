@extends('adminlte::page')

@section('title', 'Dashboard Apoteker')

@section('content_header')
    <h1>Dashboard Apoteker</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="card-title">Daftar Resep</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Pasien</th>
                            <th>Obat</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($prescriptions as $prescription)
                            <tr>
                                <td>{{ $prescription->patient_name }}</td>
                                <td>
                                    @foreach (json_decode($prescription->medications) as $med)
                                        <span class="badge badge-info">{{ $med }}</span>
                                    @endforeach
                                </td>
                                <td><span class="badge {{ $prescription->status == 'pending' ? 'badge-warning' : 'badge-success' }}">{{ $prescription->status }}</span></td>
                                <td>
                                    @if ($prescription->status == 'pending')
                                        <form action="{{ url('/pharmacist/process-payment') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="prescription_id" value="{{ $prescription->id }}">
                                            <button type="submit" class="btn btn-success">Proses Pembayaran</button>
                                        </form>
                                    @else
                                        <span class="text-success">Sudah Dibayar</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
