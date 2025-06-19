
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Website Manajemen Pelanggan WiFi - Tugas Akhir

Website ini merupakan bagian dari Tugas Akhir saya dengan judul **"Merancang Website Manajemen Pelanggan Menggunakan Laravel"**. Sistem ini dirancang untuk membantu pengelolaan data pelanggan WiFi dan mempermudah proses pendaftaran pelanggan baru melalui peran **admin** dan **sales**.

## 🔧 Teknologi yang Digunakan

- **Laravel** 10
- **FilamentPHP** (admin panel)
- **PHP** 8+
- **MySQL**
- **Tailwind CSS** (via Filament)
- **Git & GitHub**

## 👥 Role Pengguna

1. **Admin (Owner)**
   - Mengelola data sales dan customer dan data paket
   - Melihat notifikasi pelanggan baru 
   - Menambahkan paket WiFi

2. **Sales**
   - Mendaftarkan pelanggan yang ingin memasang WiFi
   - Mengisi data seperti nama, NIK, alamat, nomor HP, dan memilih paket
   - Data akan dikirim ke admin untuk di-ACC

3. **Customer**
   - Terdaftar oleh sales, tidak perlu login
   - Informasi tersimpan di sistem untuk keperluan pemasangan dan pembayaran

## 📦 Fitur

- 🔐 Login dengan ID dan password 
- 📄 Manajemen data pelanggan (nama, NIK, foto, alamat, nomor HP, paket)
- 📢 Notifikasi ke admin jika ada pelanggan baru
- 📊 Terdapat tiga panel yg berbeda
- 📁 Upload foto pelanggan dan sales
- 🔄 Dropdown pilihan paket internet saat pendaftaran
- 📥 Impor & Ekspor Data Pelanggan
- 🧾 Cetak Struk
- 📲 WhatsApp Gateway


## 🛠️ Cara Menjalankan Proyek

```bash
git clone https://github.com/mattocx/WIFI.git
cd nama-repo
composer install
cp .env.example .env
php artisan key:generate
# Konfigurasi database di file .env
php artisan migrate
php artisan serve
