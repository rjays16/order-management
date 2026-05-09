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
      <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-3">
        <div class="bg-blue-100 p-3 rounded-xl text-2xl">📋</div>
        <div>
          <p class="text-gray-400 text-xs">Total Logs</p>
          <p class="text-xl font-bold text-gray-800">{{ logs.length }}</p>
        </div>
      </div>
      <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-3">
        <div class="bg-green-100 p-3 rounded-xl text-2xl">➕</div>
        <div>
          <p class="text-gray-400 text-xs">Additions</p>
          <p class="text-xl font-bold text-gray-800">{{ addCount }}</p>
        </div>
      </div>
      <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-3">
        <div class="bg-red-100 p-3 rounded-xl text-2xl">➖</div>
        <div>
          <p class="text-gray-400 text-xs">Deductions</p>
          <p class="text-xl font-bold text-gray-800">{{ deductCount }}</p>
        </div>
      </div>
      <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-3">
        <div class="bg-yellow-100 p-3 rounded-xl text-2xl">🔄</div>
        <div>
          <p class="text-gray-400 text-xs">Restores</p>
          <p class="text-xl font-bold text-gray-800">{{ restoreCount }}</p>
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
            <div :class="logIconClass(log.type)"
              class="w-12 h-12 rounded-full flex items-center justify-center text-white text-lg flex-shrink-0 z-10 shadow-md">
              {{ logIcon(log.type) }}
            </div>

            <!-- Content -->
            <div class="flex-1 bg-gray-50 rounded-2xl p-4 hover:bg-gray-100 transition-all">
              <div class="flex items-start justify-between">
                <div>
                  <p class="text-gray-800 font-semibold text-sm">{{ log.message }}</p>
                  <p class="text-gray-500 text-xs mt-1">{{ log.detail }}</p>
                </div>
                <div class="text-right flex-shrink-0 ml-4">
                  <span :class="logBadgeClass(log.type)"
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

const activeTab = ref('All')

const tabs = [
  { label: 'All', value: 'All' },
  { label: '➕ Addition', value: 'add' },
  { label: '➖ Deduction', value: 'deduct' },
  { label: '🔄 Restore', value: 'restore' },
  { label: '🛒 Order', value: 'order' },
]

const logs = ref([
  {
    id: 1,
    type: 'order',
    message: 'Order ORD-001 confirmed',
    detail: 'Inventory deducted: Laptop Stand x1',
    time: '2 hours ago',
  },
  {
    id: 2,
    type: 'deduct',
    message: 'Inventory deducted — Laptop Stand',
    detail: 'Quantity changed: -1 unit (Stock: 6 → 5)',
    time: '2 hours ago',
  },
  {
    id: 3,
    type: 'add',
    message: 'Inventory added — Mechanical Keyboard',
    detail: 'Quantity changed: +20 units (Stock: 3 → 23)',
    time: '4 hours ago',
  },
  {
    id: 4,
    type: 'order',
    message: 'Order ORD-004 cancelled',
    detail: 'Inventory restored: Mouse Pad XL x1',
    time: '5 hours ago',
  },
  {
    id: 5,
    type: 'restore',
    message: 'Inventory restored — Mouse Pad XL',
    detail: 'Quantity changed: +1 unit (Stock: 41 → 42)',
    time: '5 hours ago',
  },
  {
    id: 6,
    type: 'order',
    message: 'New order ORD-005 created',
    detail: 'Items: Webcam HD x1 — Total: ₱2,100',
    time: '1 day ago',
  },
  {
    id: 7,
    type: 'add',
    message: 'Inventory added — Webcam HD',
    detail: 'Quantity changed: +10 units (Stock: 25 → 35)',
    time: '1 day ago',
  },
  {
    id: 8,
    type: 'deduct',
    message: 'Inventory deducted — USB-C Hub',
    detail: 'Quantity changed: -2 units (Stock: 10 → 8)',
    time: '2 days ago',
  },
])

const filteredLogs = computed(() => {
  if (activeTab.value === 'All') return logs.value
  return logs.value.filter(l => l.type === activeTab.value)
})

const addCount = computed(() => logs.value.filter(l => l.type === 'add').length)
const deductCount = computed(() => logs.value.filter(l => l.type === 'deduct').length)
const restoreCount = computed(() => logs.value.filter(l => l.type === 'restore').length)

const logIcon = (type) => {
  const icons = {
    add: '➕',
    deduct: '➖',
    restore: '🔄',
    order: '🛒',
  }
  return icons[type] || '📋'
}

const logIconClass = (type) => {
  const classes = {
    add: 'bg-green-500',
    deduct: 'bg-red-500',
    restore: 'bg-yellow-500',
    order: 'bg-blue-500',
  }
  return classes[type] || 'bg-gray-500'
}

const logBadgeClass = (type) => {
  const classes = {
    add: 'bg-green-100 text-green-700',
    deduct: 'bg-red-100 text-red-700',
    restore: 'bg-yellow-100 text-yellow-700',
    order: 'bg-blue-100 text-blue-700',
  }
  return classes[type] || 'bg-gray-100 text-gray-700'
}
</script>