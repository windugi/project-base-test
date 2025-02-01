<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Examination;
use App\Models\Patient;
use App\Services\MedicineService;

class ExaminationController extends Controller
{
    public function create($patient_id)
    {
        $patient = Patient::findOrFail($patient_id);
        $medicines = MedicineService::fetchMedicines(); // Ambil data obat dari API

        return view('doctor.examinations.create', compact('patient', 'medicines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'vital_signs' => 'required|string',
            'examination_result' => 'required|string',
            'prescription' => 'nullable|string',
            'prescription_file' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $data = $request->all();

        // Simpan file jika ada
        if ($request->hasFile('prescription_file')) {
            $data['prescription_file'] = $request->file('prescription_file')->store('prescriptions');
        }

        Examination::create($data);

        return redirect()->route('doctor.patients.index')->with('success', 'Pemeriksaan berhasil disimpan.');
    }
}
