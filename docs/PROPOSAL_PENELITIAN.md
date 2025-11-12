# PROPOSAL PENELITIAN DAN PENGEMBANGAN SISTEM

---

### 1. Judul Penelitian yang Diajukan

**IMPLEMENTASI TALL STACK UNTUK SISTEM POINT OF SALES TERINTEGRASI LANDING PAGE: ANALISIS EFISIENSI OPERASIONAL DAN EFISIENSI PENGEMBANGAN (Studi Kasus: QIA RONGKU COFFEE, MEDAN)**

---

### 2. Pendahuluan (Latar Belakang Masalah)

Di era digital, keberhasilan UMKM seperti kedai kopi tidak hanya bergantung pada kualitas produk, tetapi juga pada efisiensi operasional dan citra profesional. Di sisi lain, pengembang perangkat lunak, terutama yang bekerja dengan sumber daya terbatas (misalnya, pengembang tunggal atau tim kecil), juga menghadapi tantangan efisiensi pengembangan.

Studi kasus pada **QIA RONGKU COFFEE, Medan** (sebuah entitas nyata), merepresentasikan gabungan dari tantangan-tantangan yang akan menjadi fokus analisis kuantitatif dalam penelitian ini:

1.  **Tantangan Kredibilitas Digital (Masalah Bisnis):** Kehadiran online yang profesional adalah kunci. Ketergantungan pada media sosial untuk pembaruan menu sering menimbulkan **inkonsistensi data** yang terobservasi, merusak citra profesional usaha dan menjadi metrik _baseline_ yang akan diukur.
2.  **Tantangan Efisiensi Operasional (Masalah Bisnis):** Proses transaksi manual **terobservasi** menghambat kecepatan layanan dan memiliki risiko tinggi terhadap kesalahan pencatatan. Penelitian ini akan mengukur waktu rata-rata pemrosesan transaksi manual sebagai _baseline_ operasional.
3.  **Tantangan Efisiensi Pengembangan (Masalah Teknis):** Kebutuhan untuk membangun aplikasi web yang modern dan reaktif seringkali menuntut pengembang untuk mengelola basis kode terpisah (API _backend_ dan SPA _frontend_), yang memperlambat proses pengembangan dan meningkatkan kompleksitas. Penelitian ini berhipotesis TALL Stack dapat memitigasi masalah _context switching_ ini.

Untuk menjawab ketiga tantangan tersebut, penelitian ini mengusulkan **implementasi arsitektur TALL Stack** untuk membangun sebuah sistem terpadu yang tidak hanya menyelesaikan masalah bisnis UMKM melalui data _real-time_, tetapi juga membuktikan efektivitas pendekatan pengembangan yang lebih ramping dan efisien.

---

### 3. Rumusan Masalah Penelitian

Penelitian ini akan menjawab pertanyaan-pertanyaan berikut dengan basis data empiris:

1.  Bagaimana merancang dan mengimplementasikan sebuah aplikasi POS terintegrasi _landing page_ yang fungsional menggunakan arsitektur TALL Stack?
2.  Bagaimana **pengaruh** sistem yang dibangun terhadap **peningkatan efisiensi operasional** (diukur dari reduksi waktu transaksi) dan **kredibilitas digital** (diukur dari tingkat konsistensi data menu) di QIA RONGKU COFFEE?
3.  Melalui analisis komparatif alur kerja, sejauh mana **arsitektur TALL Stack** berkontribusi pada **efisiensi proses pengembangan** dan kemudahan pemeliharaan sistem dalam konteks _solo developer_ dibandingkan pendekatan _stack_ terpisah?

---

### 4. Ruang Lingkup dan Batasan Proyek

Untuk menjaga fokus penelitian, proyek ini dibatasi pada aspek-aspek berikut:

1.  **Studi Kasus:** Sistem dirancang berdasarkan alur kerja **NYATA** dan kebutuhan yang diobservasi pada **QIA RONGKU COFFEE, Medan**. Pengambilan data _baseline_ (manual) dan data evaluasi (sistem baru) akan dilakukan di lokasi ini.
2.  **Platform:** Sistem dikembangkan sebagai Aplikasi Berbasis Web. Tidak ada pengembangan aplikasi _native mobile_.
3.  **Teknologi:** Penelitian ini secara spesifik menganalisis dan mengimplementasikan **TALL Stack** (Tailwind CSS, Alpine.js, Laravel, Livewire) sebagai arsitektur utama.
4.  **Fitur Inti:** Pengembangan difokuskan pada **Modul Transaksi (Kasir), Manajemen Produk (Menu), Laporan Penjualan Dasar, dan sebuah Landing Page Publik** untuk profil dan menu usaha.
5.  **Fungsionalitas Landing Page:** _Landing page_ berfungsi sebagai etalase digital dan **tidak mencakup fungsionalitas pemesanan _online_**.

---

### 5. Metodologi Penelitian dan Pengembangan

Proyek ini menggunakan kombinasi metodologi pengembangan sistem (_Agile_) dan metodologi penelitian ilmiah (_Mixed Method_).

**a. Metodologi Pengembangan Sistem (Agile Scrum Adaptif):**
Metodologi Agile dipilih karena fleksibilitasnya. Pendekatan iteratif memungkinkan pengembangan fitur secara berkala, memastikan kemajuan yang terukur. Kerangka kerja Scrum diadaptasi untuk pengembang tunggal.

| Tahap Siklus Sprint           | Deskripsi Aktivitas Utama                                                                                                                 | Luaran (Output)                                        |
| :---------------------------- | :---------------------------------------------------------------------------------------------------------------------------------------- | :----------------------------------------------------- |
| **1. Perencanaan (Planning)** | Mendefinisikan **Product Backlog**. Memilih item prioritas untuk dikerjakan dalam satu **Sprint** menjadi **Sprint Backlog**.             | Product Backlog, Sprint Backlog.                       |
| **2. Desain & Analisis**      | Melakukan perancangan teknis, termasuk skema database (ERD) dan _wireframing_ UI/UX.                                                      | Skema Database (ERD), Desain Antarmuka (UI/UX Mockup). |
| **3. Implementasi (Coding)**  | Menulis kode menggunakan **TALL Stack** untuk membangun komponen Livewire dan fitur-fitur lainnya.                                        | Potongan Aplikasi yang Fungsional (_Increment_).       |
| **4. Pengujian & Evaluasi**   | Melakukan pengujian fungsional dan mengevaluasi hasil sprint, termasuk analisis terhadap efektivitas TALL Stack dalam implementasi fitur. | Laporan Hasil Pengujian, Catatan Evaluasi Sprint.      |

**b. Metodologi Penelitian dan Evaluasi (Mixed Method):**

Untuk menjawab Rumusan Masalah #2 dan #3, penelitian ini menggunakan pendekatan **kuantitatif** dan **kualitatif** sebagai berikut:

| Rumusan Masalah                 | Metode Pengumpulan Data                                                                                                                       | Metrik Kunci yang Diukur                                                                          |
| :------------------------------ | :-------------------------------------------------------------------------------------------------------------------------------------------- | :------------------------------------------------------------------------------------------------ |
| **Efisiensi Operasional (R2)**  | **Observasi Terstruktur:** Pengukuran _real-time_ menggunakan _stopwatch_ pada alur kerja manual (_baseline_) dan alur kerja sistem TALL POS. | **Reduksi Waktu Transaksi Rata-rata** (Detik), Tingkat Akurasi Pencatatan (Error Rate).           |
| **Kredibilitas Digital (R2)**   | **Audit Data _Baseline_**: Analisis perbandingan antara menu POS dan _landing page_ terintegrasi.                                             | **Tingkat Konsistensi Data Menu** ($0\%$ inkonsisten).                                            |
| **Efisiensi Pengembangan (R3)** | **Analisis Komparatif Alur Kerja dan _Self-Documentation_**: Pencatatan waktu dan alur kerja yang dihabiskan untuk pengembangan fitur kunci.  | **Reduksi _Context Switching_**, Waktu Pengembangan Fitur (CRUD), dan Analisis Kompleksitas Kode. |

**c. Justifikasi Pemilihan Arsitektur TALL Stack:**
Pemilihan TALL Stack merupakan inti hipotesis teknis. Arsitektur ini dipilih sebagai solusi potensial untuk **tantangan efisiensi pengembangan** dengan argumen sebagai berikut:

- **Pendekatan Terpadu (Unified Approach):** Memungkinkan pengembangan antarmuka reaktif tanpa _separated codebase_. Ini secara langsung mengurangi beban kognitif dan _context switching_ antar bahasa/framework (PHP dan JS) yang akan dianalisis dalam penelitian ini.
- **Kecepatan Pengembangan (Rapid Development):** Komponen Livewire memungkinkan logika _frontend_ dan _backend_ berada di dalam satu kelas PHP, mempercepat proses pembuatan fitur CRUD dan interaksi pengguna lainnya.

---

### 6. Arsitektur dan Fitur Unggulan

**a. Arsitektur Sistem Berbasis TALL Stack:**
Arsitektur ini menghilangkan lapisan API perantara, sehingga menyederhanakan alur kerja _developer_. Komponen Livewire menangani _rendering_ sisi server dan pembaruan DOM cerdas di sisi klien, sementara Alpine.js digunakan untuk interaktivitas kecil _client-side_.

**b. Fitur Fungsional Utama (Sebagai Bukti Konsep):**

1.  **Sistem POS Internal (Solusi Efisiensi Operasional):**
    - **Manajemen Produk & Modul Kasir:** Dikembangkan dengan komponen Livewire untuk menunjukkan kecepatan pengembangan dan pengalaman pengguna yang reaktif (sebagai data kuantitatif efisiensi).
2.  **Landing Page Publik (Solusi Kredibilitas Digital):**
    - **Menu Digital yang Selalu Konsisten:** Fitur unggulan di mana data menu diambil secara _real-time_ dari _database_ yang sama dengan sistem POS. Fitur ini menjadi bukti solusi masalah inkonsistensi data.

---
