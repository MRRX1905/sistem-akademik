# Sistem Akademik Kampus

Sistem Akademik Kampus adalah aplikasi web berbasis Laravel yang dirancang untuk mengelola data akademik kampus, termasuk manajemen mahasiswa, dosen, mata kuliah, KRS, dan nilai.

## Fitur Utama

### 🔐 Autentikasi & Otorisasi
- Login multi-role (Admin, Dosen, Mahasiswa)
- Role-based access control
- Session management

### 👨‍🎓 Manajemen Mahasiswa
- CRUD data mahasiswa
- Informasi lengkap mahasiswa (NIM, nama, alamat, dll)
- Status mahasiswa (aktif, nonaktif, lulus)

### 👨‍🏫 Manajemen Dosen
- CRUD data dosen
- Informasi lengkap dosen (NIP, nama, bidang keahlian, dll)
- Status dosen (aktif, nonaktif)


### 📋 Manajemen KRS (Kartu Rencana Studi)
- Mahasiswa dapat mengambil mata kuliah
- Dosen dapat melihat KRS mahasiswa
- Status KRS (pending, disetujui, ditolak)

### ⭐ Manajemen Nilai
- Dosen dapat input nilai (tugas, UTS, UAS)
- Perhitungan nilai akhir otomatis
- Grade assignment berdasarkan nilai

### 📊 Dashboard
- Dashboard khusus untuk setiap role
- Statistik dan ringkasan data
- Aktivitas terbaru

## Teknologi yang Digunakan

- **Backend**: Laravel 12
- **Database**: MySQL/SQLite
- **Frontend**: Bootstrap 5, Font Awesome
- **Authentication**: Laravel Auth
- **Middleware**: Custom Role Middleware

## Instalasi

### Prerequisites
- PHP 8.2 atau lebih tinggi
- Composer
- MySQL/SQLite
- Web server (Apache/Nginx) atau PHP built-in server

### Langkah Instalasi

1. **Clone repository**
   ```bash
   git clone <repository-url>
   cd sistem-akademik
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi database**
   Edit file `.env` dan sesuaikan konfigurasi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sistem_akademik
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Jalankan migration**
   ```bash
   php artisan migrate
   ```

6. **Seed database dengan data awal**
   ```bash
   php artisan db:seed --class=UserSeeder
   php artisan db:seed --class=MataKuliahSeeder
   ```

7. **Jalankan server development**
   ```bash
   php artisan serve
   ```

8. **Akses aplikasi**
   Buka browser dan akses `http://localhost:8000`

## Data Login Default

### Admin
- Username: `admin`
- Password: `password`
- Email: `admin@kampus.com`

### Dosen
- Username: `dosen1` atau `dosen2`
- Password: `password`
- Email: `ahmad@kampus.com` atau `siti@kampus.com`

### Mahasiswa
- Username: `mahasiswa1` atau `mahasiswa2`
- Password: `password`
- Email: `budi@kampus.com` atau `dewi@kampus.com`

## Struktur Database

### Tabel Users
- id, name, email, username, password, role, remember_token, timestamps

### Tabel Mahasiswas
- id, user_id, nim, nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat, no_hp, program_studi, angkatan, status, timestamps

### Tabel Dosens
- id, user_id, nip, nama_lengkap, tempat_lahir, tanggal_lahir, jenis_kelamin, alamat, no_hp, bidang_keahlian, status, timestamps

### Tabel MataKuliahs
- id, kode_mk, nama_mk, sks, semester, program_studi, deskripsi, status, timestamps

### Tabel KRS
- id, mahasiswa_id, mata_kuliah_id, dosen_id, tahun_akademik, semester, status, timestamps

### Tabel Nilais
- id, krs_id, mahasiswa_id, mata_kuliah_id, dosen_id, nilai_tugas, nilai_uts, nilai_uas, nilai_akhir, grade, catatan, timestamps

## Fitur Role-based Access

### Admin
- Akses penuh ke semua fitur
- Manajemen data mahasiswa, dosen, mata kuliah
- Manajemen KRS dan nilai
- Dashboard dengan statistik lengkap

### Dosen
- Melihat KRS mahasiswa
- Input dan edit nilai mahasiswa
- Dashboard dengan informasi mengajar

### Mahasiswa
- Melihat dan mengambil mata kuliah (KRS)
- Melihat nilai yang telah diinput dosen
- Dashboard dengan informasi akademik

## API Endpoints

### Authentication
- `GET /login` - Halaman login
- `POST /login` - Proses login
- `POST /logout` - Logout

### Admin Routes
- `GET /admin/dashboard` - Dashboard admin
- `GET /admin/mahasiswa` - List mahasiswa
- `POST /admin/mahasiswa` - Create mahasiswa
- `PUT /admin/mahasiswa/{id}` - Update mahasiswa
- `DELETE /admin/mahasiswa/{id}` - Delete mahasiswa
- (Similar endpoints for dosen, mata-kuliah, krs, nilai)

### Dosen Routes
- `GET /dosen/dashboard` - Dashboard dosen
- `GET /dosen/krs` - List KRS
- `GET /dosen/nilai` - List nilai
- `PUT /dosen/nilai/{id}` - Update nilai

### Mahasiswa Routes
- `GET /mahasiswa/dashboard` - Dashboard mahasiswa
- `GET /mahasiswa/krs` - List KRS mahasiswa
- `POST /mahasiswa/krs` - Create KRS
- `GET /mahasiswa/nilai` - List nilai mahasiswa

## Kontribusi

1. Fork repository
2. Buat branch fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## Lisensi

Distributed under the MIT License. See `LICENSE` for more information.

## Kontak

- Email: admin@kampus.com
- Project Link: [https://github.com/username/sistem-akademik](https://github.com/username/sistem-akademik)

## Screenshots

### Login Page
![Login Page](screenshots/login.png)

### Admin Dashboard
![Admin Dashboard](screenshots/admin-dashboard.png)

### Dosen Dashboard
![Dosen Dashboard](screenshots/dosen-dashboard.png)

### Mahasiswa Dashboard
![Mahasiswa Dashboard](screenshots/mahasiswa-dashboard.png)
