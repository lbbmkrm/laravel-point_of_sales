# Desain Database - Sistem POS QIO Coffee

Dokumen ini menjelaskan rancangan struktur database untuk aplikasi POS QIO Coffee. Rancangan ini mencakup tabel, kolom, dan relasi antar tabel yang dibutuhkan untuk memenuhi kebutuhan fungsional sistem.

---

## Deskripsi Entitas (Tabel)

Database ini akan terdiri dari 5 tabel utama: `users`, `categories`, `products`, `transactions`, dan `transaction_details`.

### 1. Tabel: `users`

Menyimpan data pengguna yang dapat login ke sistem, yaitu Pemilik dan Kasir.

| Nama Kolom  | Tipe Data      | Keterangan                                      |
| :---------- | :------------- | :---------------------------------------------- |
| `id`        | `BIGINT`, `PK` | Primary Key, Auto-Increment.                    |
| `name`      | `VARCHAR(255)` | Nama lengkap pengguna.                          |
| `username`  | `VARCHAR(255)` | Username untuk login, harus unik.               |
| `phone`     | `VARCHAR(20)`  | Nomor telepon pengguna (opsional).              |
| `password`  | `VARCHAR(255)` | Password yang sudah di-hash.                    |
| `role`      | `ENUM`         | Hak akses pengguna: `'owner'`, `'cashier'`.     |
| `created_at`| `TIMESTAMP`    | Waktu pembuatan record.                         |
| `updated_at`| `TIMESTAMP`    | Waktu pembaruan record.                         |

### 2. Tabel: `categories`

Menyimpan data kategori produk untuk pengelompokan menu.

| Nama Kolom  | Tipe Data      | Keterangan                                      |
| :---------- | :------------- | :---------------------------------------------- |
| `id`        | `BIGINT`, `PK` | Primary Key, Auto-Increment.                    |
| `name`      | `VARCHAR(255)` | Nama kategori (misal: 'Coffee', 'Non-Coffee').  |
| `created_at`| `TIMESTAMP`    | Waktu pembuatan record.                         |
| `updated_at`| `TIMESTAMP`    | Waktu pembaruan record.                         |


### 3. Tabel: `products`

Menyimpan semua data produk atau item menu yang dijual.

| Nama Kolom    | Tipe Data        | Keterangan                                      |
| :------------ | :--------------- | :---------------------------------------------- |
| `id`          | `BIGINT`, `PK`   | Primary Key, Auto-Increment.                    |
| `category_id` | `BIGINT`, `FK`   | Foreign Key ke `categories.id`.                 |
| `name`        | `VARCHAR(255)`   | Nama produk (misal: "Espresso", "Latte").     |
| `description` | `TEXT`           | Deskripsi singkat produk (opsional).            |
| `price`       | `DECIMAL(10, 2)` | Harga jual produk.                              |
| `image_url`   | `VARCHAR(255)`   | URL gambar produk untuk ditampilkan di landing page (opsional). |
| `created_at`  | `TIMESTAMP`      | Waktu pembuatan record.                         |
| `updated_at`  | `TIMESTAMP`      | Waktu pembaruan record.                         |


### 4. Tabel: `transactions`

Menyimpan data setiap transaksi penjualan yang terjadi.

| Nama Kolom     | Tipe Data        | Keterangan                                      |
| :------------- | :--------------- | :---------------------------------------------- |
| `id`           | `BIGINT`, `PK`   | Primary Key, Auto-Increment.                    |
| `user_id`      | `BIGINT`, `FK`   | Foreign Key ke `users.id` (kasir yang mencatat). |
| `total_price`  | `DECIMAL(10, 2)` | Total nilai dari transaksi tersebut.            |
| `created_at`   | `TIMESTAMP`      | Waktu terjadinya transaksi.                     |
| `updated_at`   | `TIMESTAMP`      | Waktu pembaruan record.                         |


### 5. Tabel: `transaction_details` (Detail Transaksi)

Tabel ini berfungsi sebagai detail untuk setiap transaksi, menjembatani relasi antara `transactions` dan `products`.

| Nama Kolom         | Tipe Data        | Keterangan                                      |
| :----------------- | :--------------- | :---------------------------------------------- |
| `id`               | `BIGINT`, `PK`   | Primary Key, Auto-Increment.                    |
| `transaction_id`   | `BIGINT`, `FK`   | Foreign Key ke `transactions.id`.               |
| `product_id`       | `BIGINT`, `FK`   | Foreign Key ke `products.id`.                   |
| `quantity`         | `INT`            | Jumlah item produk ini dalam transaksi tersebut. |
| `price`            | `DECIMAL(10, 2)` | Harga produk pada saat transaksi terjadi.       |

**Catatan:** Menyimpan `price` di sini penting untuk menjaga keakuratan data historis, seandainya harga produk di tabel `products` berubah di masa depan.

---

## Ringkasan Relasi

-   **Satu `User`** bisa memiliki **Banyak `Transaction`**. (`One-to-Many`)
    -   `users` (1) ---< `transactions` (M)

-   **Satu `Category`** bisa memiliki **Banyak `Product`**. (`One-to-Many`)
    -   `categories` (1) ---< `products` (M)

-   **Satu `Transaction`** bisa memiliki **Banyak `Product`** (melalui `transaction_details`), dan **Satu `Product`** bisa ada di **Banyak `Transaction`** (melalui `transaction_details`). (`Many-to-Many`)
    -   Relasi ini dijembatani oleh tabel `transaction_details`.
    -   `transactions` (1) ---< `transaction_details` (M) >--- (1) `products`
