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

const { get } = useApi()

const activeTab = ref('All')
const logs = ref([])

const tabs = [
  { icon: '', label: 'All', value: 'All' },
  ...Object.entries(LOG_TYPES).map(([value, t]) => ({ icon: t.icon, label: t.label, value }))
]

const { data: logsData } = await useAsyncData('logs', () => get('/logs'))

watch(logsData, (val) => { logs.value = val?.data ?? [] }, { immediate: true })

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
  { icon: 'clipboard-list', bg: 'bg-blue-100', label: 'Total Logs', count: logs.value.length },
  { icon: LOG_TYPES.add.icon, bg: LOG_TYPES.add.statBg, label: 'Additions', count: typeCounts.value.add },
  { icon: LOG_TYPES.deduct.icon, bg: LOG_TYPES.deduct.statBg, label: 'Deductions', count: typeCounts.value.deduct },
  { icon: LOG_TYPES.restore.icon, bg: LOG_TYPES.restore.statBg, label: 'Restores', count: typeCounts.value.restore },
])
</script>
