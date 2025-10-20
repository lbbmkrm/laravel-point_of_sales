# BLUEPRINT PENELITIAN DAN PENGEMBANGAN SISTEM

## Rancang Bangun Aplikasi Point of Sales (POS) Terintegrasi Landing Page untuk Efisiensi Operasional dan Peningkatan Kredibilitas Digital

---

### 1. Judul Penelitian yang Diajukan

**RANCANG BANGUN SISTEM POINT OF SALES (POS) BERBASIS WEB DENGAN INTEGRASI LANDING PAGE UNTUK MENINGKATKAN KREDIBILITAS DIGITAL DAN EFISIENSI OPERASIONAL (STUDI KASUS: QIO COFFEE, MEDAN)**

---

### 2. Pendahuluan (Latar Belakang Masalah)

Di era digital, keberhasilan UMKM seperti kedai kopi tidak hanya bergantung pada kualitas produk, tetapi juga pada efisiensi operasional dan citra profesional. Studi kasus pada **QIO Coffee**, sebuah kedai kopi fiktif di **Medan**, merepresentasikan tantangan ganda yang dihadapi banyak usaha serupa:

1.  **Tantangan Kredibilitas Digital:** Kehadiran online yang profesional adalah kunci untuk membangun kepercayaan pelanggan. Namun, QIO Coffee mengandalkan pembaruan manual di media sosial untuk informasi menu dan harga. Praktik ini sering menimbulkan **inkonsistensi data** antara informasi online dan kondisi nyata di kasir, yang dapat merusak kredibilitas dan citra profesional usaha.
2.  **Tantangan Efisiensi Operasional:** Di sisi internal, proses transaksi yang masih manual menghambat kecepatan layanan dan berisiko menimbulkan pencatatan yang tidak akurat, yang berisiko pada kerugian finansial.

Untuk menjawab tantangan tersebut, penelitian ini mengusulkan pengembangan sebuah sistem terpadu yang menyatukan **Aplikasi POS** untuk operasional internal dengan sebuah **Landing Page Publik** yang datanya tersinkronisasi, guna meningkatkan efisiensi sekaligus membangun kredibilitas digital yang kuat.

---

### 3. Rumusan Masalah Penelitian

Penelitian ini akan menjawab pertanyaan-pertanyaan berikut:

1.  Bagaimana merancang arsitektur sistem berbasis **TALL Stack** yang mampu melayani aplikasi POS internal dan *landing page* publik secara efisien untuk studi kasus 'QIO Coffee'?
2.  Bagaimana merancang dan membangun modul manajemen menu yang efisien bagi pemilik usaha?
3.  Sejauh mana sebuah *landing page* yang datanya terintegrasi secara *real-time* dengan database POS dapat meningkatkan kredibilitas digital dengan menjamin konsistensi informasi bagi pelanggan?

---

### 4. Ruang Lingkup dan Batasan Proyek

Untuk menjaga fokus penelitian, proyek ini dibatasi pada aspek-aspek berikut:

1.  **Studi Kasus:** Sistem dirancang berdasarkan alur kerja dan kebutuhan yang disimulasikan untuk **QIO Coffee, Medan**.
2.  **Platform:** Sistem dikembangkan sebagai Aplikasi Berbasis Web. Tidak ada pengembangan aplikasi *native mobile*.
3.  **Teknologi:** Aplikasi dibangun secara spesifik menggunakan **TALL Stack** (Tailwind CSS, Alpine.js, Laravel, Livewire).
4.  **Fitur Inti:** Pengembangan difokuskan pada **Modul Transaksi (Kasir), Manajemen Produk (Menu), Laporan Penjualan Dasar, dan sebuah Landing Page Publik** untuk profil dan menu usaha.
5.  **Fungsionalitas Landing Page:** Landing page berfungsi sebagai etalase digital (menu, lokasi, jam buka) untuk membangun kredibilitas, dan tidak mencakup fungsionalitas pemesanan online.

---

### 5. Metodologi Pengembangan Sistem

Proyek ini akan menerapkan metodologi **Agile** dengan adaptasi kerangka kerja **Scrum** untuk pengembang tunggal.

**a. Justifikasi Pemilihan Metode:**
Metodologi Agile dipilih karena fleksibilitasnya dalam mengakomodasi pemahaman yang berkembang tentang kebutuhan 'QIO Coffee'. Pendekatan iteratif Scrum memungkinkan pengembangan fitur POS dan Landing Page secara paralel dalam siklus pendek (Sprint), memastikan kemajuan yang terukur dan fokus pada pengiriman nilai bisnis (baik efisiensi maupun kredibilitas) secara berkala.

**b. Tahapan Pengembangan (Adaptasi Scrum Solo):**

| Tahap Siklus Sprint        | Deskripsi Aktivitas Utama                                                                                                                                                           | Luaran (Output)                                                              |
| :------------------------- | :---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | :--------------------------------------------------------------------------- |
| **1. Perencanaan (Planning)** | Mendefinisikan **Product Backlog** (semua fitur untuk POS & Landing Page). Memilih item prioritas untuk dikerjakan dalam satu **Sprint** (siklus kerja 1-2 minggu) menjadi **Sprint Backlog**. | Product Backlog, Sprint Backlog.                                             |
| **2. Desain & Analisis**   | Melakukan perancangan teknis untuk fitur dalam Sprint. Ini mencakup desain skema database (ERD) dan *wireframing* untuk UI kasir serta tata letak landing page. | Skema Database (ERD), Desain Antarmuka (UI/UX Mockup).                       |
| **3. Implementasi (Coding)** | Menulis kode program menggunakan TALL Stack untuk membangun komponen Livewire bagi POS dan *view* Blade untuk landing page.                                                          | Potongan Aplikasi yang Fungsional (*Increment*).                             |
| **4. Pengujian & Evaluasi**  | Melakukan **Pengujian Fungsional (Black Box)** pada fitur yang selesai. Di akhir Sprint, melakukan **Sprint Review** pribadi untuk mengevaluasi hasil dan menyesuaikan rencana selanjutnya. | Laporan Hasil Pengujian, Catatan Evaluasi Sprint.                            |

---

### 6. Arsitektur dan Fitur Unggulan

**a. Justifikasi Pemilihan TALL Stack:**
TALL Stack dipilih karena efisiensinya dalam membangun aplikasi web dinamis. Arsitektur ini memungkinkan satu developer untuk mengelola baik backend maupun frontend dari dua antarmuka yang berbeda (POS & Landing Page) secara efisien, yang sangat ideal untuk lingkup proyek tugas akhir.

**b. Fitur Fungsional Utama:**

1.  **Sistem POS Internal (Peningkatan Efisiensi):**
    -   **Modul Kasir:** Antarmuka untuk memproses transaksi penjualan dengan cepat.
    -   **Manajemen Produk (Menu):** Panel admin untuk mengelola menu (nama, harga).
2.  **Landing Page Publik (Peningkatan Kredibilitas):**
    -   **Profil Usaha Profesional:** Menampilkan informasi kunci QIO Coffee (lokasi, jam buka, kontak) dalam desain yang bersih dan modern.
    -   **Menu Digital yang Selalu Konsisten:** Fitur unggulan di mana daftar produk dan harga pada landing page diambil secara *real-time* dari database yang sama dengan sistem POS. Ketika staf mengubah harga di panel admin, harga di landing page ikut berubah secara otomatis. Hal ini **menghilangkan risiko inkonsistensi data** dan memastikan pelanggan selalu melihat informasi yang akurat, yang merupakan fondasi dari **kredibilitas digital**.

---

### 7. Kerangka Penulisan Jurnal Ilmiah

Struktur penulisan akan mengikuti standar publikasi ilmiah, dengan penekanan pada analisis studi kasus 'QIO Coffee' dan bagaimana sistem yang dibangun menjawab dua masalah utama (efisiensi internal dan kredibilitas eksternal) pada bab Hasil dan Pembahasan.