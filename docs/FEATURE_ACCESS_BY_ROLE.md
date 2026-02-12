# Dokumentasi Fitur dan Hak Akses Berdasarkan Peran

Aplikasi QIO Coffee membagi hak akses ke dalam dua peran utama: **Owner** (Pemilik) dan **Cashier** (Staff/Kasir).

---

## 1. Perbandingan Hak Akses Halaman

| Halaman            | URI             | Akses `Owner` | Akses `Cashier` | Keterangan                               |
| :----------------- | :-------------- | :------------ | :-------------- | :--------------------------------------- |
| **Dashboard**      | `/dashboard`    | ✅ Ya         | ✅ Ya           | Statistik ringkas berbeda per peran.     |
| **Kasir**          | `/cashier`      | ✅ Ya         | ✅ Ya           | Halaman utama untuk input pesanan.       |
| **Riwayat**        | `/history`      | ✅ Ya         | ✅ Ya           | Melihat daftar struk dan detail belanja. |
| **Produk**         | `/products`     | ✅ Ya         | ❌ Tidak        | Staff hanya bisa melihat di menu Kasir.  |
| **Laporan**        | `/reports`      | ✅ Ya         | ❌ Tidak        | Analisis pendapatan & performa bisnis.   |
| **Manajemen User** | `/users`        | ✅ Ya         | ❌ Tidak        | Pengelolaan akun staff.                  |
| **Testimoni**      | `/testimonials` | ✅ Ya         | ❌ Tidak        | Kurasi testimoni untuk Landing Page.     |
| **Galeri**         | `/galleries`    | ✅ Ya         | ❌ Tidak        | Upload foto aktivitas kedai.             |

---

## 2. Rincian Fitur per Halaman

### A. Dashboard (`/dashboard`)

- **Owner**: Melihat total pendapatan riil (Hari ini, Minggu ini, Bulan ini) dalam angka Rupiah.
- **Cashier**: Hanya melihat jumlah total transaksi (lembar struk) tanpa nominal uang yang sensitif.

### B. Kasir (`/cashier`)

- **Keduanya**: Menambah produk ke cart, mengelola kuantitas, input jumlah bayar, melihat kembalian, dan cetak sukses transaksi.

### C. Riwayat Transaksi (`/history`)

- **Keduanya**: Mencari transaksi berdasarkan ID, Nama Kasir, atau **Nama Produk**. Menggunakan filter rentang tanggal.

### D. Manajemen Produk (`/products`)

- **Owner**: Akses penuh CRUD (Create, Read, Update, Delete) termasuk upload gambar produk.
- **Cashier**: Akses ditolak (403 Forbidden).

### E. Laporan & Admin Menu (`/reports`, `/users`, dll)

- **Owner**: Digunakan untuk evaluasi bisnis dan pengaturan konten landing page.
- **Cashier**: Akses ditolak melalui middleware `role:owner`.

---

## 3. Sistem Keamanan

1.  **Middleware**: Menggunakan `auth` untuk login umum dan `role:owner` untuk proteksi rute administratif.
2.  **Laravel Gates**: Proteksi di level komponen (misal: tombol 'Hapus' hanya muncul jika Gate mengizinkan).
3.  **UI Shadowing**: Elemen navigasi di sidebar hanya dimunculkan jika user memiliki peran yang sesuai.
