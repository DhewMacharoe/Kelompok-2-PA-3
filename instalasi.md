# Panduan Instalasi Lokal Proyek

Dokumen ini berisi langkah-langkah untuk menjalankan proyek ini di lingkungan lokal Anda. Proyek ini menggunakan framework Laravel, PHP (minimal versi 8.2), database MySQL, dan layanan terintegrasi seperti Firebase.

## 1. Prasyarat Sistem

Pastikan sistem/komputer lokal Anda sudah terinstal perangkat lunak berikut:
- **PHP** (Minimal versi 8.2)
- **Composer** (Untuk mengelola dependensi PHP)
- **Node.js & NPM** (Untuk mengelola dependensi frontend)
- **MySQL / MariaDB** (Dapat menggunakan XAMPP, Laragon, atau instalasi database mandiri)
- **Git** (Untuk *version control*, opsional jika Anda hanya mengunduh ZIP)

## 2. Kloning & Persiapan Proyek

1. Buka terminal atau *command prompt*.
2. Arahkan (*cd*) ke direktori tempat Anda ingin menyimpan proyek, lalu jalankan perintah:
   ```bash
   git clone <url-repositori-anda>
   cd Deploy-Argahomes
   ```
   *(Lewati langkah ini jika Anda sudah berada di dalam folder proyek).*
3. Salin file contoh konfigurasi environment:
   ```bash
   cp .env.example .env
   ```
   *(Untuk pengguna Windows, Anda dapat menggunakan perintah: `copy .env.example .env`)*
4. Install semua dependensi sistem backend (PHP) menggunakan Composer:
   ```bash
   composer install
   ```
5. Install dependensi frontend menggunakan NPM:
   ```bash
   npm install
   ```
6. Buat *Application Key* unik untuk keamanan Laravel Anda:
   ```bash
   php artisan key:generate
   ```

## 3. Pengaturan Database MySQL

1. Buka aplikasi pengelola database Anda (misalnya phpMyAdmin melalui XAMPP, DBeaver, atau klien MySQL lainnya).
2. Buat database baru dengan nama `argashome` (atau nama lain yang Anda inginkan).
3. Buka file `.env` yang berada di dalam folder proyek Anda menggunakan *text editor* (misal: VS Code).
4. Cari bagian konfigurasi database dan sesuaikan nilainya:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=argashome
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   *(Isi `DB_PASSWORD` sesuai dengan password MySQL lokal Anda. Biasanya untuk XAMPP dibiarkan kosong).*
5. Jalankan perintah migrasi dan *seeder* untuk membuat struktur tabel dan mengisi data awal (dummy/admin) ke dalam database:
   ```bash
   php artisan migrate --seed
   ```

## 4. Pengaturan Akun Firebase Mandiri

Karena proyek ini terintegrasi dengan Firebase, Anda diwajibkan untuk membuat proyek Firebase Anda sendiri dan menghubungkannya ke aplikasi lokal ini.

### A. Membuat Proyek di Firebase
1. Buka situs [Firebase Console](https://console.firebase.google.com/) dan pastikan Anda sudah *login* dengan akun Google Anda.
2. Klik tombol **Add project** (Tambahkan proyek).
3. Masukkan nama proyek Anda, dan ikuti langkah-langkah konfirmasi hingga proyek berhasil dibuat.
4. Setelah berada di halaman *Project Overview* proyek baru Anda, klik ikon **Web (`</>`)** untuk mendaftarkan aplikasi web.
5. Beri nama aplikasi (misal: "Web App Lokal"), lalu klik **Register app**.

### B. Memasukkan Kredensial Firebase ke file `.env`
1. Setelah aplikasi diregistrasi pada langkah di atas, Firebase akan menampilkan blok kode konfigurasi.
2. Salin nilai (*value*) dari konfigurasi tersebut dan ganti isian Firebase yang ada di file `.env` lokal Anda:
   ```env
   FIREBASE_API_KEY=masukkan_api_key_anda_disini
   FIREBASE_PROJECT_ID=masukkan_project_id_anda
   FIREBASE_AUTH_DOMAIN=masukkan_project_id_anda.firebaseapp.com
   FIREBASE_STORAGE_BUCKET=masukkan_project_id_anda.firebasestorage.app
   FIREBASE_MESSAGING_SENDER_ID=masukkan_sender_id_anda
   FIREBASE_APP_ID=masukkan_app_id_anda
   ```

### C. Mendapatkan Service Account Key (Kunci Akses Server)
Agar aplikasi (backend Laravel) bisa berkomunikasi secara aman dengan Firebase, Anda memerlukan file *Service Account*.
1. Di halaman utama Firebase Console, klik ikon **gir (Settings)** di sebelah tulisan "Project Overview" di menu kiri atas, lalu pilih **Project settings**.
2. Masuk ke tab **Service accounts**.
3. Di bagian bawah, klik tombol **Generate new private key** (Buat kunci privat baru) dan konfirmasi pembuatan.
4. Sebuah file berekstensi `.json` akan otomatis terunduh ke komputer Anda.
5. **Ubah nama** file `.json` yang baru saja Anda unduh menjadi `firebase_credentials.json`.
6. Pindahkan file `firebase_credentials.json` tersebut ke dalam folder proyek lokal Anda pada path/lokasi berikut:
   `resources/credentials/firebase_credentials.json`
   *(Catatan: Anda mungkin harus membuat folder bernama `credentials` secara manual di dalam folder `resources` jika folder tersebut belum ada).*
7. Pastikan di dalam file `.env` konfigurasi path ini sudah sesuai:
   ```env
   FIREBASE_CREDENTIALS=resources/credentials/firebase_credentials.json
   FIREBASE_SERVICE_ACCOUNT=resources/credentials/firebase_credentials.json
   ```

## 5. Menjalankan Server Aplikasi Lokal

Setelah semua konfigurasi di atas selesai, Anda siap untuk menjalankan aplikasi.

1. Buka terminal Anda di folder proyek, lalu jalankan perintah kompilasi frontend (Vite):
   ```bash
   npm run dev
   ```
2. Biarkan terminal pertama tetap berjalan, **buka tab terminal baru**, lalu jalankan server backend Laravel:
   ```bash
   php artisan serve
   ```
3. Buka *web browser* Anda (Chrome/Firefox/Edge) dan akses URL berikut:
   **[http://localhost:8000](http://localhost:8000)**

Aplikasi Anda sekarang seharusnya sudah berhasil berjalan di komputer lokal!

---

**Tips Tambahan:**
Jika Anda menemukan error terkait cache, Anda dapat membersihkan cache aplikasi menggunakan perintah berikut:
```bash
php artisan optimize:clear
```
