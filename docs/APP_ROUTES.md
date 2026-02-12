# Daftar Rute Aplikasi (Endpoints) - Sistem POS QIO Coffee

Dokumen ini menjelaskan rute-rute utama aplikasi QIO Coffee. Aplikasi ini menggunakan **TALL Stack** (Tailwind, Alpine.js, Laravel, Livewire) dengan konsep **Volt** (Single File Livewire Components).

---

## 1. Rute Publik (Guest)

Rute yang dapat diakses tanpa login.

| Method | URI      | Component / Name         | Keterangan                                                    |
| :----- | :------- | :----------------------- | :------------------------------------------------------------ |
| `GET`  | `/`      | `landing.index` (`home`) | Halaman Landing Page (Hero, About, Menu, Gallery, Testimoni). |
| `GET`  | `/login` | `auth.login` (`login`)   | Halaman Login.                                                |

---

## 2. Rute Aplikasi Internal (Perlu Login)

Semua rute di bawah ini dilindungi oleh middleware `auth`.

### a. Dashboard & Kasir

| Method | URI          | Component / Name                 | Keterangan                                              |
| :----- | :----------- | :------------------------------- | :------------------------------------------------------ |
| `GET`  | `/dashboard` | `dashboard.home` (`dashboard`)   | Overview statistik ringkas (hanya untuk staff/owner).   |
| `GET`  | `/cashier`   | `dashboard.cashier` (`cashier`)  | Antarmuka transaksi penjualan (POS).                    |
| `GET`  | `/history`   | `dashboard.history` (`history`)  | Daftar riwayat transaksi dan detail struk.              |
| `GET`  | `/products`  | `dashboard.product` (`products`) | Manajemen daftar produk/menu (diatur oleh Gate/Policy). |

---

### b. Rute Khusus Owner (Middleware `role:owner`)

Rute yang hanya dapat diakses oleh pengguna dengan peran `owner`.

| Method | URI             | Component / Name                         | Keterangan                                         |
| :----- | :-------------- | :--------------------------------------- | :------------------------------------------------- |
| `GET`  | `/reports`      | `dashboard.report` (`reports`)           | Laporan pendapatan mendalam dan grafik penjualan.  |
| `GET`  | `/users`        | `dashboard.user` (`users`)               | Manajemen pengguna (Staff/Kasir).                  |
| `GET`  | `/testimonials` | `dashboard.testimonial` (`testimonials`) | Pengelolaan testimoni yang muncul di landing page. |
| `GET`  | `/galleries`    | `dashboard.gallery` (`galleries`)        | Manajemen foto galeri untuk landing page.          |
| `GET`  | `/settings`     | `dashboard.settings` (`settings`)        | Pengaturan aplikasi dan sistem.                    |

---

### Ringkasan Middleware & Keamanan:

- **`auth`**: Memastikan pengguna sudah login.
- **`guest`**: Mencegah pengguna yang sudah login mengakses halaman login.
- **`role:owner`**: Membatasi akses menu administratif hanya untuk pemilik.
- **Laravel Gates/Policies**: Digunakan di dalam komponen (misal pada `dashboard.product`) untuk kontrol akses yang lebih granular pada aksi CRUD.
- **Global Timezone**: Aplikasi dikonfigurasi menggunakan `Asia/Jakarta` (WIB).
- **Locale**: Menggunakan `id` (Bahasa Indonesia) untuk format tanggal dan angka.
