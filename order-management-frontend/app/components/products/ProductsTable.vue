<template>
  <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
    <table class="w-full text-sm">
      <thead class="bg-gray-50 border-b border-gray-100">
        <tr class="text-left text-gray-500">
          <th class="px-6 py-4 font-semibold">#</th>
          <th class="px-6 py-4 font-semibold">Product Name</th>
          <th class="px-6 py-4 font-semibold">Description</th>
          <th class="px-6 py-4 font-semibold">Price</th>
          <th class="px-6 py-4 font-semibold">Stock</th>
          <th class="px-6 py-4 font-semibold">Status</th>
          <th class="px-6 py-4 font-semibold">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(product, index) in products"
          :key="product.id"
          class="border-b border-gray-50 hover:bg-gray-50 transition-all"
        >
          <td class="px-6 py-4 text-gray-400">{{ index + 1 }}</td>
          <td class="px-6 py-4 font-semibold text-gray-800">{{ product.name }}</td>
          <td class="px-6 py-4 text-gray-500">{{ product.description }}</td>
          <td class="px-6 py-4 font-semibold text-gray-800">₱{{ product.price.toLocaleString() }}</td>
          <td class="px-6 py-4 font-semibold text-gray-800">{{ product.stock }}</td>
          <td class="px-6 py-4">
            <span :class="stockStatus(product.stock).bg"
              class="px-3 py-1 rounded-full text-xs font-semibold">
              {{ stockStatus(product.stock).label }}
            </span>
          </td>
          <td class="px-6 py-4">
            <div class="flex items-center gap-2">
              <button
                @click="$emit('edit', product)"
                class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-3 py-1.5 rounded-lg text-xs font-medium transition-all"
              >✏️ Edit</button>
              <button
                @click="$emit('delete', product.id)"
                class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1.5 rounded-lg text-xs font-medium transition-all"
              >🗑️ Delete</button>
            </div>
          </td>
        </tr>
        <tr v-if="products.length === 0">
          <td colspan="7" class="px-6 py-16 text-center text-gray-400">
            <div class="text-5xl mb-3">📦</div>
            <p>No products found</p>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { stockStatus } from '~/utils/products/productStorage'

defineProps({
  products: { type: Array, required: true },
})

defineEmits(['edit', 'delete'])
</script>
