# Arsitektur Proyek: POS QIO Coffee

Dokumen ini memberikan gambaran umum tentang arsitektur teknis, struktur folder, dan pola desain yang digunakan dalam proyek ini. Tujuannya adalah untuk membantu developer (atau AI) baru agar dapat memahami codebase dengan cepat.

## 1. Gambaran Umum & Teknologi

Aplikasi ini adalah sistem Point of Sales (POS) yang dibangun menggunakan **TALL Stack** dengan pendekatan modern:

-   **T**ailwind CSS: Utility-first CSS framework.
-   **A**lpine.js: Framework JavaScript minimalis untuk interaktivitas sisi klien.
-   **L**aravel: Framework PHP sebagai backend utama.
-   **L**ivewire & **Volt**: Digunakan untuk membangun antarmuka yang dinamis dan reaktif tanpa meninggalkan PHP. Volt memungkinkan penulisan komponen dalam satu file Blade (single-file components).

## 2. Pola Arsitektur Utama: Component-Service-Repository

Proyek ini secara disiplin menerapkan pola arsitektur berlapis untuk memisahkan tanggung jawab (`Separation of Concerns`). Aliran data dan logika untuk operasi-operasi penting mengikuti pola berikut:

**`Livewire Component` -> `Service` -> `Repository`**

1.  **Livewire Component (UI & State Management):**

    -   **Lokasi:** `resources/views/livewire/`
    -   **Tanggung Jawab:** Mengelola state dari UI (misalnya, isi keranjang belanja, input form, status modal). Menangkap interaksi pengguna (klik tombol) dan memanggil `Service` yang sesuai. **Tidak berisi logika bisnis atau query database secara langsung.**
    -   **Contoh:** `cashier.blade.php`, `product.blade.php`.

2.  **Service (Business Logic):**

    -   **Lokasi:** `app/Services/`
    -   **Tanggung Jawab:** Berisi semua logika bisnis inti. Mengorkestrasi data dari beberapa sumber jika perlu, melakukan kalkulasi, dan membuat keputusan. Memanggil `Repository` untuk berinteraksi dengan database.
    -   **Contoh:** `TransactionService` berisi logika untuk proses checkout, `ProductService` untuk mengelola produk.

3.  **Repository (Data Access Layer):**
    -   **Lokasi:** `app/Repositories/`
    -   **Tanggung Jawab:** Satu-satunya lapisan yang berkomunikasi langsung dengan Eloquent Model dan database. Bertugas untuk mengambil, membuat, mengubah, dan menghapus data. Ini mengabstraksi query database dari sisa aplikasi.
    -   **Contoh:** `ProductRepository` berisi method `getAll()`, `create()`, `update()`.

Pola ini membuat aplikasi sangat **modular, mudah di-maintain, dan mudah di-test**.

## 3. Struktur Direktori Penting

Berikut adalah panduan untuk direktori-direktori utama dalam proyek:

-   `app/`

    -   `Http/Controllers/`: Sangat minimalis karena sebagian besar logika halaman ditangani oleh komponen Livewire/Volt.
    -   `Livewire/Forms/`: Berisi _Form Objects_ Livewire. Digunakan untuk mengisolasi properti form dan aturan validasinya dari komponen utama. Contoh: `ProductForm.php`.
    -   `Models/`: Berisi Eloquent Model yang mendefinisikan skema tabel dan relasi antar data. Contoh: `Product.php`, `Transaction.php`.
    -   `Providers/`: Berisi Service Provider, termasuk `VoltServiceProvider.php` yang meng-scan komponen Volt.
    -   `Repositories/`: Lapisan akses data (lihat penjelasan di atas).
    -   `Services/`: Lapisan logika bisnis (lihat penjelasan di atas).

-   `database/`

    -   `factories/`: Untuk membuat data dummy saat testing atau seeding.
    -   `migrations/`: Skema database dalam bentuk kode.
    -   `seeders/`: Untuk mengisi database dengan data awal (misal: `UserSeeder`, `ProductSeeder`).

-   `resources/`

    -   `css/`, `js/`: Aset frontend yang akan di-compile oleh Vite.
    -   `views/`:
        -   `layouts/`: Berisi layout utama aplikasi (`app.blade.php`, `guest.blade.php`).
        -   `livewire/`: **Direktori paling penting.** Berisi file-file komponen Volt yang menyatukan logika PHP dan markup Blade HTML.

-   `routes/`

    -   `web.php`: Mendefinisikan rute aplikasi. Menggunakan `Volt::route()` untuk menghubungkan URL ke komponen Volt secara langsung.

-   `tests/`
    -   `Feature/`: Berisi _feature tests_ yang menguji fungsionalitas dari sudut pandang pengguna. Proyek ini memiliki cakupan tes yang baik untuk fitur-fitur krusial seperti `CashierTest.php` dan `ProductManagementTest.php`.

## 4. Contoh Alur Kerja: Checkout Transaksi

Untuk memahami bagaimana semua bagian ini bekerja sama, berikut adalah alur kerja saat kasir menyelesaikan transaksi:

1.  **UI (View):** Kasir mengklik tombol "Bayar Sekarang" di `cashier.blade.php`. Ini memicu `wire:click="openCheckoutModal"`.
2.  **Component:** Di dalam `cashier.blade.php`, method `openCheckoutModal()` mengubah state `$showCheckout = true`. Setelah kasir mengisi detail dan mengklik "Konfirmasi Pembayaran", method `checkout()` dipanggil.
3.  **Validation:** Method `checkout()` memvalidasi input.
4.  **Service:** Method `checkout()` memanggil `TransactionService->createTransaction()` dan mengirimkan data yang relevan (ID user, total harga, isi keranjang).
5.  **DB Transaction:** `TransactionService` memulai `DB::transaction()`.
6.  **Repository:** Di dalam transaksi, `TransactionService` memanggil:
    -   `TransactionRepository->create()` untuk membuat record baru di tabel `transactions`.
    -   `TransactionDetailRepository->create()` dalam sebuah loop untuk menyimpan setiap item di keranjang ke tabel `transaction_details`.
7.  **Commit/Rollback:** Jika semua berhasil, `DB::transaction` akan `commit`. Jika ada satu saja error, semua akan di-`rollback`.
8.  **Component Update:** `TransactionService` mengembalikan data transaksi yang baru dibuat. Komponen `cashier.blade.php` kemudian me-reset state-nya (mengosongkan keranjang) dan menampilkan modal sukses.

---

Dokumen ini seharusnya memberikan fondasi yang kuat untuk memahami proyek. Kode ini terstruktur dengan baik, bersih, dan siap untuk pengembangan lebih lanjut.
