<template>
  <div class="space-y-6">
    <OrdersHeader @create="showCreateModal = true" />
    <OrdersStats :stats="stats" />
    <OrdersFilters v-model:activeTab="activeTab" :tabs="TABS" />
    <OrdersTable
      :orders="filteredOrders"
      @view="viewOrder"
      @confirm="confirmOrder"
      @cancel="cancelOrder"
    />
    <OrderViewModal
      :show="showViewModal"
      :order="selectedOrder"
      @close="showViewModal = false"
    />
    <OrderCreateModal
      :show="showCreateModal"
      :products="PRODUCTS"
      @create="createOrder"
      @close="showCreateModal = false"
    />
  </div>
</template>

<script setup>
import { ORDER_STATUS, TABS } from '~/utils/orders/orderStatus'
import { SEED_ORDERS, PRODUCTS } from '~/utils/orders/orderStorage'

definePageMeta({ layout: 'default' })

const activeTab = ref('All')
const showViewModal = ref(false)
const showCreateModal = ref(false)
const selectedOrder = ref(null)

const orders = ref(SEED_ORDERS.map(o => ({ ...o, items: [...o.items] })))

const filteredOrders = computed(() =>
  activeTab.value === 'All' ? orders.value : orders.value.filter(o => o.status === activeTab.value)
)

const stats = computed(() => [
  { icon: '🛒', bg: 'bg-blue-100', label: 'Total Orders', count: orders.value.length },
  { icon: ORDER_STATUS.Pending.icon, bg: ORDER_STATUS.Pending.statBg, label: 'Pending', count: orders.value.filter(o => o.status === 'Pending').length },
  { icon: ORDER_STATUS.Confirmed.icon, bg: ORDER_STATUS.Confirmed.statBg, label: 'Confirmed', count: orders.value.filter(o => o.status === 'Confirmed').length },
  { icon: ORDER_STATUS.Cancelled.icon, bg: ORDER_STATUS.Cancelled.statBg, label: 'Cancelled', count: orders.value.filter(o => o.status === 'Cancelled').length },
])

const viewOrder = (order) => {
  selectedOrder.value = order
  showViewModal.value = true
}

const confirmOrder = (id) => {
  const order = orders.value.find(o => o.id === id)
  if (order) order.status = 'Confirmed'
}

const cancelOrder = (id) => {
  const order = orders.value.find(o => o.id === id)
  if (order) order.status = 'Cancelled'
}

const createOrder = (items) => {
  orders.value.unshift({
    id: Date.now(),
    number: `ORD-00${orders.value.length + 1}`,
    date: new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }),
    status: 'Pending',
    total: items.reduce((sum, i) => {
      const product = PRODUCTS.find(p => p.id === i.productId)
      return sum + (product ? product.price * i.qty : 0)
    }, 0),
    items: items.map(i => {
      const product = PRODUCTS.find(p => p.id === i.productId)
      return { id: i.productId, name: product.name, qty: i.qty, price: product.price }
    }),
  })
  showCreateModal.value = false
}
</script>
