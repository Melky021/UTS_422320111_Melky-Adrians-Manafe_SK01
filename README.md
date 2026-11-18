# UTS PPWL — SK01 Bank Benih Pusaka (Laravel 12 + MySQL)

Aplikasi administrasi koleksi benih varietas lokal.

| Kebutuhan soal | Implementasi |
|---|---|
| Data utama (kode & nama aksesi) | `aksesi_benihs` — `AksesiBenihController` (Resource) |
| Kategori (kelompok tanaman) | `kelompok_tanamans` — `KelompokTanamanController` (Resource) |
| Detail (1 aksesi : 1 asal pengumpulan) | `asal_pengumpulans` — `hasOne`, FK `aksesi_benih_id` **UNIQUE** |
| Pilihan jamak (perlakuan penyimpanan) | pivot `aksesi_perlakuan` — `belongsToMany`, checkbox + `sync()` |
| Pencarian | scope `search` (kode, nama, nama ilmiah, kabupaten, provinsi) |
| Filter | kelompok, perlakuan, status (scope + `when`) + sorting whitelist |
| Validasi | `StoreAksesiBenihRequest`, `UpdateAksesiBenihRequest`, `$request->validate()` di master |
| Simpan ke DB | `AksesiBenihService` memakai `DB::transaction()` |
| Blade | layout, partial, component (`resources/views`) |
| Diagram | `docs/ERD.png`, `docs/ClassDiagram.png` |

## Cara pasang otomatis
Windows (terminal Laragon): `powershell -ExecutionPolicy Bypass -File .\setup.ps1`  
Linux/macOS: `bash setup.sh`

## Cara pasang manual (di atas project Laravel 12 baru)

```bash
composer create-project laravel/laravel:^12.0 UTS_422320111_Melky-Adrians-Manafe_SK01
cd UTS_422320111_Melky-Adrians-Manafe_SK01
```
1. **Salin** isi folder zip ini (`app`, `database`, `public`, `resources`, `routes`, `docs`) ke project, timpa file yang sama (`routes/web.php`, `AppServiceProvider.php`, `DatabaseSeeder.php`).
2. Buat database kosong di MySQL, mis. `bank_benih`, lalu atur `.env`:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=bank_benih
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. Jalankan:
   ```bash
   php artisan migrate:fresh --seed
   php artisan route:list
   php artisan serve
   ```
   *Alternatif:* import `database/bank_benih.sql` lalu tetap jalankan `php artisan migrate` sekali (membuat tabel bawaan Laravel seperti `sessions`).
4. Buka http://127.0.0.1:8000 (tidak perlu `npm`; CSS ada di `public/css/benih.css`).

## Alur satu request: tambah aksesi

1. Browser `GET /aksesi/create` → `public/index.php` → middleware → Router → `AksesiBenihController@create` → view `aksesi.create` (form + master kelompok & perlakuan).
2. Submit `POST /aksesi` → `StoreAksesiBenihRequest` memvalidasi (gagal ⇒ kembali ke form + `old()` + `@error`).
3. Lolos ⇒ `store()` memanggil `AksesiBenihService::buat()`.
4. Service membuka `DB::transaction`: insert `aksesi_benihs` → insert `asal_pengumpulans` lewat `hasOne` → `perlakuans()->sync()` ke pivot. Jika salah satu gagal ⇒ **rollback semua**.
5. Redirect ke `aksesi.show` + flash message sukses.

## Alasan desain
- **Kenapa 1:1 memakai `unique` pada FK?** Agar database sendiri menjamin maksimal satu detail per aksesi.
- **Kenapa pivot untuk perlakuan?** Satu aksesi bisa punya banyak perlakuan dan satu perlakuan dipakai banyak aksesi (N:M).
- **restrictOnDelete vs cascadeOnDelete?** Kelompok/perlakuan = master, tidak boleh dihapus bila dipakai (restrict). Detail asal & baris pivot ikut hilang bila aksesi dihapus (cascade).
- **Kenapa Service + transaction?** Satu aksi menulis 3 tabel; harus atomik.
- **Kenapa `withQueryString()`?** Agar search/filter tidak hilang saat pindah halaman.
- **Kenapa sorting whitelist?** Mencegah input kolom sembarang dari user ke `orderBy`.
- **Eager loading** (`with`) di index mencegah N+1 query.

## Skenario uji manual
1. `/aksesi` tampil 10 data seed + pagination.
2. Cari "cianjur" → hanya Pandanwangi (pencarian lintas relasi).
3. Filter kelompok/perlakuan/status + urutan.
4. Tambah dengan form kosong → pesan validasi.
5. Tambah dengan kode duplikat (mis. `PDI-001`) → ditolak.
6. Tambah valid → data muncul di 3 tabel.
7. Edit → ubah perlakuan (centang/lepas) → pivot berubah.
8. Hapus aksesi → detail asal & pivot ikut terhapus.
9. Hapus kelompok yang masih dipakai → ditolak dengan pesan.
10. Buka `/aksesi/9999` → 404.