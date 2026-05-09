<template>
  <div class="bg-white rounded-2xl shadow-sm p-4">
    <input
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      type="text"
      placeholder="🔍 Search products..."
      class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 text-gray-700"
    />
  </div>
</template>

<script setup>
defineProps({
  modelValue: { type: String, required: true },
})

defineEmits(['update:modelValue'])
</script>
