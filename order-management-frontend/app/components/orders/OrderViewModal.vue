<template>
  <div v-if="show"
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-lg mx-4">
      <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2"><Icon name="shopping-cart" class="w-5 h-5" /> {{ order?.number }}</h3>
        <span :class="ORDER_STATUS[order?.status]?.bg"
          class="px-3 py-1 rounded-full text-xs font-semibold">
          {{ order?.status }}
        </span>
      </div>

      <div class="space-y-3 mb-6">
        <div class="flex justify-between text-sm">
          <span class="text-gray-400">Date</span>
          <span class="text-gray-700 font-medium">{{ order?.date }}</span>
        </div>
      </div>

      <div class="border border-gray-100 rounded-xl overflow-hidden mb-6">
        <table class="w-full text-sm">
          <thead class="bg-gray-50">
            <tr class="text-left text-gray-500">
              <th class="px-4 py-3 font-semibold">Product</th>
              <th class="px-4 py-3 font-semibold">Qty</th>
              <th class="px-4 py-3 font-semibold">Price</th>
              <th class="px-4 py-3 font-semibold">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in order?.items" :key="item.id"
              class="border-t border-gray-50">
              <td class="px-4 py-3 text-gray-700">{{ item.name }}</td>
              <td class="px-4 py-3 text-gray-600">{{ item.qty }}</td>
              <td class="px-4 py-3 text-gray-600">₱{{ item.price.toLocaleString() }}</td>
              <td class="px-4 py-3 font-semibold text-gray-800">₱{{ (item.qty * item.price).toLocaleString() }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <div class="flex justify-between items-center mb-6">
        <span class="font-bold text-gray-700">Total Amount</span>
        <span class="text-xl font-bold text-blue-600">₱{{ order?.total.toLocaleString() }}</span>
      </div>

      <button
        @click="$emit('close')"
        class="w-full px-4 py-2.5 bg-gray-100 text-gray-600 rounded-xl hover:bg-gray-200 transition-all font-medium"
      >Close</button>
    </div>
  </div>
</template>

<script setup>
import { ORDER_STATUS } from '~/utils/orders/orderStatus'

defineProps({
  show: { type: Boolean, required: true },
  order: { type: Object, default: null },
})

defineEmits(['close'])
</script>
