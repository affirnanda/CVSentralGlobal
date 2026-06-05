# CV Sentral Global Indo - Company Profile Website

Website profil perusahaan dan manajemen layanan untuk CV Sentral Global Indo. Dibangun menggunakan kerangka kerja Laravel.

## 🚀 Fitur Utama

- **Landing Page Interaktif:** Hero section dinamis, daftar layanan, produk, cerita sukses profil (About Us), dan Testimoni pelanggan.
- **Admin Dashboard:** Antarmuka pengelola (CMS) yang elegan untuk mengatur konten situs web secara _real-time_.
- **Kelola Hero & Profile Section:** Admin dapat mengubah judul, teks paragraf, dan mengunggah gambar _background_ secara langsung dengan validasi instan. Konten disimpan secara efisien ke dalam file JSON.
- **Kelola FAQ (Tanya Jawab):** Manajemen urutan FAQ secara otomatis (_Auto-shifting_) saat penambahan, penghapusan, atau pembaruan.
- **Kelola Testimoni:** Persetujuan testimoni pelanggan secara langsung oleh admin untuk ditampilkan di _landing page_.

## 🛠️ Teknologi yang Digunakan

- **Backend:** Laravel 11.x (PHP 8.2+)
- **Frontend:** Blade Templates, Tailwind CSS, Alpine.js
- **Database:** MySQL / SQLite
- **Animasi:** AOS (Animate On Scroll)

---

## 💻 Panduan Instalasi (Untuk Tim Developer / Puller)

Jika Anda baru saja mengunduh (_clone_ atau _pull_) repositori ini, ikuti **"Ritual Wajib"** di bawah ini agar proyek dapat berjalan sempurna di komputer Anda:

### 1. Instalasi Dependensi

Buka terminal di dalam direktori proyek dan jalankan:

```bash
composer install
npm install
```

### 2. Konfigurasi Environment (.env)

Salin file konfigurasi bawaan:

```bash
cp .env.example .env
```

_(Untuk pengguna Windows CMD, gunakan `copy .env.example .env`)_

Buka file `.env` dan atur koneksi database Anda (misal: `DB_DATABASE=cv_sentral_global`).

### 3. Generate Key & Migrasi Database

Jalankan perintah berikut untuk mengamankan aplikasi dan membangun struktur database:

```bash
php artisan key:generate
php artisan migrate
```

_(Jika ada file seeder, Anda juga bisa menjalankan `php artisan db:seed`)_

### 4. Menautkan Penyimpanan (SANGAT PENTING!) ⚠️

Karena website ini memiliki fitur unggah gambar (Hero Image, Profile Image), Anda **WAJIB** membuat _symlink_ agar gambar dapat diakses oleh browser:

```bash
php artisan storage:link
```

_Catatan: Jika langkah ini dilewati, semua gambar yang diunggah dari Dashboard Admin akan error/tidak muncul (404 Not Found)._

### 5. Jalankan Server Lokal

Anda membutuhkan 2 terminal yang berjalan bersamaan:

Terminal 1 (Untuk memproses Tailwind CSS):

```bash
npm run dev
```

Terminal 2 (Untuk menjalankan server PHP):

```bash
php artisan serve
```

Aplikasi kini dapat diakses di: `http://localhost:8000`

---

## 📝 Catatan Penting Pengembangan

- **Manajemen Konten Landing Page:** Data teks dan pengaturan gambar Hero & Profile tidak disimpan di database relasional, melainkan di dalam file `storage/app/landing_page.json` untuk akses cepat.
- **Validasi Gambar:** Gambar yang diunggah ke Hero Section dibatasi maksimal 2MB (JPG/PNG). Aturan ini dikawal dua lapis: via Javascript di browser dan Controller di server.

## 🤝 Alur Kolaborasi (Git Push/Pull)

1. Selalu pastikan berada di branch yang benar: `git status`
2. Tarik pembaruan terbaru dari tim sebelum mulai mengubah kode: `git pull origin main`
3. Jika mengubah kerangka UI, pastikan `npm run dev` tetap berjalan agar _class_ Tailwind baru terdeteksi.
4. Jangan lupa `git add .` dan berikan pesan `commit` yang jelas sebelum melakukan `git push`.
