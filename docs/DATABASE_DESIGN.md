# Desain Database - Sistem POS QIO Coffee

Dokumen ini menjelaskan rancangan struktur database untuk aplikasi POS QIO Coffee. Rancangan ini mencakup tabel, kolom, dan relasi antar tabel yang dibutuhkan untuk memenuhi kebutuhan fungsional sistem.

---

## Deskripsi Entitas (Tabel)

Database ini akan terdiri dari 4 tabel utama: `users`, `products`, `transactions`, dan tabel pivot `product_transaction`.

### 1. Tabel: `users`

Menyimpan data pengguna yang dapat login ke sistem, yaitu Pemilik dan Kasir.

| Nama Kolom  | Tipe Data      | Keterangan                                      |
| :---------- | :------------- | :---------------------------------------------- |
| `id`        | `BIGINT`, `PK` | Primary Key, Auto-Increment.                    |
| `name`      | `VARCHAR(255)` | Nama lengkap pengguna.                          |
| `email`     | `VARCHAR(255)` | Email untuk login, harus unik.                  |
| `password`  | `VARCHAR(255)` | Password yang sudah di-hash.                    |
| `role`      | `ENUM`         | Hak akses pengguna: `'owner'`, `'cashier'`.     |
| `created_at`| `TIMESTAMP`    | Waktu pembuatan record.                         |
| `updated_at`| `TIMESTAMP`    | Waktu pembaruan record.                         |


### 2. Tabel: `products`

Menyimpan semua data produk atau item menu yang dijual.

| Nama Kolom    | Tipe Data        | Keterangan                                      |
| :------------ | :--------------- | :---------------------------------------------- |
| `id`          | `BIGINT`, `PK`   | Primary Key, Auto-Increment.                    |
| `name`        | `VARCHAR(255)`   | Nama produk (misal: "Espresso", "Latte").     |
| `description` | `TEXT`           | Deskripsi singkat produk (opsional).            |
| `price`       | `DECIMAL(10, 2)` | Harga jual produk.                              |
| `stock`       | `INT`            | Jumlah stok produk yang tersedia.               |
| `image_url`   | `VARCHAR(255)`   | URL gambar produk untuk ditampilkan di landing page (opsional). |
| `created_at`  | `TIMESTAMP`      | Waktu pembuatan record.                         |
| `updated_at`  | `TIMESTAMP`      | Waktu pembaruan record.                         |


### 3. Tabel: `transactions`

Menyimpan data setiap transaksi penjualan yang terjadi.

| Nama Kolom     | Tipe Data        | Keterangan                                      |
| :------------- | :--------------- | :---------------------------------------------- |
| `id`           | `BIGINT`, `PK`   | Primary Key, Auto-Increment.                    |
| `user_id`      | `BIGINT`, `FK`   | Foreign Key ke `users.id` (kasir yang mencatat). |
| `total_amount` | `DECIMAL(10, 2)` | Total nilai dari transaksi tersebut.            |
| `created_at`   | `TIMESTAMP`      | Waktu terjadinya transaksi.                     |
| `updated_at`   | `TIMESTAMP`      | Waktu pembaruan record.                         |


### 4. Tabel: `product_transaction` (Tabel Pivot)

Tabel ini menjembatani relasi *Many-to-Many* antara tabel `products` dan `transactions`. Satu transaksi bisa memiliki banyak produk, dan satu produk bisa ada di banyak transaksi.

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

-   **Satu `Transaction`** bisa memiliki **Banyak `Product`**, dan **Satu `Product`** bisa ada di **Banyak `Transaction`**. (`Many-to-Many`)
    -   Relasi ini dijembatani oleh tabel `product_transaction`.
    -   `transactions` (1) ---< `product_transaction` (M) >--- (1) `products`
