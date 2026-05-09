<template>
  <div class="bg-white rounded-2xl shadow-sm p-6">
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-bold text-gray-800">📋 Recent Activity</h3>
      <NuxtLink to="/logs" class="text-sm text-blue-500 hover:underline">View all →</NuxtLink>
    </div>
    <div class="space-y-4">
      <div v-for="log in logs" :key="log.id" class="flex items-start gap-4">
        <div :class="log.color"
          class="w-9 h-9 rounded-full flex items-center justify-center text-white text-sm flex-shrink-0">
          {{ log.icon }}
        </div>
        <div class="flex-1">
          <p class="text-sm text-gray-700 font-medium">{{ log.message }}</p>
          <p class="text-xs text-gray-400 mt-1">{{ log.time }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  logs: { type: Array, required: true },
})
</script>
