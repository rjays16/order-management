<template>
  <div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-800">🛒 Orders</h2>
        <p class="text-gray-400 text-sm mt-1">Manage your orders</p>
      </div>
      <button
        @click="showCreateModal = true"
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition-all flex items-center gap-2"
      >
        <span>+</span> Create Order
      </button>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-4 gap-4">
      <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-3">
        <div class="bg-blue-100 p-3 rounded-xl text-2xl">🛒</div>
        <div>
          <p class="text-gray-400 text-xs">Total Orders</p>
          <p class="text-xl font-bold text-gray-800">{{ orders.length }}</p>
        </div>
      </div>
      <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-3">
        <div class="bg-yellow-100 p-3 rounded-xl text-2xl">⏳</div>
        <div>
          <p class="text-gray-400 text-xs">Pending</p>
          <p class="text-xl font-bold text-gray-800">{{ pendingCount }}</p>
        </div>
      </div>
      <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-3">
        <div class="bg-green-100 p-3 rounded-xl text-2xl">✅</div>
        <div>
          <p class="text-gray-400 text-xs">Confirmed</p>
          <p class="text-xl font-bold text-gray-800">{{ confirmedCount }}</p>
        </div>
      </div>
      <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-3">
        <div class="bg-red-100 p-3 rounded-xl text-2xl">❌</div>
        <div>
          <p class="text-gray-400 text-xs">Cancelled</p>
          <p class="text-xl font-bold text-gray-800">{{ cancelledCount }}</p>
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

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
      <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
          <tr class="text-left text-gray-500">
            <th class="px-6 py-4 font-semibold">Order #</th>
            <th class="px-6 py-4 font-semibold">Date</th>
            <th class="px-6 py-4 font-semibold">Items</th>
            <th class="px-6 py-4 font-semibold">Total</th>
            <th class="px-6 py-4 font-semibold">Status</th>
            <th class="px-6 py-4 font-semibold">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="order in filteredOrders"
            :key="order.id"
            class="border-b border-gray-50 hover:bg-gray-50 transition-all"
          >
            <td class="px-6 py-4 font-semibold text-blue-600">{{ order.number }}</td>
            <td class="px-6 py-4 text-gray-500">{{ order.date }}</td>
            <td class="px-6 py-4 text-gray-600">{{ order.items.length }} item(s)</td>
            <td class="px-6 py-4 font-semibold text-gray-800">₱{{ order.total.toLocaleString() }}</td>
            <td class="px-6 py-4">
              <span :class="statusClass(order.status)"
                class="px-3 py-1 rounded-full text-xs font-semibold">
                {{ order.status }}
              </span>
            </td>
            <td class="px-6 py-4">
              <div class="flex items-center gap-2">
                <button
                  @click="viewOrder(order)"
                  class="bg-blue-100 hover:bg-blue-200 text-blue-700 px-3 py-1.5 rounded-lg text-xs font-medium transition-all"
                >
                  👁️ View
                </button>
                <button
                  v-if="order.status === 'Pending'"
                  @click="confirmOrder(order.id)"
                  class="bg-green-100 hover:bg-green-200 text-green-700 px-3 py-1.5 rounded-lg text-xs font-medium transition-all"
                >
                  ✅ Confirm
                </button>
                <button
                  v-if="order.status !== 'Cancelled'"
                  @click="cancelOrder(order.id)"
                  class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1.5 rounded-lg text-xs font-medium transition-all"
                >
                  ❌ Cancel
                </button>
              </div>
            </td>
          </tr>

          <!-- Empty State -->
          <tr v-if="filteredOrders.length === 0">
            <td colspan="6" class="px-6 py-16 text-center text-gray-400">
              <div class="text-5xl mb-3">🛒</div>
              <p>No orders found</p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- View Order Modal -->
    <div v-if="showViewModal"
      class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
      <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-lg mx-4">
        <div class="flex items-center justify-between mb-6">
          <h3 class="text-xl font-bold text-gray-800">🛒 {{ selectedOrder?.number }}</h3>
          <span :class="statusClass(selectedOrder?.status)"
            class="px-3 py-1 rounded-full text-xs font-semibold">
            {{ selectedOrder?.status }}
          </span>
        </div>

        <div class="space-y-3 mb-6">
          <div class="flex justify-between text-sm">
            <span class="text-gray-400">Date</span>
            <span class="text-gray-700 font-medium">{{ selectedOrder?.date }}</span>
          </div>
        </div>

        <!-- Order Items -->
        <div class="border border-gray-100 rounded-xl overflow-hidden mb-6">
          <table class="w-full text-sm">
            <thead class="bg-gray-50">
              <tr class="text-left text-gray-500">
                <th class="px-4 py-3 font-semibold">Product</th>
                <th class="px-4 py-3 font-semibold">Qty</th>
                <th class="px-4 py-3 font-semibold">Price</th>
                <th class="px-4 py-3 font-semibold">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in selectedOrder?.items" :key="item.id"
                class="border-t border-gray-50">
                <td class="px-4 py-3 text-gray-700">{{ item.name }}</td>
                <td class="px-4 py-3 text-gray-600">{{ item.qty }}</td>
                <td class="px-4 py-3 text-gray-600">₱{{ item.price.toLocaleString() }}</td>
                <td class="px-4 py-3 font-semibold text-gray-800">₱{{ (item.qty * item.price).toLocaleString() }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="flex justify-between items-center mb-6">
          <span class="font-bold text-gray-700">Total Amount</span>
          <span class="text-xl font-bold text-blue-600">₱{{ selectedOrder?.total.toLocaleString() }}</span>
        </div>

        <button
          @click="showViewModal = false"
          class="w-full px-4 py-2.5 bg-gray-100 text-gray-600 rounded-xl hover:bg-gray-200 transition-all font-medium"
        >
          Close
        </button>
      </div>
    </div>

    <!-- Create Order Modal -->
    <div v-if="showCreateModal"
      class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
      <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-lg mx-4">
        <h3 class="text-xl font-bold text-gray-800 mb-6">➕ Create New Order</h3>

        <!-- Product Selector -->
        <div class="space-y-4 mb-6">
          <div v-for="(item, index) in newOrderItems" :key="index"
            class="flex items-center gap-3">
            <select
              v-model="item.productId"
              class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 text-gray-700"
            >
              <option value="">Select product</option>
              <option v-for="p in availableProducts" :key="p.id" :value="p.id">
                {{ p.name }} — ₱{{ p.price.toLocaleString() }}
              </option>
            </select>
            <input
              v-model="item.qty"
              type="number"
              min="1"
              placeholder="Qty"
              class="w-20 px-3 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 text-center"
            />
            <button
              @click="removeItem(index)"
              class="text-red-400 hover:text-red-600 text-lg"
            >✕</button>
          </div>
        </div>

        <button
          @click="addItem"
          class="w-full py-2.5 border-2 border-dashed border-gray-200 rounded-xl text-gray-400 hover:border-blue-400 hover:text-blue-500 transition-all text-sm mb-6"
        >
          + Add Item
        </button>

        <!-- Order Total -->
        <div class="flex justify-between items-center bg-gray-50 rounded-xl px-4 py-3 mb-6">
          <span class="font-semibold text-gray-700">Total</span>
          <span class="text-xl font-bold text-blue-600">₱{{ newOrderTotal.toLocaleString() }}</span>
        </div>

        <div class="flex gap-3">
          <button
            @click="showCreateModal = false"
            class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition-all font-medium"
          >
            Cancel
          </button>
          <button
            @click="createOrder"
            class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all font-medium"
          >
            Create Order
          </button>
        </div>
      </div>
    </div>

  </div>
</template>

<script setup>
definePageMeta({ layout: 'default' })

const activeTab = ref('All')
const showViewModal = ref(false)
const showCreateModal = ref(false)
const selectedOrder = ref(null)

const tabs = [
  { label: 'All', value: 'All' },
  { label: '⏳ Pending', value: 'Pending' },
  { label: '✅ Confirmed', value: 'Confirmed' },
  { label: '❌ Cancelled', value: 'Cancelled' },
]

const orders = ref([
  {
    id: 1, number: 'ORD-001', date: 'May 9, 2026', status: 'Confirmed', total: 1200,
    items: [{ id: 1, name: 'Laptop Stand', qty: 1, price: 1200 }]
  },
  {
    id: 2, number: 'ORD-002', date: 'May 9, 2026', status: 'Pending', total: 850,
    items: [{ id: 1, name: 'Mouse Pad XL', qty: 1, price: 650 }, { id: 2, name: 'USB-C Hub', qty: 1, price: 200 }]
  },
  {
    id: 3, number: 'ORD-003', date: 'May 8, 2026', status: 'Confirmed', total: 3400,
    items: [{ id: 1, name: 'Mechanical Keyboard', qty: 1, price: 3500 }]
  },
  {
    id: 4, number: 'ORD-004', date: 'May 8, 2026', status: 'Cancelled', total: 620,
    items: [{ id: 1, name: 'Mouse Pad XL', qty: 1, price: 650 }]
  },
  {
    id: 5, number: 'ORD-005', date: 'May 7, 2026', status: 'Pending', total: 2100,
    items: [{ id: 1, name: 'Webcam HD', qty: 1, price: 2500 }]
  },
])

const availableProducts = [
  { id: 1, name: 'Laptop Stand', price: 1200 },
  { id: 2, name: 'Mechanical Keyboard', price: 3500 },
  { id: 3, name: 'USB-C Hub', price: 1800 },
  { id: 4, name: 'Webcam HD', price: 2500 },
  { id: 5, name: 'Mouse Pad XL', price: 650 },
]

const newOrderItems = ref([{ productId: '', qty: 1 }])

const newOrderTotal = computed(() => {
  return newOrderItems.value.reduce((sum, item) => {
    const product = availableProducts.find(p => p.id === item.productId)
    return sum + (product ? product.price * item.qty : 0)
  }, 0)
})

const filteredOrders = computed(() => {
  if (activeTab.value === 'All') return orders.value
  return orders.value.filter(o => o.status === activeTab.value)
})

const pendingCount = computed(() => orders.value.filter(o => o.status === 'Pending').length)
const confirmedCount = computed(() => orders.value.filter(o => o.status === 'Confirmed').length)
const cancelledCount = computed(() => orders.value.filter(o => o.status === 'Cancelled').length)

const statusClass = (status) => {
  const classes = {
    'Confirmed': 'bg-green-100 text-green-700',
    'Pending': 'bg-yellow-100 text-yellow-700',
    'Cancelled': 'bg-red-100 text-red-700',
  }
  return classes[status] || 'bg-gray-100 text-gray-700'
}

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

const addItem = () => {
  newOrderItems.value.push({ productId: '', qty: 1 })
}

const removeItem = (index) => {
  newOrderItems.value.splice(index, 1)
}

const createOrder = () => {
  const newOrder = {
    id: Date.now(),
    number: `ORD-00${orders.value.length + 1}`,
    date: new Date().toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' }),
    status: 'Pending',
    total: newOrderTotal.value,
    items: newOrderItems.value
      .filter(item => item.productId)
      .map(item => {
        const product = availableProducts.find(p => p.id === item.productId)
        return { id: item.productId, name: product.name, qty: item.qty, price: product.price }
      })
  }
  orders.value.unshift(newOrder)
  newOrderItems.value = [{ productId: '', qty: 1 }]
  showCreateModal.value = false
}
</script>