<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChangeLog;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use App\Models\Prescription;
use Illuminate\Support\Facades\Http;
use App\Models\Patient;
use App\Models\Examination;
use App\Services\MedicineService;
use Illuminate\Support\Facades\Storage;
use App\Models\ExaminationMedicine;
use DB;

class DoctorController extends Controller
{
    public function index()
    {
        $prescriptions = Examination::with('doctor')->orderBy('created_at', 'desc')->get();

        // $patient = Patient::with('examinations')->findOrFail($prescriptions->patient_id);
        // dd($prescriptions);
            // dd($prescription); // Debugging: Pastikan data tidak null

            // Mengambil daftar obat dari API eksternal
            $url = 'http://recruitment.rsdeltasurya.com/api/v1/medicines';
            $token = Session::get('api_token');
        
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token
                ])->get($url);
        
                if ($response->successful()) {
                    $medicines = $response->json()['medicines']; 
                } else {
                    $medicines = [];
                }
            } catch (\Exception $e) {
                $medicines = [];
            }
            $patients = Patient::all(); // Ambil daftar pasien dari database


        return view('doctor.dashboard', compact('prescriptions','medicines'));
    }

    public function getMedicines()
    {
        $client = new Client();
        try {
            $response = $client->get('http://recruitment.rsdeltasurya.com/api/v1/medicines', [
                'headers' => [
                    'Authorization' => 'Bearer ' . Session::get('api_token')
                ]
            ]);

            $medicines = json_decode($response->getBody(), true);
            return response()->json($medicines);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil daftar obat.'], 500);
        }
    }

        // Menampilkan halaman edit resep
        public function editPrescription($id)
        {
            $prescription = Examination::with('medicines')->findOrFail($id);
            // dd($prescription); // Debugging: Pastikan data tidak null

            // Mengambil daftar obat dari API eksternal
            $url = 'http://recruitment.rsdeltasurya.com/api/v1/medicines';
            $token = Session::get('api_token');
        
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $token
                ])->get($url);
        
                if ($response->successful()) {
                    $medicines = $response->json()['medicines']; 
                } else {
                    $medicines = [];
                }
            } catch (\Exception $e) {
                $medicines = [];
            }
            $patients = Patient::all(); // Ambil daftar pasien dari database

            $medicineIds = DB::table('examination_medicines')
            ->where('examination_id', $id)
            ->pluck('medicine_id');


            return view('doctor.examinations.edit', compact('prescription', 'medicines','patients','medicineIds'));
        }
    
        // Memperbarui resep
        public function updatePrescription(Request $request, $id)
        {
            $prescription = Examination::findOrFail($id);
    
            if ($prescription->status == 'processed') {
                return redirect()->back()->with('error', 'Resep sudah diproses oleh apoteker dan tidak dapat diubah.');
            }
    
            $prescription->update([
                'patient_id' => $request->patient_id,
                'vital_signs' => $request->vital_signs,
                'examination_result'=>$request->examination_result,
            ]);
            
            $medicineIds = $request->medicine_ids;
            $prescription->medicines()->delete(); // Hapus data lama jika perlu
            // dd($medicineIds);

            foreach ($medicineIds as $medicineId) {
                $prescription->medicines()->create([
                    'medicine_id' => $medicineId
                ]);
            }
            return redirect()->route('doctor.dashboard')->with('success', 'Resep berhasil diperbarui.');
        }
    

    public function create()
    {
        $patients = Patient::all(); // Ambil daftar pasien dari database
        $url = 'http://recruitment.rsdeltasurya.com/api/v1/medicines';
        $token = Session::get('api_token');
    
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get($url);
    
            if ($response->successful()) {
                $medicines = $response->json()['medicines']; 
            } else {
                $medicines = [];
            }
        } catch (\Exception $e) {
            $medicines = [];
        }
    
        return view('doctor.examinations.create', compact('patients','medicines'));
    }

    public function store(Request $request)
    {
        // dd($request->all()); // Debug: Apakah data sudah masuk?
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'vital_signs' => 'nullable|string',
            'examination_result' => 'nullable|string',
            'medicine_ids' => 'required|array',
            // 'medicine_ids.*' => 'exists:medicines,id',
            'examination_letter' => 'nullable|file|max:2048',
        ]);

        // // Simpan pemeriksaan
        $examination = Examination::create([
            'doctor_id' => auth()->user()->id,
            'patient_id' => $request->patient_id,
            'vital_signs' => $request->vital_signs,
            'examination_result' => $request->examination_result,
            'status' => 'pending',
        ]);

        if (!$examination) {
            dd("Pemeriksaan tidak tersimpan!");
        }
        
        // dd($examination);
    
        // Simpan obat yang dipilih
        foreach ($request->medicine_ids as $medicine_id) {
            ExaminationMedicine::create([
                'examination_id' => $examination->id,
                'medicine_id' => $medicine_id
            ]);
        }
    
        return redirect()->route('doctor.dashboard')->with('success', 'Pemeriksaan berhasil disimpan');
    }
    
}

