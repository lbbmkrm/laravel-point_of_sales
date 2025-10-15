# Rencana dan Jadwal Proyek: Sistem POS QIO Coffee

Dokumen ini menguraikan rencana jadwal pengembangan proyek dalam format Sprint. Setiap Sprint direncanakan memiliki durasi 2 minggu. Jadwal ini bersifat estimasi dan dapat disesuaikan selama proses pengembangan sesuai dengan prinsip Agile.

**Total Estimasi Waktu Pengembangan Inti: 8 Minggu**

---

## Tabel Jadwal Proyek

| Sprint      | Durasi   | Target Fitur Utama                                                                                                | Luaran (Output)                                                                 |
| :---------- | :------- | :---------------------------------------------------------------------------------------------------------------- | :------------------------------------------------------------------------------ |
| **Sprint 1**  | 2 Minggu | **Fondasi & Manajemen Produk:**<br>- Setup proyek Laravel & Database.<br>- Implementasi Autentikasi (Login).<br>- CRUD untuk Manajemen Produk (Tambah, Lihat, Ubah, Hapus). | Proyek TALL Stack fungsional, Pengguna bisa login, Menu produk bisa dikelola.     |
| **Sprint 2**  | 2 Minggu | **Modul Transaksi (Kasir):**<br>- Antarmuka kasir untuk memilih produk.<br>- Logika keranjang belanja (cart).<br>- Proses checkout & pencatatan transaksi.          | Kasir dapat melakukan dan mencatat transaksi penjualan.                         |
| **Sprint 3**  | 2 Minggu | **Integrasi Inventori & Landing Page:**<br>- Stok produk berkurang otomatis saat checkout.<br>- Pembuatan Landing Page (View & Route).<br>- Menampilkan data produk dari DB ke Landing Page. | Stok inventori akurat, Landing page fungsional dengan menu yang tersinkronisasi. |
| **Sprint 4**  | 2 Minggu | **Laporan & Finalisasi:**<br>- Membuat halaman laporan penjualan harian.<br>- Finalisasi UI/UX.<br>- Pengujian menyeluruh (end-to-end testing).                 | Laporan dasar dapat diakses, Sistem stabil dan siap untuk UAT.                  |
| **Sprint 5+** | Fleksibel  | **Pengembangan Tambahan & Buffer:**<br>- Pengerjaan fitur prioritas rendah (jika ada waktu).<br>- Perbaikan bug dari hasil pengujian.<br>- Persiapan laporan akhir. | Perbaikan bug, Fitur tambahan (jika ada), Penulisan laporan.                    |

---

### Catatan:

-   **Sprint 0 (Tidak Tertulis):** Dianggap sudah selesai, mencakup aktivitas seperti analisis kebutuhan awal, pembuatan proposal, dan perencanaan awal ini.
-   **Pengujian:** Meskipun Sprint 4 memiliki fokus pada pengujian, pengujian unit (unit testing) idealnya dilakukan di setiap Sprint untuk fitur yang sedang dikembangkan.
-   **Dokumentasi:** Penulisan laporan tugas akhir dilakukan secara paralel di setiap akhir Sprint, mendokumentasikan apa yang telah selesai dikerjakan.
