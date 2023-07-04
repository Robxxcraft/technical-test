Beberapa aplikasi yang harus diinstal:

- Composer.
- Xampp.
- Node js & NPM.

### 1. Jalankan perintah dibawah ini untuk menyalin project

```sh
git clone https://github.com/Robxxcraft/technical-test
```
<br>

### 2. Masuk ke dalam project yang telah disalin

```sh
cd technical-test
```
<br />


# Backend

### 1. masuk ke dalam project backend

```sh
cd technical-test-back
```
<br />

### 2. Install package composer

```sh
composer install
```
<br />


### 3. Buat database baru dengan nama technical_test_back

```sh
> mysql -u root -p
> create database technical_test_back;
```
<br />

### 4. Migrate table yang sudah dibuat

```sh
php artisan migrate
```
<br />

### 5. Buat data buatan dari seeder

```sh
php artisan db:seed
```
<br />

### 6. Jalankan project backend

```sh
php artisan serve
```
<br />

# Frontend

### 1. Masuk ke dalam project frontend

```sh
cd technical-test-front
```
<br />

### 2. Install package npm

```sh
npm install
```
<br />

### 3. Jalankan project frontend

```sh
npm run dev
```
<br />