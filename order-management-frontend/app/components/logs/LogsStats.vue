<template>
  <div class="grid grid-cols-4 gap-4">
    <div
      v-for="stat in stats"
      :key="stat.label"
      class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-3"
    >
      <div :class="stat.bg" class="p-3 rounded-xl"><Icon :name="stat.icon" class="w-6 h-6" /></div>
      <div>
        <p class="text-gray-400 text-xs">{{ stat.label }}</p>
        <p class="text-xl font-bold text-gray-800">{{ stat.count }}</p>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  stats: { type: Array, required: true },
})
</script>
