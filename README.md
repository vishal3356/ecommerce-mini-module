# Laravel E-Commerce — Ready Project (Interview Submission)

This archive contains a ready project skeleton with the E-Commerce mini module integrated.  
**Important:** This is a skeleton that will become a working Laravel application once you run `composer update` to fetch the framework and dependencies.

## Steps to make it runnable

1. Install PHP (8.1+ recommended), Composer, and Node (optional for frontend).
2. From project root, run:
```bash
composer update
```
This will download the Laravel framework and dependencies.  
3. Copy environment file:
```bash
cp .env.example .env
```
4. If using SQLite (default in .env.example), create the file:
```bash
mkdir -p database
touch database/database.sqlite
```
Or update `.env` with your MySQL/Postgres credentials.

5. Generate app key:
```bash
php artisan key:generate
```

6. Run migrations & seed sample products:
```bash
php artisan migrate --seed
```

7. (Optional) Install Breeze auth scaffolding (if you want UI auth):
```bash
composer require laravel/breeze --dev
php artisan breeze:install blade
npm install && npm run build
php artisan migrate
```

8. Serve:
```bash
php artisan serve
```

Open http://localhost:8000

---

If you prefer, you can run:
```bash
php -S localhost:8000 -t public
```
but `php artisan serve` is recommended.

--- 

Included features:
- Products CRUD (Admin)
- Shop (browse products)
- Cart (session for guests, DB for logged-in users)
- Checkout API: POST /api/checkout
