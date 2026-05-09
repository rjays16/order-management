<template>
  <div class="flex items-center justify-between">
    <div>
      <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2"><Icon name="shopping-cart" class="w-6 h-6" /> Orders</h2>
      <p class="text-gray-400 text-sm mt-1">Manage your orders</p>
    </div>
    <button
      @click="$emit('create')"
      class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition-all flex items-center gap-2"
    >
      <Icon name="plus" class="w-4 h-4" /> Create Order
    </button>
  </div>
</template>

<script setup>
defineEmits(['create'])
</script>
