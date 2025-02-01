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
use App\Models\Log;

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
            
            Log::create([
                'level' => 'info',
                'message' => 'Melihat resep dari dokter ' . auth()->user()->name . ' dengan resep id '.$id.' berhasil',
                'context' => null, // Menyimpan konteks tambahan jika diperlukan
            ]);

            return view('doctor.examinations.edit', compact('prescription', 'medicines','patients','medicineIds'));
        }
    
        // Memperbarui resep
        public function updatePrescription(Request $request, $id)
        {

            $request->validate([
                'patient_id' => 'required|exists:patients,id',
                'examination_letter' => 'nullable|file|mimes:jpg,png|max:2048',
                'medicine_ids' => 'required|array',
            ]);

            // Temukan pemeriksaan berdasarkan ID
            $examination = Examination::findOrFail($id);

            // Simpan surat jika ada
            $letterPath = $examination->examination_letter; // Simpan path surat lama
                if ($request->hasFile('examination_letter')) {
                    // Hapus file lama jika ada
                    if ($letterPath) {
                        // Hapus file dari folder public
                        $oldFilePath = public_path($letterPath);
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }
                    // Simpan file baru di folder public/examination_letters
                    $fileName = time() . '_' . $request->file('examination_letter')->getClientOriginalName();
                    $request->file('examination_letter')->move(public_path('examination_letters'), $fileName);
                    $letterPath = 'examination_letters/' . $fileName; // Simpan jalur relatif
                } 
            

            // Update pemeriksaan
            $examination->update([
                'patient_id' => $request->patient_id,
                'vital_signs' => $request->vital_signs,
                'examination_result' => $request->examination_result,
                'examination_letter' => $letterPath, // Simpan path surat
            ]);

            // Update obat yang dipilih
            DB::table('examination_medicines')->where('examination_id', $id)->delete();

            foreach ($request->medicine_ids as $medicineId) {
                $examination->medicines()->create(['examination_id' => $id, 'medicine_id' => $medicineId]);
            }

            Log::create([
                'level' => 'info',
                'message' => 'Mengedit resep dari dokter ' . auth()->user()->name . ' dengan resep id '.$id.' berhasil',
                'context' => null, // Menyimpan konteks tambahan jika diperlukan
            ]);

            return redirect()->route('doctor.dashboard')->with('success', 'Pemeriksaan berhasil diperbarui.');
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
                'examination_letter' => 'nullable|file|mimes:jpg,png|max:2048',
                'medicine_ids' => 'required|array',
            ]);

    

        $fileName = null;
        $letterPath = null;
        if ($request->hasFile('examination_letter')) {
            $fileName = 'examination_letters/'.time() . '_' . $request->file('examination_letter')->getClientOriginalName();

            $letterPath = $request->file('examination_letter')->move(public_path('examination_letters'), $fileName); // Simpan di folder 'examination_letters'
        } 

        // Simpan pemeriksaan
        $examination = Examination::create([
            'doctor_id' => auth()->user()->id,
            'patient_id' => $request->patient_id,
            'examination_letter' => $fileName,
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

        Log::create([
            'level' => 'info',
            'message' => 'Menambah resep dari dokter ' . auth()->user()->name . ' dengan pasien id '.$request->patient_id.' berhasil',
            'context' => null, // Menyimpan konteks tambahan jika diperlukan
        ]);
    
        return redirect()->route('doctor.dashboard')->with('success', 'Pemeriksaan berhasil disimpan');
    }
    
}

