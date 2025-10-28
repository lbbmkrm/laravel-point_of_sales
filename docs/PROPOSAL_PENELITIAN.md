# BLUEPRINT PENELITIAN DAN PENGEMBANGAN SISTEM

---

### 1. Judul Penelitian yang Diajukan

**IMPLEMENTASI TALL STACK PADA PENGEMBANGAN APLIKASI POINT OF SALES TERINTEGRASI LANDING PAGE GUNA MENINGKATKAN EFISIENSI OPERASIONAL DAN KREDIBILITAS DIGITAL (Studi Kasus: QIA RONGKU COFFEE, MEDAN)**

---

### 2. Pendahuluan (Latar Belakang Masalah)

Di era digital, keberhasilan UMKM seperti kedai kopi tidak hanya bergantung pada kualitas produk, tetapi juga pada efisiensi operasional dan citra profesional. Di sisi lain, pengembang perangkat lunak, terutama yang bekerja dengan sumber daya terbatas (misalnya, pengembang tunggal atau tim kecil), juga menghadapi tantangan efisiensi pengembangan. Studi kasus pada **QIA Coffee**, sebuah kedai kopi fiktif di **Medan**, merepresentasikan gabungan dari tantangan-tantangan ini:

1.  **Tantangan Kredibilitas Digital (Masalah Bisnis):** Kehadiran online yang profesional adalah kunci untuk membangun kepercayaan. Ketergantungan pada media sosial untuk pembaruan menu sering menimbulkan **inkonsistensi data**, yang merusak citra profesional usaha.
2.  **Tantangan Efisiensi Operasional (Masalah Bisnis):** Proses transaksi manual menghambat kecepatan layanan dan berisiko tinggi terhadap kesalahan pencatatan, yang dapat menyebabkan kerugian finansial.
3.  **Tantangan Efisiensi Pengembangan (Masalah Teknis):** Kebutuhan untuk membangun aplikasi web yang modern dan reaktif seringkali menuntut pengembang untuk mengelola dua basis kode yang terpisah (API backend dan SPA frontend), yang dapat memperlambat proses pengembangan dan meningkatkan kompleksitas.

Untuk menjawab ketiga tantangan tersebut, penelitian ini mengusulkan **implementasi arsitektur TALL Stack** untuk membangun sebuah sistem terpadu yang tidak hanya menyelesaikan masalah bisnis UMKM, tetapi juga membuktikan efektivitas pendekatan pengembangan yang lebih ramping dan efisien.

---

### 3. Rumusan Masalah Penelitian

Penelitian ini akan menjawab pertanyaan-pertanyaan berikut:

1.  Bagaimana merancang dan membangun sebuah aplikasi POS terintegrasi landing page yang fungsional menggunakan arsitektur TALL Stack?
2.  Sejauh mana sistem yang dibangun dapat membantu meningkatkan **efisiensi operasional** melalui modul kasir dan **kredibilitas digital** melalui landing page yang tersinkronisasi?
3.  Sejauh mana **arsitektur TALL Stack** berkontribusi pada **efisiensi proses pengembangan** dan kemudahan pemeliharaan sistem dalam konteks pengembangan solo pada studi kasus ini?

---

### 4. Ruang Lingkup dan Batasan Proyek

Untuk menjaga fokus penelitian, proyek ini dibatasi pada aspek-aspek berikut:

1.  **Studi Kasus:** Sistem dirancang berdasarkan alur kerja dan kebutuhan yang disimulasikan untuk **QIA Coffee, Medan**.
2.  **Platform:** Sistem dikembangkan sebagai Aplikasi Berbasis Web. Tidak ada pengembangan aplikasi _native mobile_.
3.  **Teknologi:** Penelitian ini secara spesifik menganalisis dan mengimplementasikan **TALL Stack** (Tailwind CSS, Alpine.js, Laravel, Livewire) sebagai arsitektur utama.
4.  **Fitur Inti:** Pengembangan difokuskan pada **Modul Transaksi (Kasir), Manajemen Produk (Menu), Laporan Penjualan Dasar, dan sebuah Landing Page Publik** untuk profil dan menu usaha.
5.  **Fungsionalitas Landing Page:** Landing page berfungsi sebagai etalase digital dan tidak mencakup fungsionalitas pemesanan online.

---

### 5. Metodologi Pengembangan Sistem

Proyek ini menerapkan metodologi **Agile** dengan kerangka kerja **Scrum** yang diadaptasi untuk pengembang tunggal.

**a. Justifikasi Pemilihan Metode Agile:**
Metodologi Agile dipilih karena fleksibilitasnya. Pendekatan iteratif memungkinkan pengembangan fitur secara berkala, memastikan kemajuan yang terukur dan fokus pada pengiriman nilai (baik nilai bisnis untuk UMKM maupun nilai teknis dari evaluasi _stack_).

**b. Justifikasi Pemilihan Arsitektur TALL Stack:**
Pemilihan TALL Stack merupakan bagian inti dari hipotesis penelitian ini. Arsitektur ini dipilih sebagai solusi potensial untuk **tantangan efisiensi pengembangan** dengan argumen sebagai berikut:

-   **Pendekatan Terpadu (Unified Approach):** Memungkinkan pengembangan antarmuka yang sangat dinamis dan reaktif (seperti SPA) tanpa harus meninggalkan ekosistem Laravel. Ini mengurangi beban kognitif dan _context switching_ antara bahasa dan _framework_ yang berbeda.
-   **Kecepatan Pengembangan (Rapid Development):** Komponen Livewire memungkinkan logika frontend dan backend berada di dalam satu kelas PHP, yang secara signifikan mempercepat proses pembuatan fitur CRUD dan interaksi pengguna lainnya.
-   **Teknologi Tepat Guna (Appropriate Technology):** Untuk lingkup proyek UMKM yang dikerjakan oleh tim kecil atau solo developer, pendekatan "monolitik modern" ini menawarkan keseimbangan ideal antara kekuatan, kecepatan pengembangan, dan kemudahan pemeliharaan.

**c. Tahapan Pengembangan (Adaptasi Scrum Solo):**
_Tabel tahapan pengembangan dipertahankan seperti sebelumnya._

| Tahap Siklus Sprint           | Deskripsi Aktivitas Utama                                                                                                                 | Luaran (Output)                                        |
| :---------------------------- | :---------------------------------------------------------------------------------------------------------------------------------------- | :----------------------------------------------------- |
| **1. Perencanaan (Planning)** | Mendefinisikan **Product Backlog**. Memilih item prioritas untuk dikerjakan dalam satu **Sprint** menjadi **Sprint Backlog**.             | Product Backlog, Sprint Backlog.                       |
| **2. Desain & Analisis**      | Melakukan perancangan teknis, termasuk skema database (ERD) dan _wireframing_ UI/UX.                                                      | Skema Database (ERD), Desain Antarmuka (UI/UX Mockup). |
| **3. Implementasi (Coding)**  | Menulis kode menggunakan **TALL Stack** untuk membangun komponen Livewire dan fitur-fitur lainnya.                                        | Potongan Aplikasi yang Fungsional (_Increment_).       |
| **4. Pengujian & Evaluasi**   | Melakukan pengujian fungsional dan mengevaluasi hasil sprint, termasuk analisis terhadap efektivitas TALL Stack dalam implementasi fitur. | Laporan Hasil Pengujian, Catatan Evaluasi Sprint.      |

---

### 6. Arsitektur dan Fitur Unggulan

**a. Arsitektur Sistem Berbasis TALL Stack:**
Arsitektur TALL Stack memungkinkan pendekatan pengembangan yang sangat efisien. Komponen Livewire, yang ditulis dalam PHP, secara langsung me-render _view_ Blade di server dan secara cerdas memperbarui DOM di sisi klien sesuai interaksi pengguna. Hal ini menghilangkan kebutuhan akan lapisan API perantara, yang secara signifikan menyederhanakan alur kerja. Alpine.js kemudian digunakan untuk interaktivitas kecil di sisi klien yang tidak memerlukan komunikasi dengan server.

**b. Fitur Fungsional Utama (Sebagai Bukti Konsep):**

1.  **Sistem POS Internal (Solusi Efisiensi Operasional):**
    -   **Manajemen Produk & Modul Kasir:** Dikembangkan dengan komponen Livewire untuk menunjukkan kecepatan pengembangan dan pengalaman pengguna yang reaktif.
2.  **Landing Page Publik (Solusi Kredibilitas Digital):**
    -   **Menu Digital yang Selalu Konsisten:** Fitur unggulan di mana data diambil secara _real-time_ dari database yang sama dengan sistem POS. Ini secara langsung menunjukkan bagaimana arsitektur terpadu dapat menyelesaikan masalah inkonsistensi data.

---

### 7. Kerangka Penulisan Jurnal Ilmiah

Struktur penulisan akan mengikuti standar publikasi ilmiah, dengan penekanan pada bab Hasil dan Pembahasan yang akan menganalisis tiga hal: (1) sejauh mana sistem menjawab masalah efisiensi operasional, (2) sejauh mana ia menjawab masalah kredibilitas digital, dan (3) analisis efektivitas penggunaan arsitektur TALL Stack dalam proses pengembangan sistem tersebut.
