# Laravel CRUD Starter (Breeze + Yajra DataTables)

This project provides a **clean starting point** for Laravel with:

* Laravel installation
* Authentication using **Laravel Breeze**
* Server-side DataTables using **Yajra DataTables**
* A reusable **CRUD Artisan command** to generate modules quickly

---

## 📦 Requirements

* PHP >= 8.2
* Composer
* Node.js & NPM
* MySQL / MariaDB

---

## 🚀 Laravel Installation

```bash
composer create-project laravel/laravel laravel-crud
cd laravel-crud
```

Configure your database in `.env`

```env
DB_DATABASE=laravel_crud
DB_USERNAME=root
DB_PASSWORD=
```

Run migrations:

```bash
php artisan migrate
```

---

## 🔐 Install Laravel Breeze (Authentication)

```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
```

Install frontend dependencies:

```bash
npm install
npm run dev
```

Run migrations:

```bash
php artisan migrate
```

You now have:

* Login
* Register
* Forgot Password
* Dashboard

---

## 📊 Install Yajra DataTables (Laravel 12 Compatible)

```bash
composer require yajra/laravel-datatables:^12.0
```

(Optional) Publish config:

```bash
php artisan vendor:publish --tag=datatables
```

---

## ⚙️ Create CRUD Using Artisan Command

### Step 1: Create Custom CRUD Command

```bash
php artisan make:Model Product -mcr
```
---

## 🧩 Example: Product CRUD

### Fields

* id
* name
* description
* price
* status
* created_at

### Generated Files

```
app/Models/Product.php
app/Http/Controllers/ProductController.php
app/Http/Requests/ProductRequest.php
resources/views/products/
 ├── index.blade.php
 ├── create.blade.php
 └── edit.blade.php
```

---

## 📑 Yajra DataTable Example Route

```php
Route::get('products/list', [ProductController::class, 'list'])->name('products.list');
Route::resource('products', ProductController::class);
```


## 🧪 Run Project

```bash
php artisan serve
```

Visit:

```
http://127.0.0.1:8000
```

---

## ✅ Ready for

* Admin Panels
* Enterprise CRUD systems
* Interview projects
* Scalable Laravel applications

---

## 👨‍💻 Author

**Purvesh Patel**
Sr. Laravel / Full Stack Developer

---

Happy Coding 🚀
