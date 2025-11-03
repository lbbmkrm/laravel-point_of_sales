# Dokumentasi Fitur dan Hak Akses Berdasarkan Peran

Dokumen ini menjelaskan fitur-fitur yang tersedia di setiap halaman utama aplikasi dan bagaimana hak akses dibedakan berdasarkan peran pengguna: `Owner` dan `Cashier`.

Tujuan dari pemisahan ini adalah untuk menerapkan prinsip *least privilege*, di mana setiap pengguna hanya dapat melihat dan melakukan tindakan yang relevan dengan tanggung jawab mereka, sehingga meningkatkan keamanan dan fokus alur kerja.

---

## 1. Halaman Dashboard (`/dashboard`)

**Tujuan:** Memberikan gambaran umum dan sekilas tentang aktivitas bisnis saat ini serta menyediakan navigasi cepat.

| Fitur                  | Akses `Owner`                                                                                             | Akses `Cashier`                                                                                             |
| :--------------------- | :-------------------------------------------------------------------------------------------------------- | :---------------------------------------------------------------------------------------------------------- |
| **Kartu Statistik**    | **Penuh.** Dapat melihat semua kartu, termasuk data finansial sensitif (Pendapatan Hari Ini, Bulanan, dll.). | **Terbatas.** Hanya melihat kartu operasional (misal: Jumlah Transaksi Hari Ini). Kartu finansial disembunyikan. |
| **Aksi Cepat**         | **Penuh.** Melihat semua tombol navigasi: Kasir, Kelola Produk, dan Laporan.                               | **Terbatas.** Hanya melihat tombol "Kasir". Tombol lain yang tidak relevan dengan tugasnya disembunyikan.      |
| **Transaksi Terbaru**  | **Penuh.** Dapat melihat daftar transaksi yang baru saja terjadi.                                          | **Penuh.** Dapat melihat daftar transaksi yang baru saja terjadi, relevan untuk operasional harian.         |

---

## 2. Halaman Kasir (`/cashier`)

**Tujuan:** Antarmuka utama untuk memproses transaksi penjualan pelanggan.

| Fitur                       | Akses `Owner`                                                                                             | Akses `Cashier`                                                                                           |
| :-------------------------- | :-------------------------------------------------------------------------------------------------------- | :-------------------------------------------------------------------------------------------------------- |
| **Grid Produk**             | **Penuh.** Dapat melihat dan memilih semua produk untuk ditambahkan ke keranjang.                         | **Penuh.** Dapat melihat dan memilih semua produk untuk ditambahkan ke keranjang.                         |
| **Keranjang Belanja (Cart)**| **Penuh.** Dapat menambah, mengurangi, atau menghapus item dari keranjang.                                | **Penuh.** Dapat menambah, mengurangi, atau menghapus item dari keranjang.                                |
| **Penyelesaian Transaksi**  | **Penuh.** Dapat menyelesaikan transaksi dan mencatat penjualan.                                          | **Penuh.** Dapat menyelesaikan transaksi dan mencatat penjualan.                                          |

**Catatan:** Fungsionalitas di halaman ini identik untuk kedua peran, karena seorang `Owner` mungkin perlu melakukan tugas kasir.

---

## 3. Halaman Manajemen Produk (`/products`)

**Tujuan:** Mengelola menu atau daftar produk yang dijual, termasuk harga dan detail lainnya.

| Fitur                  | Akses `Owner`                                                                                             | Akses `Cashier`                                                                                             |
| :--------------------- | :-------------------------------------------------------------------------------------------------------- | :---------------------------------------------------------------------------------------------------------- |
| **Melihat Daftar Produk**| **Penuh.** Dapat melihat seluruh daftar produk yang ada di sistem.                                        | **Tidak Ada.** Halaman ini tidak dapat diakses. Mencoba mengakses akan menghasilkan error `403 Forbidden`.     |
| **Menambah Produk**    | **Penuh.** Dapat menambahkan produk baru ke dalam menu.                                                   | **Tidak Ada.**                                                                                              |
| **Mengedit Produk**    | **Penuh.** Dapat mengubah detail produk yang sudah ada (misal: nama, harga).                              | **Tidak Ada.**                                                                                              |
| **Menghapus Produk**   | **Penuh.** Dapat menghapus produk dari sistem.                                                            | **Tidak Ada.**                                                                                              |

---

## 4. Halaman Laporan (`/reports`)

**Tujuan:** Menyediakan alat analisis untuk memahami kinerja bisnis melalui data historis.

| Fitur                       | Akses `Owner`                                                                                             | Akses `Cashier`                                                                                             |
| :-------------------------- | :-------------------------------------------------------------------------------------------------------- | :---------------------------------------------------------------------------------------------------------- |
| **Filter Tanggal**          | **Penuh.** Dapat memilih rentang tanggal untuk menganalisis data penjualan.                                 | **Tidak Ada.** Halaman ini tidak dapat diakses. Mencoba mengakses akan menghasilkan error `403 Forbidden`.     |
| **Ringkasan & Grafik**      | **Penuh.** Dapat melihat semua data agregat (total penjualan, produk terlaris) dan visualisasi data.        | **Tidak Ada.**                                                                                              |
| **Ekspor Laporan**          | **Penuh.** Memiliki akses ke fungsionalitas ekspor data (jika tersedia).                                    | **Tidak Ada.**                                                                                              |

---

## Ringkasan Akses Halaman

| Halaman                 | URI            | Akses `Owner` | Akses `Cashier` |
| :---------------------- | :------------- | :------------ | :-------------- |
| **Dashboard**           | `/dashboard`   | Penuh         | Terbatas        |
| **Kasir**               | `/cashier`     | Penuh         | Penuh           |
| **Manajemen Produk**    | `/products`    | Penuh         | Tidak Ada       |
| **Laporan**             | `/reports`     | Penuh         | Tidak Ada       |
