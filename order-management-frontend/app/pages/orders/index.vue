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
      :products="productList"
      @create="createOrder"
      @close="showCreateModal = false"
    />
  </div>
</template>

<script setup>
import { ORDER_STATUS, TABS } from '~/utils/orders/orderStatus'
import OrderViewModal from '~/components/orders/OrderViewModal.vue'
import OrderCreateModal from '~/components/orders/OrderCreateModal.vue'

definePageMeta({ layout: 'default' })

const { get, post, put } = useApi()

const activeTab = ref('All')
const showViewModal = ref(false)
const showCreateModal = ref(false)
const selectedOrder = ref(null)
const orders = ref([])
const productList = ref([])

const { data: ordersData } = await useAsyncData('orders', () => get('/orders'))
const { data: productsData } = await useAsyncData('order-products', () => get('/products'))

watch(ordersData, (val) => { orders.value = val?.data ?? [] }, { immediate: true })
watch(productsData, (val) => {
  productList.value = (val?.data ?? []).map(p => ({ id: p.id, name: p.name, price: p.price }))
}, { immediate: true })

const filteredOrders = computed(() =>
  activeTab.value === 'All' ? orders.value : orders.value.filter(o => o.status === activeTab.value)
)

const stats = computed(() => [
  { icon: 'shopping-cart', bg: 'bg-blue-100', label: 'Total Orders', count: orders.value.length },
  { icon: ORDER_STATUS.Pending.icon, bg: ORDER_STATUS.Pending.statBg, label: 'Pending', count: orders.value.filter(o => o.status === 'Pending').length },
  { icon: ORDER_STATUS.Confirmed.icon, bg: ORDER_STATUS.Confirmed.statBg, label: 'Confirmed', count: orders.value.filter(o => o.status === 'Confirmed').length },
  { icon: ORDER_STATUS.Cancelled.icon, bg: ORDER_STATUS.Cancelled.statBg, label: 'Cancelled', count: orders.value.filter(o => o.status === 'Cancelled').length },
])

const viewOrder = (order) => {
  selectedOrder.value = order
  showViewModal.value = true
}

const confirmOrder = async (id) => {
  const res = await put(`/orders/${id}/confirm`)
  const idx = orders.value.findIndex(o => o.id === id)
  if (idx !== -1) orders.value[idx] = res.data
}

const cancelOrder = async (id) => {
  const res = await put(`/orders/${id}/cancel`)
  const idx = orders.value.findIndex(o => o.id === id)
  if (idx !== -1) orders.value[idx] = res.data
}

const createOrder = async (items) => {
  const payload = { items: items.map(i => ({ product_id: i.productId, qty: i.qty })) }
  const res = await post('/orders', payload)
  orders.value.unshift(res.data)
  showCreateModal.value = false
}
</script>
