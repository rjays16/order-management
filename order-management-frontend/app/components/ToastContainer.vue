<template>
  <div class="fixed top-4 right-4 z-[9999] space-y-2">
    <transition-group name="toast">
      <div
        v-for="t in toasts" :key="t.id"
        :class="[bgMap[t.type], 'px-5 py-3 rounded-xl shadow-lg text-white font-medium text-sm flex items-center gap-2 min-w-[280px] max-w-sm']"
      >
        <Icon :name="iconMap[t.type]" class="w-5 h-5 shrink-0" />
        <span>{{ t.message }}</span>
        <button @click="dismiss(t.id)" class="ml-auto text-white/70 hover:text-white">
          <Icon name="x" class="w-4 h-4" />
        </button>
      </div>
    </transition-group>
  </div>
</template>

<script setup>
import { useToast } from '~/composables/useToast'

const { toasts } = useToast()

const bgMap = {
  success: 'bg-green-600',
  error: 'bg-red-600',
  warning: 'bg-yellow-600',
}

const iconMap = {
  success: 'check-circle',
  error: 'alert-triangle',
  warning: 'alert-triangle',
}

const dismiss = (id) => {
  toasts.value = toasts.value.filter(t => t.id !== id)
}
</script>

<style scoped>
.toast-enter-active { transition: all 0.3s ease-out; }
.toast-leave-active { transition: all 0.2s ease-in; }
.toast-enter-from { opacity: 0; transform: translateX(40px); }
.toast-leave-to { opacity: 0; transform: translateX(40px); }
</style>
