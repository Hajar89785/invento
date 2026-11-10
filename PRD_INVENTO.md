# Product Requirements Document (PRD)
## Aplikasi Web INVENTO – Sistem Inventaris & Peminjaman Barang

---

## 1. Ringkasan Eksekutif & Tujuan Produk
### Latar Belakang
Organisasi **HIMASISFOR** (Himpunan Mahasiswa Sistem Informasi Fakultas) masih mengandalkan pencatatan manual (buku catatan, spreadsheet offline) untuk pengelolaan inventaris barang dan proses peminjaman. Metode ini menimbulkan sejumlah masalah: 

| Masalah | Dampak |
|---------|--------|
| **Duplikasi data** | Kesulitan melacak stok yang sebenarnya. |
| **Keterlambatan verifikasi** | Pengajuan peminjaman memakan waktu lama karena harus menunggu persetujuan manual. |
| **Kurangnya transparansi** | Anggota tidak dapat melihat status barang atau riwayat peminjaman. |
| **Risiko kehilangan** | Tidak ada jejak audit yang jelas untuk barang yang dipinjam atau rusak. |

### Tujuan Produk
**INVENTO** dibangun untuk menggantikan proses manual dengan sistem digital yang:
1. **Menyederhanakan manajemen inventaris** – CRUD barang, kategori, dan stok secara terpusat.
2. **Mempercepat proses peminjaman** – Formulir online, notifikasi otomatis, dan persetujuan satu klik bagi admin.
3. **Meningkatkan transparansi** – Dashboard real‑time, riwayat peminjaman, dan laporan status barang.
4. **Memberikan kontrol akses** – Hak admin vs. hak anggota sesuai peran.
5. **Mudah dipelajari dan dikembangkan** – Stack teknologi ringan (PHP, MySQL, Bootstrap) cocok untuk proyek akhir mata kuliah.

---

## 2. Target Pengguna (User Personas) & Hak Akses
| Peran | Deskripsi | Hak Akses Utama |
|------|-----------|-----------------|
| **Admin / Petugas Inventaris** | Staf atau ketua HIMASISFOR yang bertanggung jawab atas data barang dan keputusan peminjaman. | <ul><li>Masuk ke **Dashboard Admin**.</li><li>Kelola **Master Data** (Barang, Kategori, Stok).</li><li>Verifikasi / Tolak **Pengajuan Peminjaman**.</li><li>Lihat semua **Riwayat** dan **Laporan**.</li><li>Kelola **Akun Anggota** (CRUD sederhana).</li></ul> |
| **Peminjam (Anggota)** | Mahasiswa anggota HIMASISFOR yang membutuhkan barang untuk kegiatan organisasi atau tugas. | <ul><li>Masuk ke **Dashboard Anggota**.</li><li>Lihat **Katalog Barang** dengan filter.</li><li>Mengisi **Formulir Pengajuan** (pilih barang, tanggal pinjam/kembali).</li><li>Melacak **Status Pengajuan** dan **Riwayat Pinjaman**.</li><li>Mengirim **Pengembalian** (konfirmasi).</li></ul> |

---

## 3. Daftar Fitur Utama (Core Features)
### 3.1 Dashboard
* **Admin Dashboard** – Ringkasan stok per kategori, grafik pinjaman harian, notifikasi pengajuan menunggu.
* **Anggota Dashboard** – Daftar peminjaman aktif, status terbaru, rekomendasi barang.

### 3.2 Manajemen Data Barang (CRUD)
* **Create** – Tambah barang baru (nama, kode, kategori, jumlah, foto).
* **Read** – Tabel daftar barang dengan pencarian & filter.
* **Update** – Edit detail, ubah stok, ubah foto.
* **Delete** – Hapus barang (soft‑delete, dapat dipulihkan).

### 3.3 Kategori Barang
* Pengelompokan (Elektronik, Alat Berat, Konsumsi, dll.) – CRUD sederhana.

### 3.4 Formulir Pengajuan Peminjaman
* Pilih barang (multi‑select) → Tentukan **tanggal pinjam** & **tanggal kembali**.
* Validasi stok otomatis (tidak dapat meminjam barang yang stoknya 0).
* Simpan sebagai **Status: Menunggu Persetujuan**.

### 3.5 Persetujuan / Penolakan oleh Admin
* Tampilan daftar pengajuan menunggu.
* **Approve** → Status “Dipinjam”, stok berkurang.
* **Reject** → Beri komentar alasan penolakan (email notifikasi ke peminjam).

### 3.6 Pengembalian Barang
* Anggota menandai barang telah dikembalikan.
* Admin memverifikasi kondisi barang (baik / rusak) → Update stok & status.

### 3.7 Riwayat & Laporan
* **Riwayat peminjaman** per anggota (filter tanggal).
* **Laporan stok** (PDF/CSV).
* **Log aktivitas** (audit trail) untuk admin.

### 3.8 Notifikasi
* Email atau *in‑app* notifikasi pada:
  - Pengajuan berhasil dibuat.
  - Persetujuan / penolakan.
  - Jatuh tempo pengembalian (2 hari sebelum).

### 3.9 Autentikasi & Otorisasi
* Registrasi/login menggunakan **email institusi**.
* Middleware Laravel **role‑based** (admin vs. user).

---

## 4. Alur Pengguna (User Flow)
### 4.1 Alur Anggota (Peminjam)
1. **Login** → Dashboard Anggota.
2. **Lihat Katalog** → Filter/kategori, pilih barang.
3. **Isi Form Pengajuan** → Pilih tanggal, tambahkan keterangan.
4. **Submit** → Sistem menampilkan status *Menunggu Persetujuan*.
5. **Notifikasi** (email/ aplikasi) ketika admin memproses.
6. **Jika Disetujui** → Status *Dipinjam*; barang di‑checkout.
7. **Gunakan Barang** → Selama periode pinjam.
8. **Kembalikan Barang** → Klik “Pengembalian”, konfirmasi.
9. **Admin Verifikasi** → Update status menjadi *Selesai*; stok kembali.
10. **Lihat Riwayat** → Semua peminjaman sebelumnya tersedia di tab Riwayat.

### 4.2 Alur Admin (Petugas Inventaris)
1. **Login** → Dashboard Admin.
2. **Kelola Master Data** (barang, kategori, stok).
3. **Cek Pengajuan Masuk** → Daftar permintaan peminjaman.
4. **Review & Verifikasi** → Approve atau Reject dengan komentar.
5. **Update Stok** otomatis saat Approve.
6. **Pantau Pengembalian** → Notifikasi barang mendekati jatuh tempo.
7. **Verifikasi Pengembalian** → Pastikan kondisi, perbarui stok.
8. **Buat Laporan** → Export laporan stok/peminjaman untuk rapat.

---

## 5. Kebutuhan Non‑Fungsional
| Area | Spesifikasi | Keterangan |
|------|-------------|------------|
| **Platform** | **Windows** (development) – Laravel project berada di `d:\Laravel\aplikasi_inventaris_dan_peminjaman_barang` | Semua mahasiswa menggunakan Windows/VS Code. |
| **Bahasa Pemrograman** | **PHP 8.2** (compatible dengan Laravel 10) | Memungkinkan penggunaan fitur modern & tipe data. |
| **Framework** | **Laravel 10** (RESTful, Blade templating) | Struktur MVC, routing, middleware, Eloquent ORM. |
| **Database** | **MySQL 8** (phpMyAdmin UI) | Relasi barang‑kategori‑peminjaman, migrasi schema via Artisan. |
| **Frontend** | **Bootstrap 5** + **Blade** | Responsif, cepat styling tanpa library JS berat. |
| **IDE** | **Visual Studio Code** | Extensions: PHP Intelephense, Laravel Blade Snippets. |
| **Keamanan** | - Password hashing dengan `bcrypt` (Laravel). <br>- CSRF protection (Laravel built‑in). <br>- Role‑based middleware. |
| **Performansi** | - Response time < 2 s untuk halaman utama (lokal). <br>- Query optimisation (indexed `id`, `category_id`). |
| **Skalabilitas** | Aplikasi dapat dipindah ke server LAMP/LEMP tanpa perubahan kode. |
| **Testing** | Unit test dengan **PHPUnit** (contoh model & controller). <br>Feature test dengan **Laravel Dusk** (optional). |
| **Dokumentasi** | README.md berisi instalasi, migrasi, dan cara menjalankan server (`php artisan serve`). |
| **Lisensi** | MIT – bebas distribusi untuk keperluan akademik. |

---

## 6. Daftar Artefak & Deliverables untuk Mahasiswa
| Deliverable | Deskripsi | Estimasi Waktu |
|-------------|-----------|----------------|
| **Requirement Sheet** (PRD – dokumen ini) | Spesifikasi lengkap, user flow, dan non‑functional. | - |
| **Database Design** | ER diagram + migration files. | 1–2 minggu |
| **UI Mockup** | Wireframe sederhana (Bootstrap). | 1 minggu |
| **Core Implementation** | CRUD barang, pengajuan, persetujuan, pengembalian. | 3–4 minggu |
| **Testing Suite** | Unit + feature tests. | 1 minggu |
| **Final Report & Demo** | Dokumentasi instalasi, video demo, presentasi. | 1 minggu |

---

## 7. Acceptance Criteria (Kriteria Penerimaan)
| No. | Fitur | Skenario Pengujian | Hasil yang Diharapkan |
|-----|-------|-------------------|------------------------|
| 1 | **Autentikasi & Otorisasi** | Pengguna mendaftar dengan email HIMASISFOR, login, dan diarahkan ke dashboard yang sesuai per peran. | Admin diarahkan ke *Dashboard Admin*, anggota ke *Dashboard Anggota*. Pengguna yang tidak memiliki peran tidak dapat mengakses route yang diproteksi. |
| 2 | **CRUD Barang & Kategori** | Admin menambah barang “Speaker”, mengubah stok menjadi 10, menghapus kategori “Elektronik”. | Data tersimpan di tabel `items` & `categories`; perubahan segera terlihat pada tabel barang. |
| 3 | **Pengajuan Peminjaman** | Anggota memilih 2 barang, mengisi tanggal valid, meng‑submit. | Status peminjaman di DB menjadi `pending`; notifikasi “Pengajuan berhasil” muncul. |
| 4 | **Validasi Stok** | Anggota mengajukan peminjaman barang yang stoknya 0. | Form tidak dapat disubmit, muncul pesan “Stok tidak mencukupi”. |
| 5 | **Persetujuan Admin** | Admin membuka daftar `pending`, menekan *Approve* pada peminjaman. | Stok barang berkurang sesuai kuantitas, status peminjaman berubah menjadi `approved`, email notifikasi terkirim ke peminjam. |
| 6 | **Penolakan Admin** | Admin menolak peminjaman dengan alasan “Barang dipakai oleh event”. | Status menjadi `rejected`, komentar tersimpan, email notifikasi berisi alasan terkirim. |
| 7 | **Pengembalian Barang** | Anggota menandai barang telah dikembalikan, admin memverifikasi kondisi baik. | Status berubah menjadi `returned`, stok barang bertambah, riwayat tercatat dengan tanggal pengembalian. |
| 8 | **Riwayat & Laporan** | Anggota membuka tab *Riwayat* dan mengekspor CSV. | Tabel menampilkan semua peminjaman anggota, file CSV ter‑download berisi kolom lengkap. |
| 9 | **Notifikasi Jatuh Tempo** | Sistem meng‑send email 2 hari sebelum tanggal kembali. | Anggota menerima email “Pengembalian barang dalam 2 hari”. |
| 10 | **Keamanan** | Pengguna mencoba meng‑inject SQL pada bidang “keterangan”. | Input disanitasi otomatis oleh Eloquent, tidak ada error atau data berubah. |
| 11 | **Responsivitas UI** | Membuka aplikasi di layar 640 px (mobile). | Semua komponen (tabel, form, tombol) menyesuaikan lebar, tetap dapat digunakan (bootstrap responsive). |
| 12 | **Performance Load** | Simulasi 50 concurrent user mengakses katalog. | Waktu respons < 2 detik pada mesin pengembangan standar (i5, 8 GB RAM). |

---

## 8. Risiko & Mitigasi
| Risiko | Dampak | Likelihood | Mitigasi |
|--------|--------|------------|----------|
| **Kurangnya pengalaman Laravel** | Penundaan implementasi fitur CRUD | Sedang | Workshop singkat (Laravel Docs, contoh aplikasi “Todo”). |
| **Masalah kompatibilitas PHP/MySQL versi** | Build gagal di mesin mahasiswa | Rendah (gunakan PHP 8.2 & MySQL 8) | Sediakan Docker/WSL‑Laravel‑Boost‑Env sebagai fallback. |
| **Keterbatasan jaringan (offline)** | Tidak dapat mengakses CDN Bootstrap | Rendah | Simpan Bootstrap lokal (via `npm install bootstrap`). |
| **Pengujian email tidak berjalan** | Notifikasi tidak terkirim | Sedang | Gunakan **Mailtrap** (sandbox SMTP) atau Laravel `log` driver pada environment development. |
| **Data konsistensi stok** | Stok negatif bila dua peminjam mengajukan bersamaan | Sedang | Wrap update stok dalam **transaction** & **row‑level lock** (`SELECT ... FOR UPDATE`). |

---

## 9. Metode Evaluasi Keberhasilan
| Kriteria | Target |
|----------|--------|
| **Fungsional** | Semua alur (CRUD, pengajuan, persetujuan, pengembalian) beroperasi tanpa error. |
| **Usability** | Pengguna (admin & anggota) dapat menyelesaikan proses peminjaman dalam ≤ 3 menit. |
| **Keamanan** | Tidak ada SQL injection / XSS pada laporan keamanan otomatis (Laravel banding). |
| **Kualitas Kode** | PSR‑12 compliance, komentar doc‑block pada semua controller & model. |
| **Testing** | Unit test coverage ≥ 70 % dan semua feature test lulus. |
| **Dokumentasi** | README mencakup instalasi, migrasi, serta cara menjalankan demo. |

---

## 10. Lampiran
### 10.1 Diagram ER (Entity‑Relationship)
```
+----------------+      +----------------+      +-----------------+
| users          |      | roles          |      | categories      |
|----------------|      |----------------|      |-----------------|
| id (PK)        |←---->| id (PK)        |      | id (PK)         |
| name           |      | name           |      | name            |
| email          |      +----------------+      +-----------------+
| password       |
| role_id (FK)---+                     ^
+----------------+                     |
                                      |
+----------------+   +----------------+|
| items          |   | loans          ||
|----------------|   |----------------||
| id (PK)        |   | id (PK)        ||
| name           |   | user_id (FK)   ||
| category_id(FK)----| item_id (FK)   ||
| stock          |   | start_date    ||
| description    |   | end_date      ||
+----------------+   | status        ||
                     +----------------+
```
*status* pada `loans` = {`pending`, `approved`, `rejected`, `returned`}.

### 10.2 Contoh Wireframe (Bootstrap)
| Halaman | Keterangan |
|---------|------------|
| **Dashboard Admin** | Kartu ringkasan: total barang, barang dipinjam, permintaan menunggu; tabel “Pengajuan Terbaru”. |
| **Dashboard Anggota** | List barang dengan filter, tombol “Pinjam”. |
| **Form Pengajuan** | Multi‑select barang, datepicker untuk tanggal pinjam & kembali, textarea keterangan. |
| **Riwayat** | Tabel dengan kolom: Barang, Tanggal Pinjam, Tanggal Kembali, Status, Aksi (detail). |
| **Laporan** | Tombol “Export CSV” di pojok kanan atas. |

### 10.3 Struktur Direktori Proyek (Laravel)
```
/app
   /Http
      /Controllers
         AdminController.php
         ItemController.php
         LoanController.php
   /Models
      User.php
      Role.php
      Item.php
      Category.php
      Loan.php
/resources
   /views
      /admin
         dashboard.blade.php
         items.blade.php
         loans.blade.php
      /user
         catalog.blade.php
         loan_form.blade.php
         history.blade.php
/routes
   web.php
   api.php (optional)
/database
   /migrations
   /seeders
   /factories
/public
   /css   (Bootstrap compiled)
   /js    (optional – Alpine.js for interactivity)
```
---

## 11. Penutup
Dokumen ini dirancang agar **mahasiswa** dapat mengimplementasikan aplikasi INVENTO secara terstruktur, memanfaatkan **Laravel Boost** (yang sudah di‑install pada repository) untuk mempercepat bootstrap proyek. Dengan mengikuti roadmap, tim akan menghasilkan sistem inventaris yang fungsional, aman, dan siap dipresentasikan pada akhir semester.

*Semoga sukses dalam pengembangan! 🚀*


---

## 12. User Stories (Contoh Kasus Penggunaan)

| # | Peran | Cerita Pengguna | Acceptance Criteria |
|---|-------|----------------|----------------------|
| US01 | **Admin** | Sebagai admin, saya ingin menambah barang baru sehingga dapat dicatat dalam inventaris. | Form tambah barang tersedia, semua field wajib diisi, data tersimpan di DB, stok ditampilkan di dashboard. |
| US02 | **Admin** | Sebagai admin, saya ingin melihat daftar pengajuan peminjaman yang menunggu persetujuan sehingga dapat memprosesnya. | Dashboard menampilkan tabel pengajuan `pending`, tombol Approve/Reject berfungsi, notifikasi email dikirim. |
| US03 | **Anggota** | Sebagai anggota, saya ingin mencari barang berdasarkan kategori sehingga dapat menemukan barang yang saya butuhkan. | Fitur filter/kategori pada katalog, hasil pencarian menampilkan barang yang cocok, dapat memilih barang untuk peminjaman. |
| US04 | **Anggota** | Sebagai anggota, saya ingin mengajukan peminjaman barang dengan tanggal tertentu sehingga saya dapat merencanakan penggunaan. | Form peminjaman menerima tanggal mulai & selesai, melakukan validasi stok, status berubah menjadi `pending`, notifikasi muncul. |
| US05 | **Anggota** | Sebagai anggota, saya ingin melihat riwayat peminjaman saya sehingga dapat memeriksa barang yang pernah saya pinjam. | Tab Riwayat menampilkan semua peminjaman anggota, dapat filter tanggal, dapat mengekspor CSV. |
| US06 | **Admin** | Sebagai admin, saya ingin menerima notifikasi ketika barang mendekati tanggal pengembalian sehingga dapat mengingatkan peminjam. | Sistem mengirim email 2 hari sebelum tanggal kembali, notifikasi muncul di dashboard admin. |

---

## 13. API Endpoints (Jika diperlukan untuk Front‑end terpisah)

| Metode | URL | Deskripsi | Request Body | Response |
|--------|-----|-----------|--------------|----------|
| GET | `/api/items` | Dapatkan daftar barang (dapat dipasang filter `?category=id`). | - | JSON array barang |
| POST | `/api/items` | Tambah barang baru (admin). | `{ name, category_id, stock, description }` | Created item JSON |
| PUT | `/api/items/{id}` | Update barang (admin). | `{ name?, category_id?, stock?, description? }` | Updated item JSON |
| DELETE | `/api/items/{id}` | Hapus barang (soft‑delete). | - | 204 No Content |
| POST | `/api/loans` | Ajukan peminjaman (anggota). | `{ item_ids: [], start_date, end_date, notes? }` | Loan JSON with status `pending` |
| PATCH | `/api/loans/{id}/approve` | Approve peminjaman (admin). | - | Loan JSON with status `approved` |
| PATCH | `/api/loans/{id}/reject` | Reject peminjaman (admin). | `{ reason }` | Loan JSON with status `rejected` |
| PATCH | `/api/loans/{id}/return` | Tandai barang telah dikembalikan (anggota). | - | Loan JSON with status `returned` |

> **Catatan:** Endpoint dapat dilindungi dengan Laravel Sanctum / Passport jika dibutuhkan autentikasi token.

---

## 14. Detail Skema Database (Migration Snippets)

```php
// 2024_01_01_000001_create_roles_table.php
Schema::create('roles', function (Blueprint $table) {
    $table->id();
    $table->string('name')->unique(); // admin, member
    $table->timestamps();
});

// 2024_01_01_000002_create_users_table.php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->foreignId('role_id')->constrained('roles');
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
});

// 2024_01_01_000003_create_categories_table.php
Schema::create('categories', function (Blueprint $table) {
    $table->id();
    $table->string('name')->unique();
    $table->timestamps();
});

// 2024_01_01_000004_create_items_table.php
Schema::create('items', function (Blueprint $table) {
    $table->id();
    $table->foreignId('category_id')->constrained('categories');
    $table->string('name');
    $table->integer('stock')->default(0);
    $table->text('description')->nullable();
    $table->string('image_path')->nullable();
    $table->softDeletes();
    $table->timestamps();
});

// 2024_01_01_000005_create_loans_table.php
Schema::create('loans', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained('users');
    $table->foreignId('item_id')->constrained('items');
    $table->date('start_date');
    $table->date('end_date');
    $table->enum('status', ['pending','approved','rejected','returned'])->default('pending');
    $table->text('notes')->nullable();
    $table->text('admin_comment')->nullable();
    $table->timestamps();
});
```

---

## 15. Rencana Pengujian (Testing Plan)

| Tingkat | Fokus | Tools |
|---------|-------|-------|
| Unit | Model relationships, validation rules, helper functions. | **PHPUnit** |
| Feature / Integration | End‑to‑end alur: CRUD barang, ajukan peminjaman, persetujuan, pengembalian. | **Laravel Test Suite** (`php artisan test`) |
| UI / Acceptance | Interaksi visual, responsivitas, notifikasi. | **Laravel Dusk** (optional) atau **Cypress** jika dipisah ke front‑end SPA. |
| Security | CSRF, XSS, SQL injection, akses kontrol per role. | **Laravel Security Scan**, manual pengetesan dengan request tamper. |

Setiap test case harus mencakup **Arrange‑Act‑Assert** dan memberikan contoh data melalui factories.

---

## 16. Panduan Deploy (Deployment Guide)

1. **Persiapan Server** (Linux LAMP/LEMP atau Windows XAMPP)  
   - PHP ≥ 8.2, Composer, MySQL ≥ 8, Git (opsional).
2. **Clone Repository**
   ```bash
   git clone <repo-url> inventory-app
   cd inventory-app
   ```
3. **Install Dependencies**
   ```bash
   composer install --no‑dev
   npm install   # hanya jika ada asset front‑end yang menggunakan npm
   npm run prod  # compile assets (optional)
   ```
4. **Environment Configuration**
   - Copy `.env.example` → `.env`
   - Set `APP_ENV=production`, `APP_DEBUG=false`
   - Isi kredensial DB, mail driver (Mailtrap atau SMTP produksi), dan `APP_URL`.
5. **Generate App Key**
   ```bash
   php artisan key:generate
   ```
6. **Migrate & Seed**
   ```bash
   php artisan migrate --force
   php artisan db:seed --force   # optional seed admin & demo data
   ```
7. **Cache Optimisation**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
8. **Set Permissions** (Linux)
   ```bash
   chown -R www-data:www-data storage bootstrap/cache
   chmod -R 775 storage bootstrap/cache
   ```
9. **Web Server Configuration**
   - **Apache**: Pastikan `AllowOverride All` untuk .htaccess Laravel.
   - **Nginx**: Gunakan contoh config di `nginx.conf` dari dokumentasi Laravel.
10. **Restart Services** & **Test**
    ```bash
    sudo systemctl restart php-fpm nginx   # atau apache2
    curl -I http://your-domain.com
    ```
    Buka browser, login dengan akun admin (seeded) → pastikan semua fitur berfungsi.

---

## 17. FAQ Ringkas
| Pertanyaan | Jawaban |
|------------|---------|
| **Apakah aplikasi harus dijalankan di Windows saja?** | Tidak. Kode Laravel bersifat cross‑platform; Windows hanya untuk development lingkungan mahasiswa. |
| **Bagaimana cara menambah user admin?** | Jalankan seeder `php artisan db:seed --class=AdminUserSeeder` atau buat manual lewat tinker. |
| **Apakah ada batasan jumlah barang?** | Tidak ada batasan khusus; gunakan tipe data `integer` pada kolom `stock`. |
| **Bagaimana meng‑export laporan?** | Pada halaman laporan, terdapat tombol *Export CSV* yang memanggil route `export.loans`. |
| **Apakah aplikasi dapat di‑hosting di platform gratis?** | Ya, dapat di‑host di **Render**, **Railway**, atau **Fly.io** dengan konfigurasi variabel lingkungan yang sesuai. |

---

## 18. Penutup Tambahan
Dokumen ini kini mencakup keseluruhan spesifikasi teknis, user stories, endpoint API, contoh migrasi, rencana testing, serta panduan deploy. Tim mahasiswa dapat mengacu pada **PRD_INVENTO.md** sebagai acuan utama selama siklus pengembangan, serta menyesuaikannya dengan kebutuhan spesifik kelas atau dosen pembimbing.

Selamat mengembangkan aplikasi INVENTO dan semoga proyek ini menjadi pengalaman belajar yang berharga! 🎓🚀

---

## 19. Fase Pengembangan (Roadmap Bertahap)

Agar proyek dapat diselesaikan secara realistis dalam rentang waktu kuliah, berikut pembagian kerja menjadi beberapa fase. Setiap fase memiliki deliverable yang dapat diuji secara independen sebelum melanjutkan ke fase berikutnya.

### Fase 1 – Dasar Autentikasi & Manajemen Master Data
| Kegiatan | Detail | Output |
|----------|--------|--------|
| Setup proyek Laravel Boost | Instalasi, konfigurasi `.env`, migrasi awal. | Repo dapat dijalankan dengan `php artisan serve`. |
| Implementasi **Auth** (Laravel Breeze) | Registrasi & login dengan email HIMASISFOR, role assignment (admin/member). | Dashboard berbeda per role. |
| CRUD **Kategori** & **Barang** (admin) | Model, migration, controller, Blade view (Bootstrap table). | Admin dapat menambah/ubah/hapus barang & kategori. |
| Unit test dasar untuk model & controller | PHPUnit tests untuk `Item` & `Category`. | Coverage ≥ 20 %. |
| Dokumentasi awal di README | Instruksi instalasi, run server. | README ter‑update. |

*Tujuan*: Memiliki aplikasi yang dapat berjalan dengan data master dan login role‑based.

### Fase 2 – Alur Peminjaman (Form & Persetujuan)
| Kegiatan | Detail | Output |
|----------|--------|--------|
| **Formulir Pengajuan** (anggota) | Multi‑select barang, datepicker, validasi stok. | Status `pending` disimpan. |
| **Dashboard Admin – Pengajuan Menunggu** | Tabel pengajuan dengan tombol Approve/Reject. |
| **Logika Approve/Reject** | Update status, adjust stok, kirim notifikasi email (Mailtrap). |
| **Pengembalian Barang** | Anggota tandai *return*, admin verifikasi kondisi. |
| Feature test untuk alur end‑to‑end | Laravel test suite menutup seluruh flow. |
| Update **Riwayat** view (anggota) | Tabel histori peminjaman. |

*Tujuan*: Seluruh siklus peminjaman (request → approval → return) berfungsi.

### Fase 3 – Notifikasi, Laporan & UI Penyempurnaan
| Kegiatan | Detail | Output |
|----------|--------|--------|
| **Notifikasi Jatuh Tempo** | Scheduler (cron) kirim email 2 hari sebelum due date. |
| **Export Laporan CSV / PDF** | Route `export.loans` dan `export.stock`. |
| **Dashboard Ringkasan (Grafik)** | Chart.js atau Bootstrap cards menampilkan statistik. |
| **Responsive UI** | Pengujian pada mobile, perbaikan layout. |
| **Security review** | Pengetesan CSRF, XSS, dan role‑based access. |

*Tujuan*: Fitur pendukung yang meningkatkan UX dan administrasi.

### Fase 4 – Pengujian Lengkap, Dokumentasi & Deploy
| Kegiatan | Detail | Output |
|----------|--------|--------|
| **Coverage Test** | Unit + feature test mencapai ≥ 70 %. |
| **Laravel Dusk (optional)** | UI acceptance test pada browser. |
| **Dokumentasi Lengkap** | README dengan instalasi, deployment guide, API spec, dan FAQ. |
| **Deploy ke Server** | Panduan deploy ke Linux LAMP/LEMP atau layanan gratis (Render, Railway). |
| **Presentasi & Video Demo** | Video 3‑5 menit, slide presentasi. |

*Tujuan*: Proyek siap dipresentasikan, dicek kualitasnya, dan dapat dijalankan di lingkungan produksi.

---

---

## 20. Timeline Detail (Minggu per Fase)

| Minggu | Fase | Fokus Utama | Deliverable |
|--------|------|--------------|------------|
| 1 | Fase 1 | Project setup, auth, CRUD kategori & barang | Repo runnable, admin dapat mengelola master data |
| 2 | Fase 1 | Unit test untuk model, review kode | Coverage ≥ 20 %, README lengkap |
| 3 | Fase 2 | Form pengajuan peminjaman, validasi stok | Form berfungsi, status `pending` tercatat |
| 4 | Fase 2 | Persetujuan / penolakan admin, notifikasi email | Approve/Reject workflow selesai, email terkirim (Mailtrap) |
| 5 | Fase 2 | Pengembalian barang, riwayat peminjaman | Return flow selesai, riwayat tampil |
| 6 | Fase 3 | Notifikasi jatuh tempo (scheduler) | Email reminder otomatis, UI badge di dashboard |
| 7 | Fase 3 | Export laporan CSV & PDF, grafik statistik | Laporan dapat di‑download, chart menampilkan data stok & peminjaman |
| 8 | Fase 3 | Responsivitas mobile, security audit | UI mobile friendly, CSRF/XSS terproteksi |
| 9 | Fase 4 | Feature & unit test coverage ≥ 70 % | Semua test lulus, laporan coverage |
| 10 | Fase 4 | Deployment ke staging (Render/Railway) | Aplikasi live, link demo diberikan |
| 11 | Fase 4 | Dokumentasi akhir, video demo, presentasi | PDF laporan, video .mp4, slide PowerPoint |
| 12 | Fase 4 | Final review & penilaian akhir | Penilaian dosen, feedback perbaikan |

---

## 21. Milestones & Acceptance Checklist

| Milestone | Checkpoints | Done When |
|-----------|-------------|----------|
| **M1 – Project Scaffold** | Laravel Boost ter‑install, .env konfigurasi, `php artisan serve` berjalan. | Semua tim dapat mengakses `http://localhost:8000` tanpa error. |
| **M2 – Role‑Based Auth** | Registrasi, login, redirect ke dashboard yang tepat. | Admin & anggota masing‑masing melihat UI berbeda. |
| **M3 – Master Data CRUD** | Admin dapat menambah, edit, hapus kategori & barang. | Data tersimpan, UI menampilkan perubahan real‑time. |
| **M4 – Peminjaman Flow** | Pengajuan, approval, return, riwayat lengkap. | End‑to‑end test (feature) lulus, status berubah sesuai. |
| **M5 – Notification System** | Email reminder, notifikasi dalam aplikasi. | Email diterima di Mailtrap, badge muncul di dashboard. |
| **M6 – Reporting** | Export CSV & PDF, chart statistik. | File dapat di‑download, chart menampilkan nilai yang tepat. |
| **M7 – Quality Assurance** | Unit + feature coverage ≥ 70 %, security review selesai. | `php artisan test --coverage` menunjukkan persentase, tidak ada vulnerability high. |
| **M8 – Deploy & Demo** | Aplikasi live di platform publik, video demo selesai. | Link deploy dibagikan, video 3‑5 menit siap dipresentasikan. |

---

## 22. Tools & Environment Checklist

| Kategori | Alat / Versi | Catatan |
|----------|--------------|--------|
| **IDE** | Visual Studio Code (latest) + extensions (PHP Intelephense, Laravel Blade) | Semua mahasiswa sudah ter‑install. |
| **Version Control** | Git + GitHub Classroom (repo private) | Branch `main` untuk deliverable akhir, `feature/*` untuk tiap fase. |
| **Dependency Manager** | Composer 2.x, npm (optional) | `composer install --no-dev` untuk produksi. |
| **Database** | MySQL 8 (phpMyAdmin) | Buat schema `inventoris` di local. |
| **Testing** | PHPUnit 10, Laravel Dusk (optional) | `php artisan test` dijalankan setiap commit. |
| **CI (optional)** | GitHub Actions (laravel.yml) | Otomatis run test pada push. |
| **Deployment** | Render (free tier) atau Railway | Pastikan variabel environment di‑set. |
| **Email Mock** | Mailtrap (sandbox) | Gunakan `MAIL_MAILER=smtp` dengan credential Mailtrap. |

---

## 23. Communication & Collaboration Plan

1. **Daily Stand‑up (30 menit)** – via Discord voice channel atau Microsoft Teams. Setiap anggota menyampaikan apa yang dikerjakan, apa yang terhambat, dan rencana hari ini.
2. **Weekly Review Meeting (1 jam)** – pada hari Jumat, presentasi progres ke dosen pembimbing, dapatkan feedback.
3. **Issue Tracker** – gunakan GitHub Issues dengan label `phase-1`, `phase-2`, dsb. Setiap tugas dibuat sebagai issue, dipindahkan ke *Done* bila selesai.
4. **Pull Request Review** – minimal satu rekan tim harus memberi review sebelum merge ke `main`.
5. **Documentation Updates** – setiap selesai milestone, update README dan bagian terkait di PRD.

---

## 24. Evaluation Metrics (KPI) untuk Penilaian

| KPI | Target | Metode Pengukuran |
|-----|--------|-------------------|
| **Fungsional Completeness** | ≥ 90 % fitur core selesai | Checklist fase (M1‑M8). |
| **Code Quality** | PSR‑12 compliance, lint free | `phpcs` atau `phpstan` run pada CI. |
| **Test Coverage** | ≥ 70 % (unit + feature) | `php artisan test --coverage` report. |
| **Performance** | Response time < 2 s pada halaman utama | Chrome DevTools > Network timing. |
| **User Experience** | Nilai ≥ 4 pada skala 1‑5 (survey anggota) | Form Google Form setelah demo. |
| **Documentation** | README lengkap, deployment guide, API spec | Review dokumen oleh dosen. |

---

## 25. Closing Remarks
Dokumen PRD ini kini mencakup seluruh spek, roadmap fase, timeline, milestones, tools, komunikasi, dan metrik evaluasi. Dengan mengikuti panduan ini, tim mahasiswa dapat menyelesaikan **INVENTO** secara terstruktur, menghasilkan produk yang dapat dipakai nyata oleh HIMASISFOR, serta memperoleh nilai akademik yang tinggi.

Selamat bekerja dan semoga sukses!

---

## 26. Future Enhancements (Roadmap Jangka Panjang)
| Versi | Fitur Potensial | Manfaat |
|-------|----------------|---------|
| **v2.0** | **Barcode / QR Code Integration** – Setiap barang memiliki kode QR yang dapat dipindai untuk mempercepat proses checkout/inventaris. | Mengurangi waktu input manual, meminimalisir human error. |
| **v2.1** | **Mobile App (React Native / Flutter)** – Aplikasi native untuk Android & iOS dengan push notification. | Memungkinkan anggota mengajukan dan melacak peminjaman langsung dari ponsel. |
| **v2.2** | **Room / Location Management** – Barang dapat dikelompokkan per ruangan atau laboratorium. | Mempermudah tracking barang pada lokasi fisik tertentu. |
| **v3.0** | **Advanced Reporting & Analytics** – Dashboard analytics dengan filter lanjutan, export ke Excel, integrasi ke Power BI. | Memberikan insight strategis bagi HIMASISFOR dalam pengelolaan aset. |
| **v3.1** | **Role Hierarchy & Delegasi** – Admin dapat memberikan delegasi kepada petugas sementara. | Fleksibilitas manajemen tim dalam organisasi besar. |
| **v3.2** | **Integration with Google Calendar** – Sinkronisasi tanggal peminjaman ke kalender anggota. | Menghindari bentrok jadwal dan meningkatkan kepatuhan pengembalian. |
| **v4.0** | **Machine Learning Forecast** – Prediksi kebutuhan stok berdasarkan tren peminjaman sebelumnya. | Membantu perencanaan pembelian barang baru secara proaktif. |

---

## 27. Glossary (Istilah Penting)
- **CRUD**: Create, Read, Update, Delete – operasi dasar pada data.
- **Role‑Based Access Control (RBAC)**: Pengaturan akses berdasarkan peran (admin, member).
- **Soft Delete**: Penghapusan data yang tidak menghapus baris secara fisik, melainkan menandainya sebagai *deleted*.
- **Scheduler**: Laravel task scheduler yang menjalankan perintah secara periodik (mis. notifikasi jatuh tempo).
- **Factory**: Laravel model factory untuk menghasilkan data dummy pada testing.
- **Seeder**: Script yang meng‑seed data awal (contoh admin user, kategori default).
- **Mailtrap**: Layanan sandbox email untuk menguji pengiriman email tanpa mengirim ke dunia nyata.
- **CI/CD**: Continuous Integration / Continuous Deployment – otomatisasi build, test, dan deploy.
- **PSR‑12**: Standar coding style PHP yang direkomendasikan.

---

## 28. References & Resources
| No. | Resource | Link |
|-----|----------|------|
| 1 | Laravel 10 Documentation | https://laravel.com/docs/10.x |
| 2 | Bootstrap 5 Docs | https://getbootstrap.com/docs/5.0/getting-started/introduction/ |
| 3 | Laravel Boost Repository (installed) | https://github.com/laravel/boost |
| 4 | Mailtrap Documentation | https://mailtrap.io/docs |
| 5 | GitHub Actions Laravel Workflow Example | https://github.com/laravel/actions/tree/master/laravel.yml |
| 6 | Render Free Tier Guide | https://render.com/docs/free |
| 7 | Railway Documentation | https://docs.railway.app/ |
| 8 | PSR‑12 Coding Style Guide | https://www.php-fig.org/psr/psr-12/ |
| 9 | PHPUnit 10 Docs | https://phpunit.de/documentation.html |
|10 | Laravel Dusk (Browser Testing) | https://laravel.com/docs/10.x/dusk |

---

## 29. Sign‑off (Persetujuan)
Dokumen ini disetujui oleh:

- **Dosen Pembimbing**: ________________________ (tanda tangan)
- **Ketua Tim Mahasiswa**: ________________________ (tanda tangan)
- **Anggota Tim**: ________________________ (tanda tangan masing‑masing)

Tanggal Persetujuan: ____________

---

*Dokumen ini bersifat hidup; revisi dapat dilakukan seiring perkembangan proyek.*
