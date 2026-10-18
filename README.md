# 🐱 MeowMap — Cat Rescue & Community Platform

**MeowMap** adalah aplikasi berbasis web yang dirancang untuk membantu masyarakat menemukan, melaporkan, dan memberikan informasi mengenai kucing di sekitar mereka. Aplikasi ini menyediakan peta lokasi laporan kucing, informasi ras kucing, serta marketplace untuk mendukung kebutuhan adopsi dan aktivitas komunitas pecinta kucing.

MeowMap dikembangkan menggunakan Laravel sebagai backend dengan REST API, autentikasi berbasis token, database relasional, dan peta interaktif menggunakan Leaflet.

> **Tagline:** Bersama membantu kucing di sekitar kita.

---

## 📌 Daftar Isi

- [Tentang Proyek](#-tentang-proyek)
- [Latar Belakang](#-latar-belakang)
- [Tujuan](#-tujuan)
- [Fitur Utama](#-fitur-utama)
- [Teknologi](#-teknologi-yang-digunakan)
- [Arsitektur Aplikasi](#-arsitektur-aplikasi)
- [Struktur Proyek](#-struktur-proyek)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi](#-instalasi-dan-konfigurasi)
- [Konfigurasi Database](#-konfigurasi-database)
- [Menjalankan Aplikasi](#-menjalankan-aplikasi)
- [Dokumentasi REST API](#-dokumentasi-rest-api)
- [Autentikasi](#-autentikasi)
- [Sistem Laporan Kucing](#-sistem-laporan-kucing)
- [Reverse Geocoding](#-reverse-geocoding-kecamatan)
- [Moderasi Admin](#-moderasi-admin)
- [Pengelolaan Foto](#-pengelolaan-foto)
- [Keamanan](#-keamanan)
- [Pengujian](#-pengujian)
- [Pengembangan Selanjutnya](#-pengembangan-selanjutnya)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)

---

## 📖 Tentang Proyek

MeowMap merupakan platform komunitas yang menghubungkan masyarakat dengan informasi mengenai kucing di lingkungan sekitar. Melalui peta interaktif dan sistem laporan, pengguna dapat membagikan informasi mengenai kucing hilang, kucing yang ditemukan, kucing peliharaan, serta kucing yang membutuhkan rumah baru.

Aplikasi ini juga menyediakan informasi ras kucing dan marketplace untuk mendukung kegiatan komunitas.

Selain menampilkan lokasi geografis, MeowMap memanfaatkan reverse geocoding untuk mengubah koordinat menjadi nama wilayah yang lebih mudah dipahami pengguna, seperti nama kecamatan.

## 🎯 Latar Belakang

Informasi mengenai kucing hilang, kucing terlantar, dan kucing yang membutuhkan adopsi sering tersebar di berbagai platform komunikasi dan media sosial. Kondisi ini dapat menyulitkan masyarakat untuk menemukan informasi yang relevan berdasarkan lokasi.

MeowMap dikembangkan sebagai solusi digital yang mengintegrasikan pelaporan kucing, pemetaan lokasi, informasi ras, dan fitur marketplace dalam satu platform. Dengan demikian, masyarakat dapat berpartisipasi dalam membantu kucing di lingkungan mereka secara lebih terorganisasi.

## 🎯 Tujuan

1. Memudahkan masyarakat melaporkan keberadaan kucing di suatu lokasi.
2. Menampilkan lokasi laporan melalui peta interaktif.
3. Menyediakan informasi jenis laporan dan nama kecamatan agar lokasi mudah dikenali.
4. Mendukung proses adopsi dan aktivitas komunitas pecinta kucing.
5. Menerapkan REST API, autentikasi, otorisasi, dan pengelolaan data menggunakan Laravel.
6. Menerapkan moderasi admin untuk menjaga kualitas informasi yang dipublikasikan.

---

## ✨ Fitur Utama

### 🗺️ 1. Peta Laporan Kucing

- Menampilkan marker lokasi laporan menggunakan Leaflet.
- Menampilkan informasi laporan melalui popup pada marker.
- Menyediakan daftar laporan yang dapat digunakan untuk membuka lokasi terkait.
- Menampilkan foto, jenis laporan, nama pelapor, deskripsi, dan status sesuai data yang tersedia.
- Menggunakan koordinat latitude dan longitude untuk menentukan posisi marker.

### 📍 2. Informasi Kecamatan

MeowMap menggunakan reverse geocoding untuk memperoleh nama wilayah berdasarkan koordinat laporan.

Contoh informasi yang ditampilkan:

```text
🐱 Laporan Kucing #17

🏷️ Jenis: Kucing untuk adopsi
👤 Pelapor: Ali Fahmi Yusuf

makan

📍 Kecamatan Kotagede
🗓️ 18/10/2026, 21.01.32
```

Nama kecamatan diperoleh dari layanan geocoding dan disimpan pada kolom `district` di database apabila berhasil ditemukan.

### 📝 3. Pelaporan Kucing

Pengguna yang sudah login dapat mengirim laporan dengan informasi:

- Jenis laporan.
- Deskripsi.
- Latitude dan longitude.
- Foto kucing.

Jenis laporan yang tersedia:

| Kode | Keterangan |
|---|---|
| `lost` | Kucing hilang |
| `found` | Kucing ditemukan |
| `pet` | Kucing peliharaan |
| `adoption` | Kucing untuk adopsi |
| `sale` | Kucing dijual |

Laporan baru menggunakan status `pending` dan menunggu proses moderasi sebelum ditampilkan sebagai laporan publik.

### 🔐 4. Autentikasi Pengguna

- Registrasi akun.
- Login pengguna.
- Pengambilan informasi pengguna yang sedang login.
- Logout.
- Autentikasi API menggunakan Laravel Sanctum.
- Pembatasan akses terhadap endpoint yang memerlukan autentikasi.

### 🐈 5. Informasi Ras Kucing

Menyediakan endpoint untuk melihat daftar ras kucing dan informasi detail berdasarkan ID.

### 🏠 6. Marketplace

Menyediakan endpoint untuk melihat daftar listing dan detail listing. Pengguna yang terautentikasi dapat membuat, memperbarui, dan menghapus listing sesuai aturan akses aplikasi.

### 🛡️ 7. Moderasi Admin

Endpoint admin menyediakan kemampuan untuk:

- Melihat laporan kucing berdasarkan status.
- Menyetujui atau menolak laporan.
- Menghapus laporan melalui endpoint admin.
- Memoderasi listing.
- Melihat data analitik aplikasi.

Endpoint admin dilindungi oleh autentikasi dan otorisasi `can:manage-meowmap`.

---

## 🛠️ Teknologi yang Digunakan

| Teknologi | Kegunaan |
|---|---|
| PHP | Bahasa pemrograman backend |
| Laravel 12 | Framework backend dan REST API |
| MySQL / MariaDB | Database relasional, sesuai konfigurasi proyek |
| Laravel Sanctum | Autentikasi berbasis token |
| Eloquent ORM | Interaksi dengan database |
| Laravel Validation | Validasi input |
| Leaflet | Peta interaktif |
| OpenStreetMap | Sumber peta dan data geospasial |
| Nominatim | Reverse geocoding koordinat menjadi informasi wilayah |
| HTML | Struktur antarmuka |
| CSS | Tampilan antarmuka |
| JavaScript | Interaksi frontend dan komunikasi API |
| Blade | Template antarmuka Laravel |
| Composer | Manajemen dependensi PHP |
| Git & GitHub | Version control dan kolaborasi |

> Versi dependensi yang benar mengikuti `composer.json` dan `composer.lock` pada repository.

---

## 🏗️ Arsitektur Aplikasi

MeowMap menggunakan arsitektur client-server dengan Laravel sebagai backend dan antarmuka web sebagai client.

```text
+-----------------------------+
|        Pengguna Web         |
|   HTML / CSS / JavaScript   |
+--------------+--------------+
               |
               | HTTP / JSON
               v
+-----------------------------+
|       Laravel Backend       |
|                             |
|  Routes / Middleware        |
|  Controllers                |
|  Validation                 |
|  Authentication             |
|  Authorization              |
|  Eloquent ORM               |
+------+----------------------+
       |               |
       v               v
+-------------+  +----------------+
|   Database  |  | Nominatim API  |
|             |  | Reverse        |
| Users       |  | Geocoding      |
| CatSpottings|  +----------------+
| Listings    |
| Breeds      |
+-------------+
```

### Alur pelaporan kucing

1. Pengguna login ke aplikasi.
2. Pengguna menentukan lokasi kucing dan mengisi formulir laporan.
3. Frontend mengirim data ke endpoint `POST /api/cat-spottings`.
4. Laravel memvalidasi data yang dikirim.
5. Backend menyimpan foto ke disk `public`.
6. Backend meminta informasi wilayah berdasarkan koordinat melalui Nominatim.
7. Nama kecamatan disimpan pada kolom `district` apabila berhasil diperoleh.
8. Laporan disimpan dengan status `pending`.
9. Admin melakukan moderasi.
10. Laporan yang disetujui dapat ditampilkan pada daftar publik dan peta.

---

## 📂 Struktur Proyek

Struktur berikut menggambarkan komponen utama yang digunakan pada aplikasi Laravel.

```text
meowmap/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Api/
│   │       │   ├── AuthController.php
│   │       │   ├── CatSpottingController.php
│   │       │   ├── BreedController.php
│   │       │   ├── ListingController.php
│   │       │   └── Admin/
│   │       │       ├── CatSpottingModerationController.php
│   │       │       ├── ListingModerationController.php
│   │       │       ├── AdminCatSpottingController.php
│   │       │       └── AdminAnalyticsController.php
│   └── Models/
│       ├── User.php
│       ├── CatSpotting.php
│       ├── Breed.php
│       └── Listing.php
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
├── public/
├── resources/
│   └── views/
│       └── meowmap/
├── routes/
│   ├── api.php
│   └── web.php
├── storage/
│   └── app/
│       └── public/
├── tests/
├── .env.example
├── artisan
├── composer.json
├── composer.lock
└── README.md
```

*Catatan: struktur di atas adalah gambaran komponen utama. Sesuaikan dengan file aktual dalam repository; tidak semua file atau folder contoh harus sudah tersedia.*

---

## 💻 Persyaratan Sistem

Pastikan perangkat pengembangan telah memiliki:

- PHP 8.2 atau versi yang sesuai dengan dependensi Laravel 12.
- Composer.
- MySQL atau MariaDB.
- Node.js dan npm apabila proyek menggunakan dependensi frontend melalui npm.
- Git.
- Browser modern.

Periksa versi PHP dan Composer:

```bash
php -v
composer --version
```

Periksa versi framework:

```bash
php artisan --version
```

---

## 🚀 Instalasi dan Konfigurasi

### 1. Clone repository

```bash
git clone <URL_REPOSITORY>
cd meowmap
```

Ganti `<URL_REPOSITORY>` dengan URL repository GitHub MeowMap.

### 2. Instal dependensi

```bash
composer install
```

### 3. Siapkan file environment

```bash
cp .env.example .env
```

Pada Windows Command Prompt, gunakan:

```cmd
copy .env.example .env
```

### 4. Generate application key

```bash
php artisan key:generate
```

### 5. Konfigurasi environment

Sesuaikan konfigurasi `.env` dengan lingkungan pengembangan.

Contoh untuk MySQL lokal:

```dotenv
APP_NAME=MeowMap
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=meowmap_db
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
CACHE_STORE=database
```

Sesuaikan `DB_USERNAME`, `DB_PASSWORD`, dan konfigurasi lainnya dengan database lokal.

**Penting:** jangan menimpa konfigurasi `.env` yang sudah benar. Jika database `meowmap_db` sudah digunakan, pertahankan nama database tersebut atau sesuaikan dengan lingkungan masing-masing.

---

## 🗄️ Konfigurasi Database

Pastikan database sudah dibuat dan dapat diakses oleh Laravel.

Jika database belum tersedia, buat database MySQL:

```sql
CREATE DATABASE meowmap_db;
```

Jalankan migration:

```bash
php artisan migrate
```

Untuk melihat status migration:

```bash
php artisan migrate:status
```

> Hindari `php artisan migrate:fresh` pada database yang berisi data penting karena perintah tersebut menghapus tabel sebelum membuatnya kembali.

### Model utama

- `User`: data pengguna dan autentikasi.
- `CatSpotting`: data laporan kucing, lokasi, foto, jenis laporan, kecamatan, dan status.
- `Breed`: data informasi ras kucing.
- `Listing`: data listing marketplace.

Model `CatSpotting` menggunakan `SoftDeletes`, sehingga penghapusan melalui Eloquent dapat menggunakan mekanisme soft delete.

---

## ▶️ Menjalankan Aplikasi

Buat symbolic link untuk file publik:

```bash
php artisan storage:link
```

Bersihkan cache konfigurasi jika diperlukan:

```bash
php artisan optimize:clear
```

Jalankan server pengembangan Laravel:

```bash
php artisan serve
```

Secara default, aplikasi dapat diakses melalui:

```text
http://127.0.0.1:8000
```

Periksa daftar endpoint:

```bash
php artisan route:list
```

Untuk melihat informasi middleware dan detail route:

```bash
php artisan route:list -v
```

---

## 🔌 Dokumentasi REST API

Base URL untuk pengembangan lokal:

```text
http://127.0.0.1:8000/api
```

Endpoint API menggunakan format JSON, kecuali endpoint upload foto yang menggunakan `multipart/form-data`.

### 1. Autentikasi

| Method | Endpoint | Akses | Keterangan |
|---|---|---|---|
| `POST` | `/register` | Publik | Registrasi akun |
| `POST` | `/login` | Publik | Login |
| `GET` | `/user` | Login | Mendapatkan profil pengguna |
| `POST` | `/logout` | Login | Logout |

Endpoint yang memerlukan login menggunakan token Sanctum melalui header:

```http
Authorization: Bearer <TOKEN>
Accept: application/json
```

### 2. Laporan kucing

| Method | Endpoint | Akses | Keterangan |
|---|---|---|---|
| `GET` | `/cat-spottings` | Publik | Daftar laporan yang disetujui |
| `GET` | `/cat-spottings/{id}` | Publik/pemilik sesuai aturan controller | Detail laporan |
| `POST` | `/cat-spottings` | Login | Membuat laporan |
| `PATCH` | `/cat-spottings/{id}` | Pemilik | Memperbarui laporan |
| `DELETE` | `/cat-spottings/{id}` | Pemilik | Menghapus laporan |

Daftar laporan publik menggunakan pagination dan hanya menampilkan laporan dengan status `approved`.

Contoh permintaan daftar laporan:

```http
GET /api/cat-spottings
Accept: application/json
```

Contoh struktur respons pagination:

```json
{
  "current_page": 1,
  "data": [],
  "first_page_url": "http://127.0.0.1:8000/api/cat-spottings?page=1",
  "last_page": 1,
  "per_page": 15,
  "total": 0
}
```

Nilai respons aktual bergantung pada data dalam database.

### 3. Membuat laporan kucing

Endpoint:

```http
POST /api/cat-spottings
```

Header:

```http
Authorization: Bearer <TOKEN>
Accept: application/json
Content-Type: multipart/form-data
```

Field yang dikirim:

| Field | Tipe | Keterangan |
|---|---|---|
| `description` | String | Deskripsi laporan, 3–1000 karakter |
| `latitude` | Numeric | Latitude antara -90 dan 90 |
| `longitude` | Numeric | Longitude antara -180 dan 180 |
| `report_type` | String | `lost`, `found`, `pet`, `adoption`, atau `sale` |
| `photo` | File gambar | JPG, JPEG, PNG, atau WEBP; maksimum 2 MB |

Field `district` diperoleh backend dari proses reverse geocoding, bukan dari input yang harus dipercaya dari frontend.

Contoh respons berhasil:

```json
{
  "message": "Laporan berhasil dibuat dan menunggu moderasi.",
  "data": {
    "id": 17,
    "description": "Kucing membutuhkan rumah baru",
    "latitude": "-7.8088953",
    "longitude": "110.3970325",
    "district": "Kotagede",
    "report_type": "adoption",
    "status": "pending"
  }
}
```

Contoh di atas menggambarkan struktur data; isi respons aktual mengikuti data yang tersimpan.

### 4. Informasi ras kucing

| Method | Endpoint | Akses | Keterangan |
|---|---|---|---|
| `GET` | `/breeds` | Publik | Daftar ras kucing |
| `GET` | `/breeds/{id}` | Publik | Detail ras kucing |

Endpoint daftar ras menggunakan pagination jika dikonfigurasi pada controller.

### 5. Marketplace

| Method | Endpoint | Akses | Keterangan |
|---|---|---|---|
| `GET` | `/listings` | Publik | Daftar listing |
| `GET` | `/listings/{id}` | Publik | Detail listing |
| `POST` | `/listings` | Login | Membuat listing |
| `PATCH` | `/listings/{id}` | Login/pemilik sesuai aturan controller | Memperbarui listing |
| `DELETE` | `/listings/{id}` | Login/pemilik sesuai aturan controller | Menghapus listing |

Detail field listing mengikuti validasi pada `ListingController`.

### 6. Endpoint admin

Semua endpoint admin berikut memerlukan autentikasi Sanctum dan izin `manage-meowmap`.

| Method | Endpoint | Keterangan |
|---|---|---|
| `GET` | `/admin/cat-spottings` | Melihat laporan untuk moderasi |
| `PATCH` | `/admin/cat-spottings/{id}/status` | Memperbarui status laporan |
| `DELETE` | `/admin/cat-spottings/{id}` | Menghapus laporan melalui admin |
| `GET` | `/admin/listings` | Melihat listing untuk moderasi |
| `PATCH` | `/admin/listings/{id}/status` | Memperbarui status listing |
| `GET` | `/admin/analytics` | Mendapatkan data analitik |

Status moderasi laporan kucing yang didukung:

- `pending`: menunggu moderasi.
- `approved`: disetujui dan dapat ditampilkan secara publik.
- `rejected`: ditolak.

Periksa implementasi controller untuk mengetahui aturan status dan validasi yang berlaku pada setiap endpoint.

---

## 🔐 Autentikasi

MeowMap menggunakan Laravel Sanctum untuk autentikasi API.

Alur autentikasi:

1. Pengguna melakukan registrasi atau login.
2. Backend memvalidasi kredensial.
3. Setelah login berhasil, client menerima token autentikasi.
4. Token digunakan untuk mengakses endpoint yang dilindungi.
5. Backend memeriksa identitas pengguna melalui middleware `auth:sanctum`.
6. Endpoint admin juga memerlukan otorisasi `can:manage-meowmap`.

Contoh header:

```http
Authorization: Bearer <TOKEN>
Accept: application/json
```

Token harus disimpan dan dikelola dengan aman. Jangan menampilkan token asli dalam dokumentasi, tangkapan layar publik, atau repository.

---

## 📍 Reverse Geocoding Kecamatan

MeowMap menggunakan Nominatim dari OpenStreetMap untuk mendapatkan informasi wilayah berdasarkan koordinat geografis.

### Alur kerja

```text
Latitude + Longitude
         |
         v
  Nominatim Reverse API
         |
         v
 Informasi alamat/wilayah
         |
         v
 Ekstraksi field district
         |
         v
 Penyimpanan ke database
         |
         v
 Popup peta dan notifikasi
```

Contoh koordinat:

```text
Latitude  : -7.8088953
Longitude : 110.3970325
District  : Kotagede
```

Contoh di atas merupakan hasil pengujian yang telah berhasil pada laporan MeowMap.

### Implementasi backend

Fungsi `getDistrict()` pada `CatSpottingController`:

1. Mengirim permintaan reverse geocoding.
2. Mengambil field wilayah dari respons.
3. Menggunakan cache untuk hasil kecamatan yang berhasil ditemukan.
4. Mencatat kegagalan melalui Laravel logging.
5. Mengembalikan `null` apabila nama kecamatan tidak berhasil diperoleh.

Kolom `district` disimpan pada tabel `cat_spottings` dan diizinkan melalui `$fillable` model `CatSpotting`.

### Catatan penggunaan

- Koordinat tetap disimpan untuk menentukan posisi marker pada peta.
- Nama kecamatan ditampilkan sebagai informasi lokasi yang lebih mudah dibaca.
- Nama wilayah yang tersedia bergantung pada data OpenStreetMap.
- Jika kecamatan tidak ditemukan, aplikasi perlu menangani nilai kosong tanpa menganggap lokasi telah teridentifikasi.
- Penggunaan Nominatim harus mematuhi kebijakan layanan, termasuk identifikasi aplikasi, batas permintaan, dan caching.

---

## 🖼️ Pengelolaan Foto

Foto laporan disimpan menggunakan Laravel Filesystem pada disk `public`, dalam direktori:

```text
storage/app/public/cat-spottings/
```

Foto dapat diakses melalui URL publik yang dihasilkan oleh accessor `photo_url` pada model `CatSpotting`.

Jalankan perintah berikut agar direktori penyimpanan dapat diakses melalui public storage:

```bash
php artisan storage:link
```

Validasi foto laporan:

- Format JPG, JPEG, PNG, atau WEBP.
- Ukuran maksimal 2 MB.
- Foto harus berupa file gambar yang valid.

Pada lingkungan produksi, pastikan konfigurasi filesystem, izin direktori, dan strategi backup foto sudah sesuai.

---

## 🛡️ Keamanan

MeowMap menerapkan beberapa mekanisme keamanan backend:

- **Autentikasi:** endpoint privat dilindungi oleh Laravel Sanctum.
- **Otorisasi:** operasi admin dilindungi oleh `can:manage-meowmap`.
- **Validasi input:** data laporan divalidasi sebelum diproses.
- **Validasi unggahan:** jenis dan ukuran foto dibatasi.
- **Pemeriksaan kepemilikan:** operasi laporan oleh pengguna memeriksa pemiliknya.
- **Mass assignment protection:** field yang dapat diisi melalui Eloquent ditentukan pada `$fillable`.
- **Soft delete:** model laporan mendukung penghapusan lunak.
- **Pemisahan status publik dan moderasi:** laporan yang belum disetujui tidak ditampilkan pada daftar publik.

### Catatan produksi

Sebelum deployment:

1. Set `APP_DEBUG=false`.
2. Gunakan HTTPS.
3. Jangan memasukkan file `.env` atau token ke Git.
4. Gunakan kredensial database dengan hak akses minimum.
5. Tinjau aturan CORS, rate limiting, dan kebijakan upload.
6. Pastikan Gate `manage-meowmap` hanya memberikan akses kepada administrator yang berwenang.
7. Pastikan kebijakan privasi menjelaskan pengelolaan lokasi dan foto yang dikirim pengguna.

---

## 🧪 Pengujian

Pengujian dapat dilakukan melalui browser, terminal, pengujian Laravel, atau client HTTP seperti Postman.

### 1. Periksa route

```bash
php artisan route:list -v
```

### 2. Periksa migration

```bash
php artisan migrate:status
```

### 3. Jalankan automated test

```bash
php artisan test
```

### 4. Periksa data laporan

Gunakan Tinker:

```bash
php artisan tinker
```

Contoh:

```php
\App\Models\CatSpotting::latest()
    ->first(['id', 'latitude', 'longitude', 'district', 'status']);
```

Perintah tersebut dapat membantu memeriksa data laporan terbaru yang benar-benar tersimpan.

### 5. Periksa log Laravel

Jika reverse geocoding gagal, periksa:

```text
storage/logs/laravel.log
```

Pastikan koneksi internet, respons Nominatim, kolom database, dan konfigurasi cache berjalan dengan baik.

---

## 🛣️ Pengembangan Selanjutnya

Pengembangan MeowMap dapat dilanjutkan melalui beberapa area berikut:

- Menyempurnakan pengalaman pengguna pada peta dan formulir laporan.
- Menambahkan pencarian serta filter berdasarkan jenis laporan dan wilayah.
- Meningkatkan konsistensi data wilayah administratif Indonesia.
- Mengembangkan notifikasi perubahan status laporan.
- Menambahkan dokumentasi API yang dapat diakses pengembang.
- Memperluas automated testing untuk autentikasi, otorisasi, laporan, dan moderasi.
- Mengoptimalkan performa endpoint dan pemuatan marker peta.
- Mengembangkan dashboard analitik admin.
- Menyempurnakan fitur adopsi dan marketplace sesuai kebutuhan komunitas.
- Meningkatkan kesiapan deployment dan monitoring aplikasi.

Daftar ini merupakan usulan pengembangan, bukan klaim bahwa seluruh fitur tersebut telah tersedia.

---

## 🤝 Kontribusi

Kontribusi untuk pengembangan MeowMap dapat dilakukan melalui langkah berikut:

1. Fork repository.
2. Buat branch baru untuk perubahan.
3. Implementasikan fitur atau perbaikan.
4. Jalankan pengujian yang relevan.
5. Commit perubahan dengan pesan yang jelas.
6. Ajukan Pull Request untuk ditinjau.

Contoh:

```bash
git checkout -b feature/nama-fitur
git add .
git commit -m "feat: add nama fitur"
git push origin feature/nama-fitur
```

---

## 📄 Lisensi

Lisensi proyek mengikuti lisensi yang ditetapkan pada repository. Jika proyek belum memiliki lisensi, tentukan lisensi sebelum mengizinkan penggunaan atau distribusi ulang secara resmi.

---

## 👨‍💻 Tentang Pengembang

MeowMap merupakan proyek pengembangan aplikasi web yang menggabungkan backend development, REST API, manajemen database, autentikasi, pemetaan geografis, dan pengelolaan informasi komunitas.

Proyek ini dapat digunakan sebagai sarana pembelajaran dan pengembangan kemampuan dalam:

- Backend Engineering.
- Laravel dan PHP.
- REST API Development.
- Database Design.
- Authentication dan Authorization.
- Geospatial Data dan Reverse Geocoding.
- Integrasi frontend dan backend.

**MeowMap — Helping cats, one location at a time.** 🐱
