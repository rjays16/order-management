# OrderSync - Backend API

Laravel 13 API for the Order Management System.

## Requirements

- PHP 8.2+
- Composer
- MySQL 8.0+

## Setup

```bash
# Install dependencies
composer install

# Copy environment file
cp .env.example .env
```

Edit `.env` and set database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=order_management
DB_USERNAME=root
DB_PASSWORD=
```

```bash
# Generate app key
php artisan key:generate

# Run migrations and seed sample data
php artisan migrate --seed

# Start the development server
php artisan serve
```

API runs at `http://localhost:8000`.

## API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/dashboard` | Dashboard stats, recent orders, inventory, activity |
| GET | `/api/products` | List products |
| POST | `/api/products` | Create product |
| PUT | `/api/products/{id}` | Update product |
| DELETE | `/api/products/{id}` | Delete product |
| GET | `/api/orders` | List orders (?status= filter) |
| POST | `/api/orders` | Create order (pending, stock validated) |
| PUT | `/api/orders/{id}/confirm` | Confirm order (stock deducted) |
| PUT | `/api/orders/{id}/cancel` | Cancel order (stock restored) |
| PUT | `/api/orders/{id}/cancel-item` | Cancel specific item |
| GET | `/api/logs` | List activity logs (?type= filter) |

## Database Commands

```bash
# Reset and re-seed
php artisan migrate:fresh --seed

# Run migrations only
php artisan migrate
```

## Tech Stack

- Laravel 13
- MySQL
- Eloquent ORM
- RESTful JSON API
