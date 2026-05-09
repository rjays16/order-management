# Setup Instructions

## Prerequisites

- PHP 8.2+ with Composer
- Node.js 18+ with npm
- MySQL 8.0+
- A database named `order_management` (create via phpMyAdmin or SQLyog)

---

## Backend Setup

```bash
cd order-management-backend

# Install dependencies
composer install

# Copy environment file and configure database
copy .env.example .env
```

Edit `.env` and set your database credentials:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=order_management
DB_USERNAME=root
DB_PASSWORD=
```

Then run:

```bash
# Generate app key
php artisan key:generate

# Run migrations (creates tables)
php artisan migrate

# Seed with sample data (6 products, 5 orders, 10 activity logs)
php artisan db:seed

# Start the API server
php artisan serve
```

The API will be running at `http://localhost:8000`.

---

## Frontend Setup

Open a **new terminal window**.

```bash
cd order-management-frontend

# Install dependencies
npm install

# Start development server
npm run dev
```

The frontend will be running at `http://localhost:3000`.

### Environment

The `.env` file already contains:

```
NUXT_PUBLIC_API_BASE=http://localhost:8000/api
```

This is configured in `nuxt.config.ts` under `runtimeConfig.public.apiBase`.

---

## Usage

1. Open `http://localhost:3000` in your browser
2. Navigate using the sidebar:
   - **Dashboard** — View stats, recent orders, low-stock inventory, activity feed
   - **Products** — Add / Edit / Delete products
   - **Orders** — Create orders / Confirm / Cancel / Cancel individual items
   - **Activity Logs** — View and filter activity logs by type

---

## Database Reset

To reset and re-seed the database:

```bash
cd order-management-backend
php artisan migrate:fresh --seed
```
