# API Documentation - Sistem Akademik Kampus

## Base URL
```
http://localhost:8000
```

## Authentication
Sistem menggunakan session-based authentication. Setelah login berhasil, session akan disimpan dan dapat digunakan untuk request selanjutnya.

## Response Format
Semua response menggunakan format JSON dengan struktur:
```json
{
    "success": true/false,
    "message": "Pesan response",
    "data": {
        // Data response
    }
}
```

## Error Response
```json
{
    "success": false,
    "message": "Error message",
    "errors": {
        "field": ["Error detail"]
    }
}
```

## Endpoints

### Authentication

#### Login
```http
POST /login
```

**Request Body:**
```json
{
    "username": "admin",
    "password": "password"
}
```

**Response:**
```json
{
    "success": true,
    "message": "Login berhasil",
    "data": {
        "user": {
            "id": 1,
            "name": "Administrator",
            "email": "admin@kampus.com",
            "username": "admin",
            "role": "admin"
        },
        "redirect": "/admin/dashboard"
    }
}
```

#### Logout
```http
POST /logout
```

**Response:**
```json
{
    "success": true,
    "message": "Logout berhasil"
}
```

### Admin Endpoints

#### Dashboard Statistics
```http
GET /admin/dashboard
```

**Response:**
```json
{
    "success": true,
    "data": {
        "totalMahasiswa": 150,
        "totalDosen": 25,
        "totalMataKuliah": 80,
        "totalKrs": 1200
    }
}
```

#### Mahasiswa Management

##### Get All Mahasiswa
```http
GET /admin/mahasiswa
```

**Query Parameters:**
- `page` (optional): Page number for pagination
- `search` (optional): Search by NIM or nama
- `program_studi` (optional): Filter by program studi
- `status` (optional): Filter by status

**Response:**
```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "nim": "2021001",
                "nama_lengkap": "Budi Santoso",
                "program_studi": "Teknik Informatika",
                "angkatan": 2021,
                "status": "",
                "user": {
                    "email": "budi@kampus.com",
                    "username": "mahasiswa1"
                }
            }
        ],
        "total": 150,
        "per_page": 15
    }
}
```

##### Get Mahasiswa by ID
```http
GET /admin/mahasiswa/{id}
```

**Response:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "nim": "2021001",
        "nama_lengkap": "Budi Santoso",
        "tempat_lahir": "Bandung",
        "tanggal_lahir": "2000-05-15",
        "jenis_kelamin": "L",
        "alamat": "Jl. Asia Afrika No. 456, Bandung",
        "no_hp": "081234567891",
        "program_studi": "Teknik Informatika",
        "angkatan": 2021,
        "status": "aktif",
        "user": {
            "email": "budi@kampus.com",
            "username": "mahasiswa1"
        }
    }
}
```

##### Create Mahasiswa
```http
POST /admin/mahasiswa
```

**Request Body:**
```json
{
    "nim": "2021003",
    "nama_lengkap": "Citra Dewi",
    "tempat_lahir": "Surabaya",
    "tanggal_lahir": "2000-03-20",
    "jenis_kelamin": "P",
    "alamat": "Jl. Sudirman No. 123, Surabaya",
    "no_hp": "081234567894",
    "program_studi": "Teknik Informatika",
    "angkatan": 2021,
    "status": "aktif",
    "email": "citra@kampus.com",
    "username": "mahasiswa3",
    "password": "password123"
}
```

##### Update Mahasiswa
```http
PUT /admin/mahasiswa/{id}
```

**Request Body:**
```json
{
    "nama_lengkap": "Budi Santoso Updated",
    "alamat": "Jl. Asia Afrika No. 789, Bandung",
    "no_hp": "081234567895"
}
```

##### Delete Mahasiswa
```http
DELETE /admin/mahasiswa/{id}
```

#### Dosen Management

##### Get All Dosen
```http
GET /admin/dosen
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "nip": "198501012010011001",
            "nama_lengkap": "Dr. Ahmad Supriyadi, M.Kom",
            "bidang_keahlian": "Teknik Informatika",
            "status": "aktif",
            "user": {
                "email": "ahmad@kampus.com",
                "username": "dosen1"
            }
        }
    ]
}
```

##### Create Dosen
```http
POST /admin/dosen
```

**Request Body:**
```json
{
    "nip": "198503032010012003",
    "nama_lengkap": "Dr. Rina Marlina, M.Si",
    "tempat_lahir": "Medan",
    "tanggal_lahir": "1985-03-03",
    "jenis_kelamin": "P",
    "alamat": "Jl. Gatot Subroto No. 456, Medan",
    "no_hp": "081234567896",
    "bidang_keahlian": "Sistem Informasi",
    "status": "aktif",
    "email": "rina@kampus.com",
    "username": "dosen3",
    "password": "password123"
}
```

#### Mata Kuliah Management

##### Get All Mata Kuliah
```http
GET /admin/mata-kuliah
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "kode_mk": "IF101",
            "nama_mk": "Pemrograman Dasar",
            "sks": 3,
            "semester": "1",
            "program_studi": "Teknik Informatika",
            "status": "aktif"
        }
    ]
}
```

##### Create Mata Kuliah
```http
POST /admin/mata-kuliah
```

**Request Body:**
```json
{
    "kode_mk": "IF203",
    "nama_mk": "Pemrograman Mobile",
    "sks": 3,
    "semester": "4",
    "program_studi": "Teknik Informatika",
    "deskripsi": "Mata kuliah pemrograman aplikasi mobile",
    "status": "aktif"
}
```

### Dosen Endpoints

#### Dashboard Dosen
```http
GET /dosen/dashboard
```

**Response:**
```json
{
    "success": true,
    "data": {
        "dosen": {
            "id": 1,
            "nip": "198501012010011001",
            "nama_lengkap": "Dr. Ahmad Supriyadi, M.Kom",
            "bidang_keahlian": "Teknik Informatika"
        },
        "totalKrs": 45,
        "totalNilai": 30
    }
}
```

#### Get KRS by Dosen
```http
GET /dosen/krs
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "mahasiswa": {
                "nim": "2021001",
                "nama_lengkap": "Budi Santoso"
            },
            "mata_kuliah": {
                "kode_mk": "IF101",
                "nama_mk": "Pemrograman Dasar"
            },
            "tahun_akademik": "2023/2024",
            "semester": "Ganjil",
            "status": "disetujui"
        }
    ]
}
```

#### Get Nilai by Dosen
```http
GET /dosen/nilai
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "mahasiswa": {
                "nim": "2021001",
                "nama_lengkap": "Budi Santoso"
            },
            "mata_kuliah": {
                "kode_mk": "IF101",
                "nama_mk": "Pemrograman Dasar"
            },
            "nilai_tugas": 85,
            "nilai_uts": 80,
            "nilai_uas": 90,
            "nilai_akhir": 85.5,
            "grade": "A"
        }
    ]
}
```

#### Update Nilai
```http
PUT /dosen/nilai/{id}
```

**Request Body:**
```json
{
    "nilai_tugas": 90,
    "nilai_uts": 85,
    "nilai_uas": 92,
    "catatan": "Mahasiswa sangat aktif dalam pembelajaran"
}
```

### Mahasiswa Endpoints

#### Dashboard Mahasiswa
```http
GET /mahasiswa/dashboard
```

**Response:**
```json
{
    "success": true,
    "data": {
        "mahasiswa": {
            "id": 1,
            "nim": "2021001",
            "nama_lengkap": "Budi Santoso",
            "program_studi": "Teknik Informatika",
            "angkatan": 2021
        },
        "totalKrs": 8,
        "totalNilai": 6
    }
}
```

#### Get KRS by Mahasiswa
```http
GET /mahasiswa/krs
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "mata_kuliah": {
                "kode_mk": "IF101",
                "nama_mk": "Pemrograman Dasar",
                "sks": 3
            },
            "dosen": {
                "nama_lengkap": "Dr. Ahmad Supriyadi, M.Kom"
            },
            "tahun_akademik": "2023/2024",
            "semester": "Ganjil",
            "status": "disetujui"
        }
    ]
}
```

#### Create KRS
```http
POST /mahasiswa/krs
```

**Request Body:**
```json
{
    "mata_kuliah_id": 2,
    "dosen_id": 1,
    "tahun_akademik": "2023/2024",
    "semester": "Genap"
}
```

#### Get Nilai by Mahasiswa
```http
GET /mahasiswa/nilai
```

**Response:**
```json
{
    "success": true,
    "data": [
        {
            "id": 1,
            "mata_kuliah": {
                "kode_mk": "IF101",
                "nama_mk": "Pemrograman Dasar",
                "sks": 3
            },
            "dosen": {
                "nama_lengkap": "Dr. Ahmad Supriyadi, M.Kom"
            },
            "nilai_tugas": 85,
            "nilai_uts": 80,
            "nilai_uas": 90,
            "nilai_akhir": 85.5,
            "grade": "A"
        }
    ]
}
```

## Error Codes

| Code | Description |
|------|-------------|
| 400 | Bad Request - Invalid input data |
| 401 | Unauthorized - Authentication required |
| 403 | Forbidden - Insufficient permissions |
| 404 | Not Found - Resource not found |
| 422 | Validation Error - Invalid data format |
| 500 | Internal Server Error |

## Rate Limiting

API memiliki rate limiting untuk mencegah abuse:
- 60 requests per minute untuk authenticated users
- 30 requests per minute untuk unauthenticated users

## Pagination

Untuk endpoint yang mendukung pagination, response akan menyertakan:
```json
{
    "current_page": 1,
    "data": [...],
    "first_page_url": "...",
    "from": 1,
    "last_page": 10,
    "last_page_url": "...",
    "next_page_url": "...",
    "path": "...",
    "per_page": 15,
    "prev_page_url": null,
    "to": 15,
    "total": 150
}
```

## Testing API

### Using Postman
1. Import collection dari file `Sistem-Akademik-API.postman_collection.json`
2. Set base URL ke `http://localhost:8000`
3. Jalankan request sesuai endpoint

### Using cURL
```bash
# Login
curl -X POST http://localhost:8000/login \
  -H "Content-Type: application/json" \
  -d '{"username":"admin","password":"password"}'

# Get mahasiswa
curl -X GET http://localhost:8000/admin/mahasiswa \
  -H "Cookie: laravel_session=your_session_cookie"
```

## WebSocket (Future Feature)

Untuk real-time notifications, sistem akan menggunakan WebSocket:
```javascript
// Connect to WebSocket
const socket = new WebSocket('ws://localhost:6001');

// Listen for notifications
socket.onmessage = function(event) {
    const data = JSON.parse(event.data);
    console.log('Notification:', data);
};
``` 