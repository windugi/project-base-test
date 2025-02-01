<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PharmacistController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
// use App\Http\Controllers\ExaminationController;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/login/doctor', [AuthController::class, 'showDoctorLogin'])->name('login.doctor');
Route::post('/login/doctor', [AuthController::class, 'doctorLogin']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/login/pharmacist', [AuthController::class, 'showPharmacistLogin'])->name('login.pharmacist');
Route::post('/login/pharmacist', [AuthController::class, 'pharmacistLogin']);

// Routes untuk Dokter
Route::middleware(['auth', 'role:dokter', 'web'])->group(function () {
    Route::get('/doctor/dashboard', [DoctorController::class, 'index'])->name('doctor.dashboard');
    Route::get('/doctor/patients', [DoctorController::class, 'patients'])->name('doctor.patients');
    Route::get('/doctor/prescriptions', [DoctorController::class, 'prescriptions'])->name('doctor.prescriptions');
    Route::post('/doctor/examinations/{patient_id}', [DoctorController::class, 'storeExamination'])->name('doctor.storeExamination');
    Route::get('/doctor/patients', [PatientController::class, 'index'])->name('doctor.patients.index');
    Route::post('/doctor/patients', [PatientController::class, 'store'])->name('doctor.patients.store');
    Route::get('/patients/{id}', [PatientController::class, 'show'])->name('patients.show');
    Route::get('/patients/{id}/edit', [PatientController::class, 'edit'])->name('patients.edit');
    Route::post('/patients/{id}/update', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('/patients/{id}/delete', [PatientController::class, 'destroy'])->name('patients.delete');
    Route::get('/doctor/prescriptions/{id}/edit', [DoctorController::class, 'editPrescription'])->name('doctor.prescriptions.edit');
    Route::post('/doctor/prescriptions/{id}/update', [DoctorController::class, 'updatePrescription'])->name('doctor.prescriptions.update');
    Route::get('/doctor/examinations/create', [DoctorController::class, 'create'])->name('doctor.examinations.create');
    Route::post('/doctor/examinations', [DoctorController::class, 'store'])->name('doctor.examinations.store');
    // Route::get('/doctor/examinations/{patient_id}', [ExaminationController::class, 'create'])->name('doctor.examinations.create');
    // Route::post('/doctor/examinations', [ExaminationController::class, 'store'])->name('doctor.examinations.store');
});



// Routes untuk Apoteker
Route::middleware(['auth', 'role:apoteker'])->group(function () {
    Route::get('/pharmacist/dashboard', [PharmacistController::class, 'index'])->name('pharmacist.dashboard');
    Route::put('/pharmacist/proses/{id}', [PharmacistController::class, 'process'])->name('pharmacist.prescriptions.process');
    Route::get('/pharmacist/invoice/{id}', [PharmacistController::class, 'invoice'])->name('pharmacist.prescriptions.invoice');
    Route::get('/pharmacist/prescriptions/{id}', [PharmacistController::class, 'show'])->name('pharmacist.prescriptions.show');
});

