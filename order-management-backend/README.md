# OrderSync - Backend API

## Setup

```bash
composer install
cp .env.example .env
```

Edit `.env` (database credentials), then:

```bash
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

API runs at `http://localhost:8000`.

## API Endpoints

- `GET/POST/PUT/DELETE /api/products`
- `GET/POST /api/orders`
- `PUT /api/orders/{id}/confirm`
- `PUT /api/orders/{id}/cancel`
- `PUT /api/orders/{id}/cancel-item`
- `GET /api/logs`
- `GET /api/dashboard`
