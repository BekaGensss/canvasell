# CanvaSell - Portal Manajemen Produk Digital Admin

![Laravel & Tailwind CSS](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![PHP 8.2+](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)

Portal manajemen inventaris dan pemesanan yang dirancang untuk mengelola penjualan produk digital (langganan premium, kode voucher, dll.) secara efisien.

---

## 🚀 Fitur Utama

Proyek ini dibagi menjadi dua area fungsional utama:

### 🛒 Frontend (Toko)
* **Halaman Produk:** Menampilkan daftar produk digital yang dijual.
* **Checkout Sederhana:** Proses pemesanan yang cepat dan *user-friendly*.
* **Webhook Listener:** Integrasi *middleware* untuk mendengarkan dan memproses notifikasi pembayaran otomatis (misal dari Midtrans/Penyedia Payment Gateway).
* **Konfirmasi Pembelian:** Halaman untuk melihat status order dan menerima *code redeem* yang dialokasikan.

### 🔒 Backend (Admin Panel)
* **Autentikasi Aman:** Login Admin yang diamankan menggunakan **Laravel Breeze/Fortify**.
* **Desain Estetik:** Admin Panel menggunakan tema **Emerald/Slate** yang modern dan profesional.
* **CRUD Produk:** Mengelola daftar produk yang dijual (*Nama*, *Harga*, *Gambar*, *Status Aktif*).
* **CRUD Kode Redeem (Inventaris Digital):**
    * Input kode per satuan secara manual.
    * **Import Massal (CSV):** Memasukkan ribuan kode sekaligus untuk manajemen stok yang efisien.
* **Manajemen Pemesanan (Order):**
    * Melihat status dan detail transaksi pelanggan secara *real-time*.
    * **Hapus Riwayat Massal:** Fungsi untuk membersihkan *order* lama (*completed*, *failed*) dari *database*.
* **Alokasi Kode:** Mendukung alokasi kode secara otomatis setelah pembayaran terkonfirmasi atau manual oleh Admin.

---

## 🛠️ Instalasi dan Konfigurasi Lokal

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek di lingkungan pengembangan lokal Anda (Laragon/XAMPP/Docker).

### Persyaratan Sistem
* PHP 8.2+
* Composer
* Node.js & NPM
* MySQL/MariaDB

### Langkah-Langkah Instalasi (Contoh)
1.  **Clone Repositori:**
    ```bash
    git clone [https://github.com/BekaGensss/canvasell.git](https://github.com/BekaGensss/canvasell.git)
    cd canvasell
    ```
2.  **Instal Dependencies:**
    ```bash
    composer install
    npm install
    ```
3.  **Setup Environment:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    # Edit .env dan masukkan kredensial database lokal Anda
    ```
4.  **Migrasi Database:**
    ```bash
    php artisan migrate --seed
    ```
5.  **Kompilasi Assets:**
    ```bash
    npm run dev 
    ```
6.  **Jalankan Server:**
    ```bash
    php artisan serve
    ```
Akses aplikasi Anda di `http://127.0.0.1:8000`.
