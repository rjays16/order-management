<template>
  <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
      <thead class="bg-gray-50 border-b border-gray-100">
        <tr class="text-left text-gray-500">
          <th class="px-6 py-4 font-semibold">Order #</th>
          <th class="px-6 py-4 font-semibold">Date</th>
          <th class="px-6 py-4 font-semibold">Items</th>
          <th class="px-6 py-4 font-semibold">Total</th>
          <th class="px-6 py-4 font-semibold">Status</th>
          <th class="px-6 py-4 font-semibold">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="order in orders"
          :key="order.id"
          class="border-b border-gray-50 hover:bg-gray-50 transition-all"
        >
          <td class="px-6 py-4 font-semibold text-blue-600">{{ order.number }}</td>
          <td class="px-6 py-4 text-gray-500">{{ order.date }}</td>
          <td class="px-6 py-4 text-gray-600">{{ order.items.length }} item(s)</td>
          <td class="px-6 py-4 font-semibold text-gray-800">₱{{ order.total.toLocaleString() }}</td>
          <td class="px-6 py-4">
            <span :class="ORDER_STATUS[order.status]?.bg"
              class="px-3 py-1 rounded-full text-xs font-semibold">
              {{ order.status }}
            </span>
          </td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-2">
              <button
                @click="$emit('view', order)"
                class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-medium transition-all"
              >👁️ View</button>
              <button
                v-if="order.status === 'Pending'"
                @click="$emit('confirm', order.id)"
                class="bg-green-100 hover:bg-green-200 text-green-700 px-3 py-1.5 rounded-lg text-xs font-medium transition-all"
              >✅ Confirm</button>
              <button
                v-if="order.status !== 'Cancelled'"
                @click="$emit('cancel', order.id)"
                class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1.5 rounded-lg text-xs font-medium transition-all"
              >❌ Cancel</button>
            </div>
          </td>
        </tr>
        <tr v-if="orders.length === 0">
          <td colspan="6" class="px-6 py-16 text-center text-gray-400">
            <div class="text-5xl mb-3">🛒</div>
            <p>No orders found</p>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ORDER_STATUS } from '~/utils/orders/orderStatus'

defineProps({
  orders: { type: Array, required: true },
})

defineEmits(['view', 'confirm', 'cancel'])
</script>
