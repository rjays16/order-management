<template>
  <div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-800">📋 Activity Logs</h2>
        <p class="text-gray-400 text-sm mt-1">Track all inventory and order activities</p>
      </div>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-4 gap-4">
      <div
        v-for="stat in stats"
        :key="stat.label"
        class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-3"
      >
        <div :class="stat.bg" class="p-3 rounded-xl text-2xl">{{ stat.icon }}</div>
        <div>
          <p class="text-gray-400 text-xs">{{ stat.label }}</p>
          <p class="text-xl font-bold text-gray-800">{{ stat.count }}</p>
        </div>
      </div>
    </div>

    <!-- Filter Tabs -->
    <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-3">
      <button
        v-for="tab in tabs"
        :key="tab.value"
        @click="activeTab = tab.value"
        :class="activeTab === tab.value
          ? 'bg-blue-600 text-white'
          : 'bg-gray-100 text-gray-600 hover:bg-gray-200'"
        class="px-4 py-2 rounded-xl text-sm font-medium transition-all"
      >
        {{ tab.label }}
      </button>
    </div>

    <!-- Timeline -->
    <div class="bg-white rounded-2xl shadow-sm p-6">
      <div class="relative">

        <!-- Timeline Line -->
        <div class="absolute left-6 top-0 bottom-0 w-0.5 bg-gray-100"></div>

        <!-- Log Items -->
        <div class="space-y-6">
          <div
            v-for="log in filteredLogs"
            :key="log.id"
            class="flex items-start gap-4 relative"
          >
            <!-- Icon -->
            <div :class="config(log.type).dotClass"
              class="w-12 h-12 rounded-full flex items-center justify-center text-white text-lg flex-shrink-0 z-10 shadow-md">
              {{ config(log.type).icon }}
            </div>

            <!-- Content -->
            <div class="flex-1 bg-gray-50 rounded-2xl p-4 hover:bg-gray-100 transition-all">
              <div class="flex items-start justify-between">
                <div>
                  <p class="text-gray-800 font-semibold text-sm">{{ log.message }}</p>
                  <p class="text-gray-500 text-xs mt-1">{{ log.detail }}</p>
                </div>
                <div class="text-right flex-shrink-0 ml-4">
                  <span :class="config(log.type).badgeClass"
                    class="px-2 py-1 rounded-full text-xs font-semibold">
                    {{ log.type }}
                  </span>
                  <p class="text-gray-400 text-xs mt-1">{{ log.time }}</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Empty State -->
          <div v-if="filteredLogs.length === 0" class="text-center py-16 text-gray-400">
            <div class="text-5xl mb-3">📋</div>
            <p>No logs found</p>
          </div>

        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
definePageMeta({ layout: 'default' })

const LOG_TYPES = {
  add:    { icon: '➕', label: 'Addition',   dotClass: 'bg-green-500', badgeClass: 'bg-green-100 text-green-700', statBg: 'bg-green-100' },
  deduct: { icon: '➖', label: 'Deduction',  dotClass: 'bg-red-500', badgeClass: 'bg-red-100 text-red-700', statBg: 'bg-red-100' },
  restore: { icon: '🔄', label: 'Restore',   dotClass: 'bg-yellow-500', badgeClass: 'bg-yellow-100 text-yellow-700', statBg: 'bg-yellow-100' },
  order:  { icon: '🛒', label: 'Order',     dotClass: 'bg-blue-500', badgeClass: 'bg-blue-100 text-blue-700', statBg: 'bg-blue-100' },
}

const config = (type) => LOG_TYPES[type] || { icon: '📋', dotClass: 'bg-gray-500', badgeClass: 'bg-gray-100 text-gray-700', statBg: 'bg-gray-100' }

const activeTab = ref('All')

const tabs = [
  { label: 'All', value: 'All' },
  ...Object.entries(LOG_TYPES).map(([value, t]) => ({ label: `${t.icon} ${t.label || value}`, value }))
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