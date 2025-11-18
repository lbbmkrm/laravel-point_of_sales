# PROPOSAL PENELITIAN DAN PENGEMBANGAN SISTEM

---

## 1. Judul Penelitian

**IMPLEMENTASI TALL STACK UNTUK SISTEM POINT OF SALES TERINTEGRASI LANDING PAGE:  
ANALISIS EFISIENSI OPERASIONAL DAN EFISIENSI PENGEMBANGAN  
(Studi Kasus: QIA RONGKU COFFEE, MEDAN)**

---

## 2. Pendahuluan (Latar Belakang Masalah)

Di era digital, keberhasilan UMKM seperti kedai kopi tidak hanya bergantung pada kualitas produk, tetapi juga pada efisiensi operasional dan citra profesional. Di sisi lain, pengembang perangkat lunak, terutama yang bekerja dengan sumber daya terbatas (misalnya, pengembang tunggal atau tim kecil), juga menghadapi tantangan efisiensi pengembangan.

Studi kasus pada **QIA RONGKU COFFEE, Medan** merepresentasikan gabungan dari tantangan yang menjadi fokus analisis dalam penelitian ini:

1. **Tantangan Kredibilitas Digital (Masalah Bisnis):**  
   Ketergantungan pada media sosial untuk pembaruan menu memicu **inkonsistensi data**, merusak citra profesional usaha.

2. **Tantangan Efisiensi Operasional (Masalah Bisnis):**  
   Proses transaksi manual **terobservasi** menghambat kecepatan layanan dan meningkatkan risiko kesalahan pencatatan.

3. **Tantangan Efisiensi Pengembangan (Masalah Teknis):**  
   Pengembangan aplikasi modern sering menuntut pemeliharaan basis kode terpisah (API backend dan SPA frontend), meningkatkan kompleksitas dan _context switching_.

Penelitian ini mengusulkan **TALL Stack** sebagai arsitektur terpadu untuk membangun sebuah sistem POS terintegrasi landing page yang mampu mengatasi masalah-masalah tersebut.

---

## 3. Rumusan Masalah Penelitian

1. Bagaimana merancang dan mengimplementasikan aplikasi POS terintegrasi landing page menggunakan arsitektur TALL Stack?
2. Bagaimana pengaruh sistem terhadap **efisiensi operasional** dan **kredibilitas digital** di QIA RONGKU COFFEE?
3. Sejauh mana arsitektur TALL Stack berkontribusi pada **efisiensi pengembangan** dalam konteks solo developer?

---

## 4. Tujuan Penelitian

1. Mengimplementasikan sistem POS terintegrasi landing page berbasis TALL Stack.
2. Menganalisis peningkatan efisiensi operasional setelah menggunakan sistem.
3. Mengevaluasi efisiensi pengembangan menggunakan arsitektur TALL Stack.
4. Menyajikan bukti empiris mengenai konsistensi data menu sebagai indikator kredibilitas digital.

---

## 5. Manfaat Penelitian

### a. Manfaat Teoritis

- Menambah literatur terkait implementasi arsitektur TALL Stack dalam pengembangan sistem informasi.
- Memberikan pendekatan penelitian baru untuk mengukur _development efficiency_ dalam arsitektur terpadu.
- Menjadi referensi bagi peneliti sistem POS modern.

### b. Manfaat Praktis

- Membantu UMKM meningkatkan efisiensi operasional dan kredibilitas digital.
- Menyediakan panduan bagi pengembang tunggal atau tim kecil untuk mengurangi kompleksitas pengembangan.
- Memberikan bukti valid terkait perbandingan alur kerja tradisional vs TALL Stack.

---

## 6. Ruang Lingkup dan Batasan Penelitian

1. **Studi Kasus:** Fokus pada alur kerja dan kebutuhan nyata QIA RONGKU COFFEE, Medan.
2. **Platform:** Aplikasi berbasis web; tidak mencakup aplikasi mobile native.
3. **Teknologi:** Menggunakan TALL Stack (TailwindCSS, Alpine.js, Laravel, Livewire).
4. **Fitur Inti:** Modul Transaksi, Manajemen Produk, Laporan Penjualan dasar, dan Landing Page Publik.
5. **Landing Page:** Tidak mencakup fitur pemesanan online.

---

## 7. Tinjauan Pustaka

### 7.1. Sistem Point of Sales UMKM

Penelitian menunjukkan sistem POS mampu meningkatkan kecepatan dan akurasi transaksi (Rahmawati, 2021; Nugroho, 2020).

### 7.2. Landing Page dan Kredibilitas Digital

Konsistensi informasi digital memiliki pengaruh langsung terhadap persepsi profesionalisme (Kotler & Keller, 2020).

### 7.3. Arsitektur Terpadu (Server-Driven UI)

Laravel Livewire dan arsitektur sejenis mempercepat pengembangan dengan mengurangi _context switching_ (Otwell, 2020; Toland, 2021).

### 7.4. TALL Stack

Literatur tentang TALL Stack masih jarang, khususnya dalam konteks UMKM atau pengukuran kuantitatif.

---

## 8. State of The Art dan Gap Research

### 8.1. State of The Art

| Bidang Penelitian     | Fokus                | Temuan                                         | Keterbatasan                                        |
| --------------------- | -------------------- | ---------------------------------------------- | --------------------------------------------------- |
| POS UMKM              | Efisiensi transaksi  | Mengurangi human error                         | Tidak terintegrasi dengan landing page              |
| Landing Page UMKM     | Kredibilitas digital | Konsistensi informasi meningkatkan kepercayaan | Tidak terhubung data real-time                      |
| Laravel + Livewire    | Efisiensi CRUD       | Mempercepat prototyping                        | Tidak diuji dalam konteks POS nyata                 |
| Fullstack tradisional | SPA + API            | Modern, modular                                | Kompleks & berat untuk solo developer               |
| Studi TALL Stack      | Tutorial teknis      | CRUD cepat                                     | Minim penelitian ilmiah, tanpa evaluasi kuantitatif |

---

### 8.2. Gap Research (Celah Penelitian)

**Gap 1:**  
Belum ada penelitian yang mengimplementasikan **sistem POS terintegrasi landing page** dengan _data real-time_ dari satu sumber yang sama.

**Gap 2:**  
Tidak ada penelitian yang mengukur **efisiensi pengembangan** TALL Stack secara kuantitatif dari sisi _context switching_, jumlah file, dan waktu pengembangan.

**Gap 3:**  
Belum ada penelitian TALL Stack yang memadukan **analisis operasional (waktu transaksi)** dan **analisis teknis (efisiensi pengembangan)** secara simultan.

**Kontribusi penelitian ini:**  
Mengisi tiga celah tersebut dengan pendekatan implementatif + analisis kuantitatif.

---

## 9. Metodologi Penelitian dan Pengembangan

### 9.1. Metodologi Pengembangan (Agile Scrum Adaptif)

| Tahap                | Deskripsi                                   | Output          |
| -------------------- | ------------------------------------------- | --------------- |
| Planning             | Menentukan product backlog & sprint backlog | Backlog         |
| Desain & Analisis    | ERD, UI/UX, workflow                        | Mockup & ERD    |
| Implementasi         | Pengembangan komponen TALL Stack            | Increment       |
| Pengujian & Evaluasi | Testing fungsional, validasi efisiensi      | Laporan         |
| Deployment           | Implementasi internal                       | Sistem berjalan |

---

### 9.2. Metodologi Penelitian (Mixed Method)

| Rumusan Masalah        | Metode                               | Metrik                              |
| ---------------------- | ------------------------------------ | ----------------------------------- |
| Efisiensi Operasional  | Stopwatch transaksi manual vs sistem | Rata-rata waktu (detik), error rate |
| Kredibilitas Digital   | Audit cross-data                     | Tingkat konsistensi data            |
| Efisiensi Pengembangan | Pencatatan alur kerja developer      | Waktu CRUD, file, context switching |

---

## 10. Jadwal Penelitian (Gantt Chart)

| Kegiatan           | M1-2 | M3-4 | M5-6 | M7-8 | M9-10 | M11 |
| ------------------ | ---- | ---- | ---- | ---- | ----- | --- |
| Studi Literatur    | ✔️   |      |      |      |       |     |
| Desain Sistem      | ✔️   | ✔️   |      |      |       |     |
| Implementasi       |      | ✔️   | ✔️   |      |       |     |
| Pengujian          |      |      | ✔️   | ✔️   |       |     |
| Analisis Hasil     |      |      |      | ✔️   | ✔️    |     |
| Penulisan Proposal |      |      |      |      | ✔️    | ✔️  |

---

## 11. Daftar Pustaka

_(Placeholder – dapat Anda ganti dengan jurnal resmi)_

- Kotler, P., & Keller, K. (2020). _Marketing Management_.
- Otwell, T. (2020). Laravel & Livewire Documentation.
- Nugroho, A. (2020). Analisis Efektivitas POS UMKM.
- Rahmawati, S. (2021). Pengaruh POS terhadap Proses Bisnis UMKM.
- Arifianto, D. (2022). Kredibilitas Digital UMKM di Era Modern.
- Toland, C. (2021). Server-Driven UI Approaches in Web Development.

---
