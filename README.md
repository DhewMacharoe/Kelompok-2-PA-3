# MargayaTOBA  
# Sistem Manajemen Barbershop Multi-Tenant

**MargayaTOBA** adalah sebuah platform manajemen *barbershop dan Salon* berskala besar (multi-tenant) yang dibangun menggunakan framework **Laravel 12**. Aplikasi ini dirancang agar satu sistem dapat melayani banyak cabang *barbershop* secara bersamaan dengan isolasi data yang aman, efisien, dan *real-time*.

## Deskripsi Produk

Sistem ini memudahkan pemilik usaha *barbershop dan Salon* dalam mengelola bisnisnya dan setiap barbershop dan salon memiliki ruang kerja (Admin Tenant) mereka sendiri yang terisolasi. Pelanggan dapat dengan mudah mencari lokasi *barbershop* terdekat melalui peta interaktif dan mengambil nomor antrean.

### Fitur Utama

-   🏢 **Arsitektur Multi-Tenant:** Satu basis kode dan satu database untuk mengelola banyak cabang *barbershop* tanpa risiko kebocoran (bocor silang) data antar cabang.
-   🗺️ **Peta Pencarian Interaktif:** Halaman awal menyajikan peta interaktif (berbasis LeafletJS) yang memetakan seluruh cabang *barbershop* secara visual untuk pelanggan.
-   👑 **Akses Super Admin & Admin Cabang:** Panel khusus Super Admin untuk mengelola semua data secara global dan kemampuan *impersonasi* (beralih ke dashboard cabang tertentu). Masing-masing cabang memiliki adminnya sendiri.
-   ⏱️ **Antrean Real-Time:** Integrasi *Websocket* (melalui Pusher/Laravel Reverb) untuk pembaruan status antrean secara *real-time* ke perangkat pelanggan.
-   🔒 **Integrasi Firebase:** Mendukung autentikasi global pelanggan dan fitur-fitur pendukung dari Firebase Cloud Services.
-   ✂️ **Manajemen Layanan & Galeri:** Setiap cabang dapat mengatur menu, layanan, harga, profil, dan galeri mereka sendiri.

## Teknologi yang Digunakan

-   **Backend**: Laravel 12, PHP 8.2+
-   **Frontend**: Blade, Vite, TailwindCSS (atau sejenisnya), LeafletJS (untuk Peta)
-   **Database**: MySQL
-   **Real-time & Eksternal**: Firebase, Pusher / Laravel Reverb

---

## 🚀 Panduan Menjalankan Proyek (Wajib Baca)

Bagi pengembang yang ingin berkontribusi atau menjalankan *source code* ini secara lokal, **sangat disarankan** untuk membaca panduan instalasi yang telah kami sediakan. Panduan tersebut memuat langkah-langkah *setup* dari nol, termasuk konfigurasi *Database* dan *Firebase*.

👉 **[KLIK DI SINI UNTUK MEMBACA PANDUAN INSTALASI (instalasi.md)](./instalasi.md)**

---

*Hak Cipta © 2026 Argahomes Team. All rights reserved.*
