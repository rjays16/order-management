# OrderSync - Frontend

Nuxt 4 + Vue 3 + Tailwind CSS SPA for the Order Management System.

## Requirements

- Node.js 18+
- npm

## Setup

```bash
# Install dependencies
npm install

# Start development server
npm run dev
```

Frontend runs at `http://localhost:3000`.

## Environment

The `.env` file sets the API base URL:

```
NUXT_PUBLIC_API_BASE=http://localhost:8000/api
```

Make sure the backend API server is running on `http://localhost:8000`.

## Build for Production

```bash
npm run build
npm run preview
```

## Project Structure

```
app/
├── components/       # UI components (dashboard/, products/, orders/, logs/)
│   ├── dashboard/    # Stats, RecentOrders, Inventory, RecentActivity
│   ├── products/     # Header, Stats, Search, Table, FormModal
│   ├── orders/       # Header, Stats, Filters, Table, ViewModal, CreateModal
│   └── logs/         # Header, Stats, Filters, Timeline
├── composables/      # useApi (fetch helper), useToast (notifications)
├── layouts/          # Default layout with sidebar navigation
├── pages/            # Dashboard, Products, Orders, Logs
└── utils/            # Constants (orderStatus, logTypes, productStorage)
```

## Tech Stack

- Nuxt 4
- Vue 3 (Composition API, `<script setup>`)
- Tailwind CSS
- Nuxt TailwindCSS module
