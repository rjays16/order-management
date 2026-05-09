<template>
  <div class="space-y-6">
    <DashboardStats :stats="stats" />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
      <DashboardRecentOrders :orders="recentOrders" />
      <DashboardInventory :products="inventory" />
    </div>

    <DashboardRecentActivity :logs="recentActivity" />
  </div>
</template>

<script setup>
import { logConfig } from '~/utils/logs/logTypes'

definePageMeta({ layout: 'default' })

const { get } = useApi()

const { data: dashboard } = useAsyncData('dashboard', () => get('/dashboard'))

const stats = computed(() => dashboard.value?.stats ?? [])
const recentOrders = computed(() =>
  (dashboard.value?.recentOrders?.data ?? []).map(o => ({
    id: o.id,
    number: o.number,
    date: o.date,
    amount: '₱' + o.total.toLocaleString(),
    status: o.status,
  }))
)
const inventory = computed(() =>
  (dashboard.value?.inventory ?? []).map(p => ({
    id: p.id,
    name: p.name,
    stock: p.stock,
    max: 50,
  }))
)
const recentActivity = computed(() =>
  (dashboard.value?.recentActivity?.data ?? []).map(l => {
    const cfg = logConfig(l.type)
    return {
      id: l.id,
      icon: cfg.icon,
      color: cfg.dotClass,
      message: l.message,
      time: l.time,
    }
  })
)
</script>
