<template>
  <div class="space-y-6">
    <DashboardStats :stats="stats" />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <DashboardRecentOrders :orders="recentOrders" />
      <DashboardInventory :products="inventory" />
    </div>

    <DashboardRecentActivity :logs="recentLogs" />
  </div>
</template>

<script setup>
definePageMeta({ layout: 'default' })

const stats = [
  { icon: 'shopping-cart', bg: 'bg-blue-100', label: 'Total Orders', value: '128', trend: '↑ 12% this month', trendColor: 'text-green-500' },
  { icon: 'dollar-sign', bg: 'bg-green-100', label: 'Total Revenue', value: '₱54,320', trend: '↑ 8% this month', trendColor: 'text-green-500' },
  { icon: 'package', bg: 'bg-yellow-100', label: 'Total Products', value: '45', trend: '3 low in stock', trendColor: 'text-yellow-500' },
  { icon: 'x-circle', bg: 'bg-red-100', label: 'Cancelled Orders', value: '8', trend: '↓ 2% this month', trendColor: 'text-red-500' },
]

const recentOrders = [
  { id: 1, number: 'ORD-001', date: 'May 9, 2026', amount: '₱1,200', status: 'Confirmed' },
  { id: 2, number: 'ORD-002', date: 'May 9, 2026', amount: '₱850', status: 'Pending' },
  { id: 3, number: 'ORD-003', date: 'May 8, 2026', amount: '₱3,400', status: 'Confirmed' },
  { id: 4, number: 'ORD-004', date: 'May 8, 2026', amount: '₱620', status: 'Cancelled' },
  { id: 5, number: 'ORD-005', date: 'May 7, 2026', amount: '₱2,100', status: 'Confirmed' },
]

const inventory = [
  { id: 1, name: 'Laptop Stand', stock: 5, max: 50 },
  { id: 2, name: 'Mechanical Keyboard', stock: 23, max: 50 },
  { id: 3, name: 'USB-C Hub', stock: 8, max: 50 },
  { id: 4, name: 'Webcam HD', stock: 35, max: 50 },
  { id: 5, name: 'Mouse Pad XL', stock: 42, max: 50 },
]

const recentLogs = [
  { icon: 'check-circle', color: 'bg-green-500', message: 'Order ORD-003 confirmed — inventory deducted', time: '2 hours ago' },
  { icon: 'plus', color: 'bg-blue-500', message: 'Added 20 units of Mechanical Keyboard', time: '4 hours ago' },
  { icon: 'x-circle', color: 'bg-red-500', message: 'Order ORD-004 cancelled — inventory restored', time: '5 hours ago' },
  { icon: 'shopping-cart', color: 'bg-yellow-500', message: 'New order ORD-005 created', time: '1 day ago' },
]
</script>
