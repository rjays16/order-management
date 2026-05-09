<template>
  <div class="bg-white rounded-2xl shadow-sm p-6">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2"><Icon name="package" class="w-5 h-5" /> Inventory</h3>
      <NuxtLink to="/products" class="text-sm text-blue-500 hover:underline">View all →</NuxtLink>
    </div>
    <div class="space-y-4">
      <div v-for="product in products" :key="product.id">
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
</template>

<script setup>
defineProps({
  products: { type: Array, required: true },
})
</script>
