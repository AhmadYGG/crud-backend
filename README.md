# 🛠️ Laravel Products CRUD API (Sanctum Auth)

Project ini adalah **RESTful API** sederhana dengan fitur:

- ✅ Authentication (Register, Login, Logout) menggunakan **Laravel Sanctum**  
- ✅ CRUD Products (Create, Read, Update, Delete)  
- ✅ Relasi `User → Product` (1 user dapat banyak produk)  
- ✅ Validasi input di semua request  
- ✅ Filtering, searching, dan sorting produk  
- ✅ Proteksi route (hanya pemilik produk bisa update/hapus)  

---

## 🚀 Tech Stack
- [Laravel 11+](https://laravel.com/)  
- [Sanctum](https://laravel.com/docs/sanctum) untuk token-based authentication  
- MySQL / MariaDB (bisa ganti ke DB lain)  

---

## 📦 Installation

1. **Clone repo**
   ```bash
   git clone https://github.com/AhmadYGG/crud-backend.git
   cd crud-backend
   ```

2. **Install dependencies**
   ```bash
   composer install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   ```
   - Atur database di file `.env`:
     ```env
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=laravel_crud
     DB_USERNAME=root
     DB_PASSWORD=
     ```

4. **Generate app key**
   ```bash
   php artisan key:generate
   ```

5. **Migrate database**
   ```bash
   php artisan migrate
   ```

6. **Install Sanctum**
   ```bash
   php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
   php artisan migrate
   ```

7. **Run server**
   ```bash
   php artisan serve
   ```
   API akan jalan di:
   ```
   http://127.0.0.1:8000
   ```

---

## 🔑 Authentication Flow
1. **Register** → `POST /api/register`  
2. **Login** → `POST /api/login` (dapatkan `access_token`)  
3. Gunakan `Authorization: Bearer <access_token>` untuk akses endpoint yang dilindungi  
4. **Logout** → `POST /api/logout`  

---

## 📦 API Endpoints

### Auth
- `POST /api/register` → Register user baru  
- `POST /api/login` → Login dan dapatkan token  
- `POST /api/logout` → Logout (hapus token aktif)  

### Products
- `GET /api/products` → Lihat semua produk (public)  
  - Query params: `name`, `min_price`, `max_price`, `sort=asc|desc`
- `GET /api/products/{id}` → Detail produk (public)  
- `POST /api/products` → Buat produk (authenticated)  
- `PUT /api/products/{id}` → Update produk (owner only)  
- `DELETE /api/products/{id}` → Hapus produk (owner only)  

---

## 🧪 Testing
Bisa pakai **Postman** atau `curl`.  

Contoh create product:
```bash
curl -X POST http://127.0.0.1:8000/api/products -H "Authorization: Bearer <access_token>" -H "Content-Type: application/json" -d '{
  "name": "Laptop Gaming",
  "description": "RTX 4060, RAM 16GB",
  "price": 2000,
  "stock": 5
}'
```