<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class AuthController extends Controller
{
    // Menampilkan form login dokter
    public function showDoctorLogin()
    {
        return view('auth.doctor_login');
    }

    // Menampilkan form login apoteker
    public function showPharmacistLogin()
    {
        return view('auth.pharmacist_login');
    }

    // Proses login dokter via API eksternal
    public function doctorLogin(Request $request)
{
    $response = Http::post('http://recruitment.rsdeltasurya.com/api/v1/auth', [
        'email' => $request->email,
        'password' => $request->password,
    ]);

    if ($response->successful()) {
        $data = $response->json();
        if (!isset($data['access_token'])) {
            return back()->withErrors(['login' => 'Gagal mendapatkan token, periksa kembali kredensial.']);
        }

        // Simpan user ke dalam database jika belum ada
        $user = User::updateOrCreate(
            ['email' => $request->email],
            [
                'name' => 'Doctor', // Bisa diubah jika API mengembalikan nama
                'role' => 'doctor',
                'password' => bcrypt($request->password), // Dummy password
                'api_token' => $data['access_token'] ?? null,
            ]
        );

        // Simpan token ke sesi
        Auth::login($user); // Login ke sistem Laravel
        session(['role' => Auth::user()->role, 'api_token' => $data['access_token']]);            
        return $this->redirectToDashboard();
        }

        return back()->withErrors(['error' => 'Login gagal, periksa email dan password']);
    }

    // Proses login apoteker dari database
    public function pharmacistLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
    
            // return redirect()->route('pharmacist.dashboard');
            return $this->redirectToDashboard();
        }
    
        return back()->withErrors(['error' => 'Login gagal, periksa kembali email dan password.']);
    }

    public function redirectToDashboard()
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'dokter') {
                return redirect()->route('doctor.dashboard');
            } elseif (Auth::user()->role == 'apoteker') {
                return redirect()->route('pharmacist.dashboard');
            }
        }

        return redirect()->route('home'); // Redirect default jika tidak ada role
    }


    // Logout untuk kedua jenis user
    public function logout()
    {
        if (Auth::user()->role == 'dokter') {
            Auth::logout();
            session()->forget('doctor_token');
            return redirect('/login/doctor');
        } elseif (Auth::user()->role == 'apoteker') {
            Auth::logout();
            session()->forget('doctor_token');
            return redirect('/login/pharmacist');
        }
    }
}
