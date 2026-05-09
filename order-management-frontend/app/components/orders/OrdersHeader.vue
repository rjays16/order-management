<template>
  <div class="flex items-center justify-between">
    <div>
      <h2 class="text-2xl font-bold text-gray-800">🛒 Orders</h2>
      <p class="text-gray-400 text-sm mt-1">Manage your orders</p>
    </div>
    <button
      @click="$emit('create')"
      class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition-all flex items-center gap-2"
    >
      <span>+</span> Create Order
    </button>
  </div>
</template>

<script setup>
defineEmits(['create'])
</script>
