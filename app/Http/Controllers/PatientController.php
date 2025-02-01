<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Carbon\Carbon;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        return view('doctor.patients.index', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255'
        ]);

        // dd(request()->all() );

        Patient::create($request->all());
        return redirect()->route('doctor.patients.index')->with('success', 'Pasien berhasil ditambahkan.');
    }

    public function show($id)
    {

        $patient = Patient::findOrFail($id);
        $age = Carbon::parse($patient->birth_date)->age;
        
        return view('doctor.patients.show', compact('patient','age'));
    }

    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        return view('doctor.patients.edit', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $patient->update($request->all());

        return redirect()->route('doctor.patients.index')->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return redirect()->route('doctor.patients.index')->with('success', 'Data pasien berhasil dihapus.');
    }

}
