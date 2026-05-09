<template>
  <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-6">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2"><Icon name="shopping-cart" class="w-5 h-5" /> Recent Orders</h3>
      <NuxtLink to="/orders" class="text-sm text-blue-500 hover:underline">View all →</NuxtLink>
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
          <tr v-for="order in orders" :key="order.id"
            class="border-b border-gray-50 hover:bg-gray-50 transition-all">
            <td class="py-3 font-medium text-gray-700">{{ order.number }}</td>
            <td class="py-3 text-gray-500">{{ order.date }}</td>
            <td class="py-3 font-semibold text-gray-800">{{ order.amount }}</td>
            <td class="py-3">
              <span :class="ORDER_STATUS[order.status]?.bg"
                class="px-3 py-1 rounded-full text-xs font-semibold">
                {{ order.status }}
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ORDER_STATUS } from '~/utils/orders/orderStatus'

defineProps({
  orders: { type: Array, required: true },
})
</script>
