# Daftar Rute Aplikasi (Endpoints) - Sistem POS QIO Coffee

Dokumen ini menjelaskan rute-rute utama aplikasi. Karena menggunakan TALL Stack, sebagian besar interaksi dinamis tidak diekspos sebagai endpoint API publik, melainkan sebagai aksi di dalam komponen Livewire yang dipanggil dari halaman utama.

---

## 1. Rute Publik (Guest)

Rute ini dapat diakses oleh siapa saja tanpa perlu login.

| Method | URI         | Controller / View            | Keterangan                                       |
| :----- | :---------- | :--------------------------- | :----------------------------------------------- |
| `GET`  | `/`         | `LandingPageController@index`  | Menampilkan halaman utama/landing page QIO Coffee. |

---

## 2. Rute Autentikasi

Rute ini digunakan untuk proses login dan logout. Biasanya ditangani oleh package seperti Laravel Breeze/Jetstream.

| Method | URI         | Controller / View            | Keterangan                                       |
| :----- | :---------- | :--------------------------- | :----------------------------------------------- |
| `GET`  | `/login`    | `LoginController@show`       | Menampilkan halaman login.                       |
| `POST` | `/login`    | `LoginController@store`      | Memproses permintaan login dari pengguna.        |
| `POST` | `/logout`   | `LoginController@destroy`    | Memproses permintaan logout.                     |

---

## 3. Rute Aplikasi Internal (Perlu Login)

Rute ini hanya bisa diakses setelah pengguna login dan dilindungi oleh *middleware* `auth`.

### a. Halaman Utama / Kasir

| Method | URI         | Livewire Component Muatan    | Keterangan                                       |
| :----- | :---------- | :--------------------------- | :----------------------------------------------- |
| `GET`  | `/dashboard`| `CashierInterface`           | Halaman utama setelah login, antarmuka kasir.    |

**Aksi di dalam Komponen `CashierInterface`:**
- `addToCart($productId)`: Menambahkan produk ke keranjang.
- `removeItem($cartItemId)`: Menghapus item dari keranjang.
- `clearCart()`: Mengosongkan keranjang.
- `submitTransaction()`: Menyimpan transaksi ke database.

### b. Halaman Manajemen Produk

| Method | URI         | Livewire Component Muatan    | Keterangan                                       |
| :----- | :---------- | :--------------------------- | :----------------------------------------------- |
| `GET`  | `/products` | `ProductManagement`          | Halaman untuk mengelola (CRUD) semua produk.     |

**Aksi di dalam Komponen `ProductManagement`:**
- `create()`: Menampilkan modal/form untuk menambah produk baru.
- `store()`: Menyimpan produk baru ke database.
- `edit($productId)`: Menampilkan modal/form untuk mengedit produk.
- `update($productId)`: Memperbarui data produk di database.
- `delete($productId)`: Menghapus produk dari database.

### c. Halaman Laporan

| Method | URI         | Livewire Component Muatan    | Keterangan                                       |
| :----- | :---------- | :--------------------------- | :----------------------------------------------- |
| `GET`  | `/reports`  | `ReportDashboard`            | Halaman untuk melihat laporan penjualan.         |

**Aksi di dalam Komponen `ReportDashboard`:**
- `filterByDate($startDate, $endDate)`: Memfilter laporan berdasarkan rentang tanggal.

---

### Ringkasan Middleware:

-   **`web`**: Berlaku untuk semua rute.
-   **`guest`**: Berlaku untuk rute `/login` (hanya bisa diakses jika belum login).
-   **`auth`**: Berlaku untuk semua rute aplikasi internal (`/dashboard`, `/products`, `/reports`) untuk memastikan hanya pengguna terautentikasi yang bisa mengakses.
-   **`role:owner` (Opsional)**: Middleware kustom bisa dibuat untuk membatasi akses halaman `/products` dan `/reports` hanya untuk pengguna dengan peran `owner`.
