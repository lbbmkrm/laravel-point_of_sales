# QIO Coffee - Point of Sales & Landing Page

Sistem integrasi Point of Sales (POS) dan Landing Page yang dibangun menggunakan **TALL Stack** (Tailwind, Alpine.js, Laravel, Livewire) untuk menunjang operasional dan kredibilitas digital UMKM.

## ✨ Fitur Utama

- **Dashboard Interaktif**: Ringkasan statistik penjualan yang disesuaikan per peran.
- **Sistem Kasir (POS)**: Antarmuka yang cepat dan responsif untuk input pesanan, hitung otomatis, dan cetak struk virtual.
- **Riwayat Transaksi**: Pencarian transaksi mendalam berdasarkan ID, Kasir, hingga Nama Produk yang dibeli.
- **Manajemen Produk**: Kelola menu (harga, kategori, foto) dengan sinkronisasi otomatis ke Landing Page.
- **Landing Page Profesional**: Etalase digital otomatis yang menampilkan Menu, Tentang Kami, Galeri, dan Testimoni pelanggan.
- **Lokalisasi Penuh**: Dikonfigurasi menggunakan **Waktu Indonesia Barat (WIB)** dan Bahasa Indonesia.

## 🚀 Teknologi

- **Backend**: Laravel 11
- **Frontend Logic**: Livewire 3 & Volt (Single File Components)
- **Styling**: Tailwind CSS 4
- **Database**: MySQL
- **Icons**: Remix Icon

## 🛠️ Instalasi

1.  Clone repositori ini:
    ```bash
    git clone https://github.com/lbbmkrm/laravel-point_of_sales.git
    ```
2.  Install dependensi PHP:
    ```bash
    composer install
    ```
3.  Install dependensi Frontend:
    ```bash
    npm install && npm run dev
    ```
4.  Salin file lingkungan:
    ```bash
    cp .env.example .env
    ```
5.  Generate kunci aplikasi:
    ```bash
    php artisan key:generate
    ```
6.  Migrasi dan Seed database:
    ```bash
    php artisan migrate:fresh --seed
    ```

## 📄 Dokumentasi Tambahan

Detail mengenai sistem dapat ditemukan di folder `docs/`:

- [Daftar Rute (API/Endpoints)](docs/APP_ROUTES.md)
- [Backlog Fitur](docs/PRODUCT_BACKLOG.md)
- [Hak Akses & Role](docs/FEATURE_ACCESS_BY_ROLE.md)
- [Desain Database](docs/DATABASE_DESIGN.md)

---

_Dibuat untuk tugas akhir pengembangan sistem informasi akuntansi/bisnis._
