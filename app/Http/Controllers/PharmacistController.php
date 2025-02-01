<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prescription;
use PDF; // Import PDF facade
use App\Models\ChangeLog;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Session;
use App\Models\Examination;
use App\Models\ExaminationMedicine;
use Carbon\Carbon;
use App\Models\Log;

class PharmacistController extends Controller
{
    public function index()
    {
        $prescriptions = Examination::with(['medicines', 'doctor']) // Tambahkan 'doctor'
        ->get();
        return view('pharmacist.prescriptions.index', compact('prescriptions'));
    }

    public function process($id)
    {
        $examination = Examination::findOrFail($id);
        // dd($id);
        $DateNow = Carbon::now();
        $examination->update(['status' => 'paid','tanggal_diterima' => $DateNow]);
        Log::create([
            'level' => 'info',
            'message' => 'Edit data layanan dengan id: ' . $id . ' berhasil',
            'context' => json_encode($id), // Menyimpan konteks tambahan jika diperlukan
        ]);
        return redirect()->route('pharmacist.dashboard')->with('success', 'Resep berhasil diproses.');
    }


    public function getMedicinePrices($medicineId)
    {
        $client = new Client();
        try {
            $response = $client->get("http://recruitment.rsdeltasurya.com/api/v1/medicines/{$medicineId}/prices", [
                'headers' => [
                    'Authorization' => 'Bearer ' . Session::get('api_token')
                ]
            ]);

            $prices = json_decode($response->getBody(), true);
            return response()->json($prices);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil harga obat.'], 500);
        }
    }

    public function invoice($id)
    {
       // Debugging: Cek ID yang diterima
    //    dd($id);

       // Ambil data resep dari database
       $resep = Examination::with('medicines')->findOrFail($id);
       // Debugging: Cek objek resep yang diambil
    //    dd($resep);

       // Inisialisasi Guzzle Client
       $client = new Client();
       $token = Session::get('api_token');
       $waktuPemeriksaan = $resep->created_at;

       // Ambil daftar obat dari API
       $responseObat = $client->request('GET', 'http://recruitment.rsdeltasurya.com/api/v1/medicines', [
           'headers' => [
               'Authorization' => "Bearer $token",
           ],
       ]);

       $dataObat = json_decode($responseObat->getBody(), true);
       $obatDetails = [];
       $totalHarga = 0;

       // Ambil detail obat berdasarkan medicine_id
       foreach ($resep->medicines as $obat) {
           if (isset($obat->medicine_id)) { // Pastikan medicine_id ada
               foreach ($dataObat['medicines'] as $apiObat) {
                   if ($apiObat['id'] === $obat->medicine_id) {
                       $obatDetails[] = [
                           'name' => $apiObat['name'],
                           'price' => $this->getPriceFromApi($client, $token, $obat->medicine_id, $waktuPemeriksaan),
                       ];
                       $totalHarga += $this->getPriceFromApi($client, $token, $obat->medicine_id, $waktuPemeriksaan);
                       break;
                   }
               }
           }
       }

       Log::create([
        'level' => 'info',
        'message' => 'Berhasil cetak resi dengan id: ' . $id . ' berhasil',
        'context' => json_encode($id), // Menyimpan konteks tambahan jika diperlukan
    ]);
       // Buat PDF
       $pdf = PDF::loadView('pharmacist.prescriptions.pdf.resep', compact('resep', 'obatDetails','totalHarga'));

        return response()->stream(
            function () use ($pdf) {
                echo $pdf->output();
            },
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="resi_pembayaran_resep.pdf"',
            ]
        );

      

        // Cetak PDF
        return $pdf->download('resi_pembayaran_resep.pdf');   
    }
    public function show($id)
    {
        $prescription = Examination::with(['medicines'])
        ->findOrFail($id);

        $client = new Client();
        $token = Session::get('api_token');
        $waktuPemeriksaan = $prescription->created_at;

         // Ambil daftar obat dari API
        $responseObat = $client->request('GET', 'http://recruitment.rsdeltasurya.com/api/v1/medicines', [
            'headers' => [
                'Authorization' => "Bearer $token",
            ],
        ]);

        $dataObat = json_decode($responseObat->getBody(), true);
        $obatDetails = [];
        $totalHarga = 0;
        foreach ($prescription->medicines as $obat) {
            if (isset($obat->medicine_id)) { // Pastikan medicine_id ada
                foreach ($dataObat['medicines'] as $apiObat) {
                    if ($apiObat['id'] === $obat->medicine_id) {
                        $obatDetails[] = [
                            'name' => $apiObat['name'],
                            'price' => $this->getPriceFromApi($client, $token, $obat->medicine_id, $waktuPemeriksaan),
                        ];
                        $totalHarga += $this->getPriceFromApi($client, $token, $obat->medicine_id, $waktuPemeriksaan);
                        break;
                    }
                }
            }
        }
        Log::create([
            'level' => 'info',
            'message' => 'Berhasil lihat resep dengan id: ' . $id . ' berhasil',
            'context' => json_encode($id), // Menyimpan konteks tambahan jika diperlukan
        ]);

        return view('pharmacist.prescriptions.show', compact('prescription','obatDetails','totalHarga'));
    }
    private function getPriceFromApi($client, $token, $medicineId, $waktuPemeriksaan)
    {
        // Ambil harga dari API berdasarkan medicine_id
        $responseHarga = $client->request('GET', "http://recruitment.rsdeltasurya.com/api/v1/medicines/{$medicineId}/prices", [
            'headers' => [
                'Authorization' => "Bearer $token",
            ],
        ]);

        $dataHarga = json_decode($responseHarga->getBody(), true);
        $harga = null;

        // Ambil harga terbaru dari response
        foreach ($dataHarga['prices'] as $price) {
            if ($price['start_date'] <= $waktuPemeriksaan) {
                return $price['unit_price'];
            }
        }
        return null;
    }
}

