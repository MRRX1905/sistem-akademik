# Panduan Penggunaan Sistem Akademik Kampus

## Daftar Isi
1. [Memulai Aplikasi](#memulai-aplikasi)
2. [Login ke Sistem](#login-ke-sistem)
3. [Dashboard Admin](#dashboard-admin)
4. [Dashboard Dosen](#dashboard-dosen)
5. [Dashboard Mahasiswa](#dashboard-mahasiswa)
6. [Manajemen Data](#manajemen-data)
7. [Troubleshooting](#troubleshooting)

## Memulai Aplikasi

### 1. Menjalankan Server
```bash
php artisan serve
```
Aplikasi akan berjalan di `http://localhost:8000`

### 2. Akses Halaman Login
Buka browser dan akses `http://localhost:8000/login`

## Login ke Sistem

### Kredensial Default

#### Admin
- **Username**: `admin`
- **Password**: `password`
- **Akses**: Full access ke semua fitur

#### Dosen
- **Username**: `dosen1` atau `dosen2`
- **Password**: `password`
- **Akses**: Manajemen KRS dan nilai

#### Mahasiswa
- **Username**: `mahasiswa1` atau `mahasiswa2`
- **Password**: `password`
- **Akses**: Lihat KRS dan nilai

## Dashboard Admin

### Fitur Utama
1. **Statistik Dashboard**
   - Total mahasiswa
   - Total dosen
   - Total mata kuliah
   - Total KRS

2. **Manajemen Data**
   - Tambah mahasiswa baru
   - Tambah dosen baru
   - Tambah mata kuliah baru
   - Tambah KRS baru

3. **Lihat Data**
   - Data mahasiswa
   - Data dosen
   - Data mata kuliah
   - Data KRS
   - Data nilai

### Cara Menambah Mahasiswa Baru
1. Klik tombol "Tambah Mahasiswa" di dashboard
2. Isi form data mahasiswa:
   - NIM (wajib, unik)
   - Nama lengkap
   - Tempat dan tanggal lahir
   - Jenis kelamin
   - Alamat
   - No. HP
   - Program studi
   - Angkatan
   - Status
3. Klik "Simpan"

### Cara Menambah Dosen Baru
1. Klik tombol "Tambah Dosen" di dashboard
2. Isi form data dosen:
   - NIP (wajib, unik)
   - Nama lengkap
   - Tempat dan tanggal lahir
   - Jenis kelamin
   - Alamat
   - No. HP
   - Bidang keahlian
   - Status
3. Klik "Simpan"

### Cara Menambah Mata Kuliah Baru
1. Klik tombol "Tambah Mata Kuliah" di dashboard
2. Isi form data mata kuliah:
   - Kode MK (wajib, unik)
   - Nama mata kuliah
   - SKS
   - Semester
   - Program studi
   - Deskripsi (opsional)
   - Status
3. Klik "Simpan"

## Dashboard Dosen

### Fitur Utama
1. **Informasi Dosen**
   - Data pribadi dosen
   - Total KRS yang diajar
   - Total nilai yang diinput

2. **Manajemen KRS**
   - Melihat KRS mahasiswa yang diajar
   - Menyetujui/menolak KRS

3. **Manajemen Nilai**
   - Input nilai mahasiswa
   - Edit nilai yang sudah diinput
   - Lihat daftar nilai

### Cara Input Nilai
1. Klik menu "Nilai" di sidebar
2. Pilih mahasiswa yang akan dinilai
3. Isi nilai:
   - Nilai tugas (0-100)
   - Nilai UTS (0-100)
   - Nilai UAS (0-100)
4. Sistem akan menghitung nilai akhir otomatis
5. Grade akan ditentukan berdasarkan nilai akhir
6. Klik "Simpan"

### Perhitungan Nilai
- **Nilai Akhir** = (Nilai Tugas × 30%) + (Nilai UTS × 30%) + (Nilai UAS × 40%)
- **Grade**:
  - A: 85-100
  - B: 75-84
  - C: 65-74
  - D: 50-64
  - E: 0-49

## Dashboard Mahasiswa

### Fitur Utama
1. **Informasi Mahasiswa**
   - Data pribadi mahasiswa
   - Total KRS yang diambil
   - Total nilai yang tersedia

2. **Manajemen KRS**
   - Melihat KRS yang sudah diambil
   - Mengambil mata kuliah baru
   - Status KRS (pending/disetujui/ditolak)

3. **Lihat Nilai**
   - Melihat nilai yang sudah diinput dosen
   - Rata-rata nilai
   - Progress akademik

### Cara Mengambil Mata Kuliah (KRS)
1. Klik menu "KRS" di sidebar
2. Klik tombol "Ambil Mata Kuliah"
3. Pilih mata kuliah yang ingin diambil
4. Pilih dosen pengajar
5. Isi tahun akademik dan semester
6. Klik "Simpan"
7. Status KRS akan menjadi "pending" menunggu persetujuan dosen

### Cara Melihat Nilai
1. Klik menu "Nilai" di sidebar
2. Sistem akan menampilkan daftar nilai untuk semua mata kuliah yang diambil
3. Nilai ditampilkan dalam format:
   - Nilai tugas
   - Nilai UTS
   - Nilai UAS
   - Nilai akhir
   - Grade

## Manajemen Data

### Export Data
Untuk saat ini, fitur export belum tersedia. Data dapat diakses melalui database langsung.

### Backup Database
```bash
# Untuk SQLite
cp database/database.sqlite backup/database_backup.sqlite

# Untuk MySQL
mysqldump -u username -p database_name > backup/database_backup.sql
```

### Import Data
Data dapat diimport melalui seeder atau langsung ke database.

## Troubleshooting

### Masalah Umum

#### 1. Error "Class not found"
```bash
composer dump-autoload
```

#### 2. Error database
```bash
php artisan migrate:fresh --seed
```

#### 3. Error permission
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

#### 4. Cache error
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

#### 5. Session error
```bash
php artisan session:table
php artisan migrate
```

### Log Error
Log error dapat dilihat di:
- `storage/logs/laravel.log`

### Debug Mode
Untuk development, pastikan `APP_DEBUG=true` di file `.env`

### Performance
Untuk production:
1. Set `APP_DEBUG=false`
2. Optimize autoloader: `composer install --optimize-autoloader --no-dev`
3. Cache config: `php artisan config:cache`
4. Cache routes: `php artisan route:cache`
5. Cache views: `php artisan view:cache`

## Kontak Support

Jika mengalami masalah teknis, silakan hubungi:
- Email: admin@kampus.com
- WhatsApp: +62 812-3456-7890
- Jam kerja: Senin-Jumat 08:00-17:00 WIB 