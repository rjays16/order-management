<template>
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <div
      v-for="stat in stats"
      :key="stat.label"
      class="bg-white rounded-2xl shadow-sm p-6 flex items-center gap-4"
    >
      <div :class="stat.bg" class="p-4 rounded-xl text-3xl">{{ stat.icon }}</div>
      <div>
        <p class="text-gray-400 text-sm">{{ stat.label }}</p>
        <p class="text-2xl font-bold text-gray-800">{{ stat.value }}</p>
        <p :class="stat.trendColor" class="text-xs mt-1">{{ stat.trend }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  stats: { type: Array, required: true },
})
</script>
