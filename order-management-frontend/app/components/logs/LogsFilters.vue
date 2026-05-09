<template>
  <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-3">
    <button
      v-for="tab in tabs"
      :key="tab.value"
      @click="$emit('update:activeTab', tab.value)"
      :class="activeTab === tab.value
        ? 'bg-blue-600 text-white'
        : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
      class="px-4 py-2 rounded-xl text-sm font-medium transition-all"
    >
      {{ tab.label }}
    </button>
  </div>
</template>

<script setup>
defineProps({
  tabs: { type: Array, required: true },
  activeTab: { type: String, required: true },
})

defineEmits(['update:activeTab'])
</script>
