# LaundryLux - Sistem Informasi Manajemen Laundry

Aplikasi web manajemen laundry berbasis Laravel 12 yang dirancang untuk membantu operator laundry dalam mengelola pelanggan, paket layanan, transaksi, dan laporan keuangan secara terpusat.

---

## Fitur Utama

- **Manajemen Pelanggan** — Tambah, ubah, hapus, dan lihat data pelanggan
- **Manajemen Paket Layanan** — Pengelolaan paket laundry beserta harga dan satuan
- **Manajemen Transaksi** — Pembuatan order, update status (proses, selesai, diambil), cetak nota PDF
- **Laporan** — Filter berdasarkan rentang tanggal, ekspor ke PDF dan CSV
- **Dashboard** — Ringkasan data, grafik pendapatan 6 bulan terakhir, pesanan hari ini
- **Activity Log** — Pencatatan otomatis setiap aksi (created, updated, deleted, exported)
- **Halaman Publik** — Landing page menampilkan daftar paket layanan untuk tamu
- **Autentikasi** — Login, register, dan manajemen profil via Laravel Breeze

---

## Tech Stack

| Komponen | Teknologi |
|---|---|
| Framework | Laravel 12.x |
| Bahasa | PHP ^8.2 |
| Database | MySQL |
| Auth | Laravel Breeze 2.x |
| PDF | barryvdh/laravel-dompdf ^3.1 |
| Mobile | NativePHP Mobile ^3.0 (Android) |
| Testing | PestPHP ^3.8 |
| Frontend Build | Vite |

---

## Struktur Database

- `users` — data akun admin/operator
- `customers` — data pelanggan
- `packages` — paket layanan laundry (nama, harga, satuan)
- `transactions` — transaksi order (relasi ke customer, status)
- `package_transaction` — pivot table (qty, total per paket per transaksi)
- `activity_logs` — log aktivitas seluruh aksi di sistem

---

## Instalasi

**Persyaratan:**
- PHP ^8.2
- Composer
- Node.js & NPM
- MySQL

**Langkah instalasi:**

```bash
git clone https://github.com/dimasadhinugroho888/Laundry-Lux-Laravel.git
cd Laundry-Lux-Laravel
```

Salin file environment dan generate key:

```bash
cp .env.example .env
php artisan key:generate
```

Sesuaikan konfigurasi database di file `.env`:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laundry_laravel
DB_USERNAME=root
DB_PASSWORD=
```

Install dependencies dan jalankan migrasi:

```bash
composer install
php artisan migrate
npm install
npm run build
```

Atau gunakan satu perintah setup:

```bash
composer run setup
```

---

## Menjalankan Aplikasi

Mode development (server + vite + queue + log viewer berjalan bersamaan):

```bash
composer run dev
```

Atau jalankan manual:

```bash
php artisan serve
npm run dev
```

Akses aplikasi di `http://localhost:8000`

---

## Menjalankan Pengujian

```bash
composer run test
```

atau

```bash
php artisan test
```

Framework pengujian yang digunakan adalah **PestPHP** dengan pendekatan black-box testing per modul.

---

## Algoritma yang Digunakan

**QuickSort** — diterapkan pada daftar transaksi untuk mengurutkan data berdasarkan tanggal terbaru (descending) secara in-memory setelah data diambil dari database.

**Interpolation Search** — diterapkan untuk pencarian transaksi berdasarkan nama pelanggan. Data diurutkan secara alfabetis terlebih dahulu, kemudian posisi target diestimasi menggunakan nilai ASCII tiga karakter pertama nama pelanggan. Tersedia fallback substring match jika estimasi posisi tidak tepat.

---

## Struktur Route

| Method | URI | Keterangan |
|---|---|---|
| GET | / | Halaman publik (daftar paket) |
| GET | /dashboard | Dashboard admin |
| GET/POST | /customers | CRUD pelanggan |
| GET/POST | /packages | CRUD paket layanan |
| GET/POST | /transactions | CRUD transaksi |
| GET | /transactions/{id}/bill | Cetak nota web |
| GET | /transactions/{id}/pdf | Download nota PDF |
| GET | /reports | Halaman laporan |
| GET | /reports/export-pdf | Ekspor laporan PDF |
| GET | /reports/export-csv | Ekspor laporan CSV |

Semua route kecuali `/` dilindungi middleware `auth`.

---

## Lisensi

Proyek ini dibuat untuk keperluan akademik dan pengembangan sistem informasi manajemen laundry skala UMKM.
