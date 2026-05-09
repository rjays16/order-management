<template>
  <div class="flex items-center justify-between">
    <div>
      <h2 class="text-2xl font-bold text-gray-800">📦 Products</h2>
      <p class="text-gray-400 text-sm mt-1">Manage your product inventory</p>
    </div>
    <button
      @click="$emit('add')"
      class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition-all flex items-center gap-2"
    >
      <span>+</span> Add Product
    </button>
  </div>
</template>

<script setup>
defineEmits(['add'])
</script>
