<template>
  <div class="space-y-6">
    <LogsHeader />
    <LogsStats :stats="stats" />
    <LogsFilters v-model:activeTab="activeTab" :tabs="tabs" />
    <LogsTimeline :logs="filteredLogs" />
  </div>
</template>

<script setup>
import { LOG_TYPES } from '~/utils/logs/logTypes'

definePageMeta({ layout: 'default' })

const activeTab = ref('All')

const tabs = [
  { label: 'All', value: 'All' },
  ...Object.entries(LOG_TYPES).map(([value, t]) => ({ label: `${t.icon} ${t.label}`, value }))
]

const logs = ref([
  { id: 1, type: 'order',  message: 'Order ORD-001 confirmed',                     detail: 'Inventory deducted: Laptop Stand x1',          time: '2 hours ago' },
  { id: 2, type: 'deduct', message: 'Inventory deducted — Laptop Stand',           detail: 'Quantity changed: -1 unit (Stock: 6 → 5)',      time: '2 hours ago' },
  { id: 3, type: 'add',    message: 'Inventory added — Mechanical Keyboard',       detail: 'Quantity changed: +20 units (Stock: 3 → 23)',   time: '4 hours ago' },
  { id: 4, type: 'order',  message: 'Order ORD-004 cancelled',                     detail: 'Inventory restored: Mouse Pad XL x1',          time: '5 hours ago' },
  { id: 5, type: 'restore',message: 'Inventory restored — Mouse Pad XL',           detail: 'Quantity changed: +1 unit (Stock: 41 → 42)',    time: '5 hours ago' },
  { id: 6, type: 'order',  message: 'New order ORD-005 created',                   detail: 'Items: Webcam HD x1 — Total: ₱2,100',          time: '1 day ago' },
  { id: 7, type: 'add',    message: 'Inventory added — Webcam HD',                 detail: 'Quantity changed: +10 units (Stock: 25 → 35)',  time: '1 day ago' },
  { id: 8, type: 'deduct', message: 'Inventory deducted — USB-C Hub',              detail: 'Quantity changed: -2 units (Stock: 10 → 8)',    time: '2 days ago' },
])

const filteredLogs = computed(() =>
  activeTab.value === 'All' ? logs.value : logs.value.filter(l => l.type === activeTab.value)
)

const typeCounts = computed(() => {
  const counts = { add: 0, deduct: 0, restore: 0 }
  for (const log of logs.value) {
    if (log.type in counts) counts[log.type]++
  }
  return counts
})

const stats = computed(() => [
  { icon: '📋', bg: 'bg-blue-100', label: 'Total Logs', count: logs.value.length },
  { icon: LOG_TYPES.add.icon, bg: LOG_TYPES.add.statBg, label: 'Additions', count: typeCounts.value.add },
  { icon: LOG_TYPES.deduct.icon, bg: LOG_TYPES.deduct.statBg, label: 'Deductions', count: typeCounts.value.deduct },
  { icon: LOG_TYPES.restore.icon, bg: LOG_TYPES.restore.statBg, label: 'Restores', count: typeCounts.value.restore },
])
</script>