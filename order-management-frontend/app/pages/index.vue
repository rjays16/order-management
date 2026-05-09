<template>
  <div class="space-y-6">

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-white rounded-2xl shadow-sm p-6 flex items-center gap-4">
        <div class="bg-blue-100 p-4 rounded-xl text-3xl">🛒</div>
        <div>
          <p class="text-gray-400 text-sm">Total Orders</p>
          <p class="text-2xl font-bold text-gray-800">128</p>
          <p class="text-green-500 text-xs mt-1">↑ 12% this month</p>
        </div>
      </div>

      <div class="bg-white rounded-2xl shadow-sm p-6 flex items-center gap-4">
        <div class="bg-green-100 p-4 rounded-xl text-3xl">💰</div>
        <div>
          <p class="text-gray-400 text-sm">Total Revenue</p>
          <p class="text-2xl font-bold text-gray-800">₱54,320</p>
          <p class="text-green-500 text-xs mt-1">↑ 8% this month</p>
        </div>
      </div>

      <div class="bg-white rounded-2xl shadow-sm p-6 flex items-center gap-4">
        <div class="bg-yellow-100 p-4 rounded-xl text-3xl">📦</div>
        <div>
          <p class="text-gray-400 text-sm">Total Products</p>
          <p class="text-2xl font-bold text-gray-800">45</p>
          <p class="text-yellow-500 text-xs mt-1">3 low in stock</p>
        </div>
      </div>

      <div class="bg-white rounded-2xl shadow-sm p-6 flex items-center gap-4">
        <div class="bg-red-100 p-4 rounded-xl text-3xl">❌</div>
        <div>
          <p class="text-gray-400 text-sm">Cancelled Orders</p>
          <p class="text-2xl font-bold text-gray-800">8</p>
          <p class="text-red-500 text-xs mt-1">↓ 2% this month</p>
        </div>
      </div>
    </div>

    <!-- Recent Orders + Inventory Summary -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      <!-- Recent Orders -->
      <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-bold text-gray-800">🛒 Recent Orders</h3>
          <NuxtLink to="/orders" class="text-sm text-blue-500 hover:underline">
            View all →
          </NuxtLink>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead>
              <tr class="text-left text-gray-400 border-b border-gray-100">
                <th class="pb-3">Order #</th>
                <th class="pb-3">Date</th>
                <th class="pb-3">Amount</th>
                <th class="pb-3">Status</th>
              </tr>
            </thead>
            <tbody class="space-y-2">
              <tr v-for="order in recentOrders" :key="order.id"
                class="border-b border-gray-50 hover:bg-gray-50 transition-all">
                <td class="py-3 font-medium text-gray-700">{{ order.number }}</td>
                <td class="py-3 text-gray-500">{{ order.date }}</td>
                <td class="py-3 font-semibold text-gray-800">{{ order.amount }}</td>
                <td class="py-3">
                  <span :class="statusClass(order.status)"
                    class="px-3 py-1 rounded-full text-xs font-semibold">
                    {{ order.status }}
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Inventory Summary -->
      <div class="bg-white rounded-2xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-bold text-gray-800">📦 Inventory</h3>
          <NuxtLink to="/products" class="text-sm text-blue-500 hover:underline">
            View all →
          </NuxtLink>
        </div>
        <div class="space-y-4">
          <div v-for="product in inventorySummary" :key="product.id">
            <div class="flex justify-between items-center mb-1">
              <span class="text-sm text-gray-700 font-medium">{{ product.name }}</span>
              <span :class="product.stock < 10 ? 'text-red-500' : 'text-green-500'"
                class="text-xs font-semibold">
                {{ product.stock }} left
              </span>
            </div>
            <div class="w-full bg-gray-100 rounded-full h-2">
              <div
                :class="product.stock < 10 ? 'bg-red-400' : 'bg-green-400'"
                class="h-2 rounded-full transition-all"
                :style="{ width: `${Math.min((product.stock / product.max) * 100, 100)}%` }"
              />
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- Activity Timeline -->
    <div class="bg-white rounded-2xl shadow-sm p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-gray-800">📋 Recent Activity</h3>
        <NuxtLink to="/logs" class="text-sm text-blue-500 hover:underline">
          View all →
        </NuxtLink>
      </div>
      <div class="space-y-4">
        <div v-for="log in recentLogs" :key="log.id" class="flex items-start gap-4">
          <div :class="log.color" class="w-9 h-9 rounded-full flex items-center justify-center text-white text-sm flex-shrink-0">
            {{ log.icon }}
          </div>
          <div class="flex-1">
            <p class="text-sm text-gray-700 font-medium">{{ log.message }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ log.time }}</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
definePageMeta({ layout: 'default' })

const recentOrders = [
  { id: 1, number: 'ORD-001', date: 'May 9, 2026', amount: '₱1,200', status: 'Confirmed' },
  { id: 2, number: 'ORD-002', date: 'May 9, 2026', amount: '₱850', status: 'Pending' },
  { id: 3, number: 'ORD-003', date: 'May 8, 2026', amount: '₱3,400', status: 'Confirmed' },
  { id: 4, number: 'ORD-004', date: 'May 8, 2026', amount: '₱620', status: 'Cancelled' },
  { id: 5, number: 'ORD-005', date: 'May 7, 2026', amount: '₱2,100', status: 'Confirmed' },
]

const inventorySummary = [
  { id: 1, name: 'Laptop Stand', stock: 5, max: 50 },
  { id: 2, name: 'Mechanical Keyboard', stock: 23, max: 50 },
  { id: 3, name: 'USB-C Hub', stock: 8, max: 50 },
  { id: 4, name: 'Webcam HD', stock: 35, max: 50 },
  { id: 5, name: 'Mouse Pad XL', stock: 42, max: 50 },
]

const recentLogs = [
  { id: 1, icon: '✅', color: 'bg-green-500', message: 'Order ORD-003 confirmed — inventory deducted', time: '2 hours ago' },
  { id: 2, icon: '➕', color: 'bg-blue-500', message: 'Added 20 units of Mechanical Keyboard', time: '4 hours ago' },
  { id: 3, icon: '❌', color: 'bg-red-500', message: 'Order ORD-004 cancelled — inventory restored', time: '5 hours ago' },
  { id: 4, icon: '🛒', color: 'bg-yellow-500', message: 'New order ORD-005 created', time: '1 day ago' },
]

const statusClass = (status) => {
  const classes = {
    'Confirmed': 'bg-green-100 text-green-700',
    'Pending': 'bg-yellow-100 text-yellow-700',
    'Cancelled': 'bg-red-100 text-red-700',
  }
  return classes[status] || 'bg-gray-100 text-gray-700'
}
</script>