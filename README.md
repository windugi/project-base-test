# Aplikasi Peresepan Obat Berbasis Web

## Deskripsi
Aplikasi ini digunakan untuk mengelola peresepan obat oleh dokter dan pelayanan resep oleh apoteker. Dokter dapat mencatat pemeriksaan pasien, menulis resep, dan mengunggah berkas. Apoteker dapat melihat resep, melayani resep dokter, melakukan pembayaran, serta mencetak resi pembayaran dalam bentuk PDF.

## Fitur Utama
### 1. **Dokter**
- Login menggunakan API eksternal.
- Mencatat pemeriksaan pasien.
- Menulis dan mengubah resep sebelum diproses apoteker.
- Mengunggah berkas pemeriksaan.
- Melihat daftar pasien dan riwayat resep.

### 2. **Apoteker**
- Login menggunakan database lokal.
- Melihat daftar resep.
- Melayani resep dokter.
- Melakukan pembayaran.
- Mencetak resi pembayaran dalam bentuk PDF.

### 3. **API Eksternal**
- Mengambil daftar obat dari API eksternal.
- Menggunakan API eksternal untuk login dokter.

## Teknologi yang Digunakan
- **Backend**: Laravel 10 (PHP 8)
- **Frontend**: Blade + AdminLTE
- **Database**: MySQL
- **Version Control**: GitHub/GitLab/Bitbucket
- **Autentikasi**: Sanctum & API eksternal
- **PDF Generation**: DomPDF

## Instalasi
1. **Clone Repository**
   ```bash
   git clone https://github.com/username/resep-obat.git
   cd resep-obat
   ```

2. **Instalasi Dependensi**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   Duplikat file `.env.example` menjadi `.env` lalu ubah sesuai kebutuhan.
   ```bash
   cp .env.example .env
   ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Konfigurasi Database**
   Sesuaikan `.env` dengan pengaturan database MySQL:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=resep_obat
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Migrasi dan Seeder Database**
   ```bash
   php artisan migrate --seed
   ```

7. **Jalankan Server Laravel**
   ```bash
   php artisan serve
   ```
   Akses aplikasi di: [http://127.0.0.1:8000](http://127.0.0.1:8000)

## Penggunaan
- **Dokter**: Login menggunakan API eksternal, mencatat pemeriksaan pasien, dan menulis resep.
   Link : /login/doctor
   Untuk login sebagai dokter
- **Apoteker**: Melayani resep, melakukan pembayaran, dan mencetak resi.
   Link : login/pharmacist
   Untuk login sebagai apoteker
## API Eksternal
### 1. **Daftar Obat**
   **Endpoint:**
   ```http
   GET http://recruitment.rsdeltasurya.com/api/v1/medicines
   ```
   **Headers:**
   ```json
   {
     "Authorization": "Bearer <YOUR_API_KEY>"
   }
   ```

### 2. **Login Dokter**
   **Endpoint:**
   ```http
   POST http://recruitment.rsdeltasurya.com/api/v1/login
   ```
   **Body:**
   ```json
   {
     "email": "doctor@example.com",
     "password": "password123"
   }
   ```

## Struktur Folder
```
resep-obat/
│── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   ├── Models/
│── resources/
│   ├── views/
│   │   ├── doctor/
│   │   ├── pharmacist/
│── database/
│   ├── migrations/
│   ├── seeders/
│── routes/
│   ├── web.php
│   ├── api.php
│── public/
│── .env
│── composer.json
│── package.json
│── README.md
```

## Coding Style & Standar
- Menggunakan **PSR-12** coding standard.
- Menggunakan **Laravel Design Pattern** seperti Repository Pattern.
- Menyimpan log perubahan data.(Belum selesai)

## Kontribusi
1. Fork repository ini.
2. Buat branch baru (`feature-nama-fitur`).
3. Commit perubahan (`git commit -m "Menambahkan fitur X"`).
4. Push ke repository Anda (`git push origin feature-nama-fitur`).
5. Buat Pull Request.

## Lisensi
Proyek ini menggunakan lisensi **MIT**.

---
🚀 **Selamat mengembangkan aplikasi peresepan obat!**

