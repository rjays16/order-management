<template>
  <div class="bg-white rounded-2xl shadow-sm p-6">
    <div class="relative">
      <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-gray-100"></div>
      <div class="space-y-6">
        <div
          v-for="log in logs"
          :key="log.id"
          class="flex items-start gap-4 relative"
        >
            <div :class="logConfig(log.type).dotClass"
              class="w-12 h-12 rounded-full flex items-center justify-center text-white flex-shrink-0 z-10 shadow-md">
              <Icon :name="logConfig(log.type).icon" class="w-5 h-5" />
            </div>
          <div class="flex-1 bg-gray-50 rounded-2xl p-4 hover:bg-gray-100 transition-all">
            <div class="flex items-start justify-between">
              <div>
                <p class="text-gray-800 font-semibold text-sm">{{ log.message }}</p>
                <p class="text-gray-500 text-xs mt-1">{{ log.detail }}</p>
              </div>
              <div class="text-right flex-shrink-0 ml-4">
                <span :class="logConfig(log.type).badgeClass"
                  class="px-2 py-1 rounded-full text-xs font-semibold">
                  {{ log.type }}
                </span>
                <p class="text-gray-400 text-xs mt-1">{{ log.time }}</p>
              </div>
            </div>
          </div>
        </div>
        <div v-if="logs.length === 0" class="text-center py-16 text-gray-400">
          <Icon name="clipboard-list" class="w-12 h-12 mb-3 mx-auto text-gray-300" />
          <p>No logs found</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { logConfig } from '~/utils/logs/logTypes'

defineProps({
  logs: { type: Array, required: true },
})
</script>
