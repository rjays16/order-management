# OrderSync - Order Management System

A full-stack order management system built with **Laravel 13** (backend) and **Nuxt 4 + Vue 3 + Tailwind CSS** (frontend).

## Features

- **Dashboard** — Stats overview (total products, orders, revenue, pending orders), recent orders, low-stock inventory alerts, recent activity feed
- **Product Management** — CRUD operations with stock tracking and stock status indicators (In Stock / Low Stock / Out of Stock)
- **Order Management** — Create orders with multiple items (auto-stock deduction), confirm orders, cancel orders (auto-stock restore), partial item cancellation
- **Activity Logging** — Automatic logs for order creation, status changes, stock deductions/restores with type-based filtering
- **Error Handling** — Toast notifications for success/error feedback on all operations

## Tech Stack

| Layer    | Technology |
|----------|-----------|
| Backend  | Laravel 13, MySQL |
| Frontend | Nuxt 4, Vue 3, Tailwind CSS |
| API      | RESTful JSON |

## Project Structure

```
order-management/
├── order-management-backend/     # Laravel API
│   ├── app/
│   │   ├── Http/Controllers/     # API controllers
│   │   ├── Http/Resources/       # API resource transformers
│   │   └── Models/               # Eloquent models
│   ├── database/
│   │   ├── migrations/           # DB schema
│   │   └── seeders/              # Sample data
│   └── routes/api.php            # API routes
│
└── order-management-frontend/    # Nuxt SPA
    └── app/
        ├── components/           # UI components
        │   ├── dashboard/
        │   ├── products/
        │   ├── orders/
        │   └── logs/
        ├── composables/          # useApi, useToast
        ├── layouts/              # App layout with sidebar
        ├── pages/                # Route pages
        └── utils/                # Constants & helpers
```

## API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/dashboard` | Dashboard stats, recent orders, inventory, activity |
| GET | `/api/products` | List all products |
| POST | `/api/products` | Create product |
| PUT | `/api/products/{id}` | Update product |
| DELETE | `/api/products/{id}` | Delete product |
| GET | `/api/orders` | List orders (optional `?status=` filter) |
| POST | `/api/orders` | Create order (with stock deduction) |
| PUT | `/api/orders/{id}/confirm` | Confirm order |
| PUT | `/api/orders/{id}/cancel` | Cancel entire order (restores stock) |
| PUT | `/api/orders/{id}/cancel-item` | Cancel specific item (restores stock) |
| GET | `/api/logs` | List activity logs (optional `?type=` filter) |
