import { ref } from 'vue'

const toasts = ref([])
let nextId = 0

export function useToast() {
  const add = (message, type = 'success', duration = 4000) => {
    const id = ++nextId
    toasts.value.push({ id, message, type })
    setTimeout(() => {
      toasts.value = toasts.value.filter(t => t.id !== id)
    }, duration)
  }

  const success = (msg) => add(msg, 'success')
  const error = (msg) => add(msg, 'error')
  const warning = (msg) => add(msg, 'warning')

  return { toasts, add, success, error, warning }
}
