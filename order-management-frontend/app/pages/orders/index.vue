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
      @cancel-item="cancelOrderItem"
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
const toast = useToast()

const activeTab = ref('All')
const showViewModal = ref(false)
const showCreateModal = ref(false)
const selectedOrder = ref(null)
const orders = ref([])
const productList = ref([])

onMounted(async () => {
  try {
    const [ordRes, prodRes] = await Promise.all([
      get('/orders'),
      get('/products'),
    ])
    orders.value = ordRes?.data ?? []
    productList.value = (prodRes?.data ?? []).map(p => ({ id: p.id, name: p.name, price: p.price }))
  } catch (e) {
    // handled by useApi
  }
})

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
  try {
    const res = await put(`/orders/${id}/confirm`)
    const idx = orders.value.findIndex(o => o.id === id)
    if (idx !== -1) orders.value[idx] = res.data
    toast.success('Order confirmed successfully')
  } catch (e) {
    toast.error(e.message)
  }
}

const cancelOrder = async (id) => {
  try {
    const res = await put(`/orders/${id}/cancel`)
    const idx = orders.value.findIndex(o => o.id === id)
    if (idx !== -1) orders.value[idx] = res.data
    toast.success('Order cancelled successfully')
  } catch (e) {
    toast.error(e.message)
  }
}

const cancelOrderItem = async (itemId) => {
  try {
    const res = await put(`/orders/${selectedOrder.value.id}/cancel-item`, { item_id: itemId })
    const idx = orders.value.findIndex(o => o.id === selectedOrder.value.id)
    if (idx !== -1) orders.value[idx] = res.data
    selectedOrder.value = res.data
    toast.success('Item cancelled successfully')
  } catch (e) {
    toast.error(e.message)
  }
}

const createOrder = async (items) => {
  try {
    const payload = { items: items.map(i => ({ product_id: i.productId, qty: i.qty })) }
    const res = await post('/orders', payload)
    orders.value.unshift(res.data)
    showCreateModal.value = false
    toast.success('Order created successfully')
  } catch (e) {
    toast.error(e.message)
  }
}
</script>
