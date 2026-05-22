# Backup Database — Ruto Store System

File: **`db_ruto_store_system.sql`**

Dump dari MySQL lokal (`db_ruto_store_system`) berisi struktur tabel + data awal (user admin/kasir, kategori, produk).

## Akun default (password: `password`)

| Role  | Email              |
|-------|--------------------|
| Admin | admin@ruto.store   |
| Kasir | kasir@ruto.store   |

## Import di perangkat lain

### Opsi 1 — Command line (MySQL / MariaDB)

```bash
mysql -u root -p < database/sql/db_ruto_store_system.sql
```

Atau jika sudah di folder project:

```bash
mysql -u root -p < database/sql/db_ruto_store_system.sql
```

### Opsi 2 — phpMyAdmin

1. Buka phpMyAdmin
2. Tab **Import** → pilih file `db_ruto_store_system.sql`
3. Klik **Go**

### Opsi 3 — Laravel migrate (tanpa file SQL)

Jika hanya butuh struktur + data demo:

```bash
composer install
cp .env.example .env   # lalu sesuaikan DB_* ke MySQL Anda
php artisan key:generate
php artisan migrate --seed
```

## Setting `.env` di perangkat baru

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_ruto_store_system
DB_USERNAME=root
DB_PASSWORD=
```

Sesuaikan `DB_USERNAME` dan `DB_PASSWORD` dengan MySQL di device tersebut.

## Memperbarui dump

Jalankan dari root project (Windows):

```powershell
mysqldump -u root -p --databases db_ruto_store_system --routines --triggers --result-file=database/sql/db_ruto_store_system.sql
```

Ganti `-u root` jika user MySQL Anda berbeda.
