<template>
  <div class="space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-800">📦 Products</h2>
        <p class="text-gray-400 text-sm mt-1">Manage your product inventory</p>
      </div>
      <button
        @click="showAddModal = true"
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-medium transition-all flex items-center gap-2"
      >
        <span>+</span> Add Product
      </button>
    </div>

    <!-- Stats Row -->
    <div class="grid grid-cols-3 gap-4">
      <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-3">
        <div class="bg-blue-100 p-3 rounded-xl text-2xl">📦</div>
        <div>
          <p class="text-gray-400 text-xs">Total Products</p>
          <p class="text-xl font-bold text-gray-800">{{ products.length }}</p>
        </div>
      </div>
      <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-3">
        <div class="bg-green-100 p-3 rounded-xl text-2xl">✅</div>
        <div>
          <p class="text-gray-400 text-xs">In Stock</p>
          <p class="text-xl font-bold text-gray-800">{{ inStockCount }}</p>
        </div>
      </div>
      <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center gap-3">
        <div class="bg-red-100 p-3 rounded-xl text-2xl">⚠️</div>
        <div>
          <p class="text-gray-400 text-xs">Low Stock</p>
          <p class="text-xl font-bold text-gray-800">{{ lowStockCount }}</p>
        </div>
      </div>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-2xl shadow-sm p-4">
      <input
        v-model="search"
        type="text"
        placeholder="🔍 Search products..."
        class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 text-gray-700"
      />
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
      <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-100">
          <tr class="text-left text-gray-500">
            <th class="px-6 py-4 font-semibold">#</th>
            <th class="px-6 py-4 font-semibold">Product Name</th>
            <th class="px-6 py-4 font-semibold">Description</th>
            <th class="px-6 py-4 font-semibold">Price</th>
            <th class="px-6 py-4 font-semibold">Stock</th>
            <th class="px-6 py-4 font-semibold">Status</th>
            <th class="px-6 py-4 font-semibold">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(product, index) in filteredProducts"
            :key="product.id"
            class="border-b border-gray-50 hover:bg-gray-50 transition-all"
          >
            <td class="px-6 py-4 text-gray-400">{{ index + 1 }}</td>
            <td class="px-6 py-4 font-semibold text-gray-800">{{ product.name }}</td>
            <td class="px-6 py-4 text-gray-500">{{ product.description }}</td>
            <td class="px-6 py-4 font-semibold text-gray-800">₱{{ product.price.toLocaleString() }}</td>
            <td class="px-6 py-4 font-semibold text-gray-800">{{ product.stock }}</td>
            <td class="px-6 py-4">
              <span :class="stockStatusClass(product.stock)"
                class="px-3 py-1 rounded-full text-xs font-semibold">
                {{ stockStatusLabel(product.stock) }}
              </span>
            </td>
            <td class="px-6 py-4">
              <div class="flex items-center gap-2">
                <button
                  @click="editProduct(product)"
                  class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-3 py-1.5 rounded-lg text-xs font-medium transition-all"
                >
                  ✏️ Edit
                </button>
                <button
                  @click="deleteProduct(product.id)"
                  class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-1.5 rounded-lg text-xs font-medium transition-all"
                >
                  🗑️ Delete
                </button>
              </div>
            </td>
          </tr>

          <!-- Empty State -->
          <tr v-if="filteredProducts.length === 0">
            <td colspan="7" class="px-6 py-16 text-center text-gray-400">
              <div class="text-5xl mb-3">📦</div>
              <p>No products found</p>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Add/Edit Modal -->
    <div v-if="showAddModal || showEditModal"
      class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
      <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md mx-4">

        <h3 class="text-xl font-bold text-gray-800 mb-6">
          {{ showEditModal ? '✏️ Edit Product' : '➕ Add Product' }}
        </h3>

        <div class="space-y-4">
          <div>
            <label class="text-sm font-medium text-gray-600 mb-1 block">Product Name</label>
            <input
              v-model="form.name"
              type="text"
              placeholder="Enter product name"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-400"
            />
          </div>
          <div>
            <label class="text-sm font-medium text-gray-600 mb-1 block">Description</label>
            <input
              v-model="form.description"
              type="text"
              placeholder="Enter description"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-400"
            />
          </div>
          <div>
            <label class="text-sm font-medium text-gray-600 mb-1 block">Price (₱)</label>
            <input
              v-model="form.price"
              type="number"
              placeholder="0.00"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-400"
            />
          </div>
          <div>
            <label class="text-sm font-medium text-gray-600 mb-1 block">Stock Quantity</label>
            <input
              v-model="form.stock"
              type="number"
              placeholder="0"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-400"
            />
          </div>
        </div>

        <div class="flex gap-3 mt-6">
          <button
            @click="closeModal"
            class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition-all font-medium"
          >
            Cancel
          </button>
          <button
            @click="saveProduct"
            class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all font-medium"
          >
            {{ showEditModal ? 'Update' : 'Add Product' }}
          </button>
        </div>

      </div>
    </div>

  </div>
</template>

<script setup>
definePageMeta({ layout: 'default' })

const search = ref('')
const showAddModal = ref(false)
const showEditModal = ref(false)
const editingId = ref(null)

const form = ref({
  name: '',
  description: '',
  price: '',
  stock: '',
})

const products = ref([
  { id: 1, name: 'Laptop Stand', description: 'Adjustable aluminum stand', price: 1200, stock: 5 },
  { id: 2, name: 'Mechanical Keyboard', description: 'RGB backlit, tactile switches', price: 3500, stock: 23 },
  { id: 3, name: 'USB-C Hub', description: '7-in-1 multiport adapter', price: 1800, stock: 8 },
  { id: 4, name: 'Webcam HD', description: '1080p with built-in mic', price: 2500, stock: 35 },
  { id: 5, name: 'Mouse Pad XL', description: 'Extra large desk mat', price: 650, stock: 42 },
  { id: 6, name: 'Monitor Light', description: 'USB powered screen bar', price: 1900, stock: 0 },
])

const filteredProducts = computed(() =>
  products.value.filter(p =>
    p.name.toLowerCase().includes(search.value.toLowerCase())
  )
)

const inStockCount = computed(() =>
  products.value.filter(p => p.stock > 10).length
)

const lowStockCount = computed(() =>
  products.value.filter(p => p.stock <= 10).length
)

const stockStatusClass = (stock) => {
  if (stock === 0) return 'bg-red-100 text-red-700'
  if (stock <= 10) return 'bg-yellow-100 text-yellow-700'
  return 'bg-green-100 text-green-700'
}

const stockStatusLabel = (stock) => {
  if (stock === 0) return 'Out of Stock'
  if (stock <= 10) return 'Low Stock'
  return 'In Stock'
}

const editProduct = (product) => {
  editingId.value = product.id
  form.value = { ...product }
  showEditModal.value = true
}

const deleteProduct = (id) => {
  products.value = products.value.filter(p => p.id !== id)
}

const saveProduct = () => {
  if (showEditModal.value) {
    const index = products.value.findIndex(p => p.id === editingId.value)
    products.value[index] = { ...form.value, id: editingId.value }
  } else {
    products.value.push({
      id: Date.now(),
      name: form.value.name,
      description: form.value.description,
      price: Number(form.value.price),
      stock: Number(form.value.stock),
    })
  }
  closeModal()
}

const closeModal = () => {
  showAddModal.value = false
  showEditModal.value = false
  editingId.value = null
  form.value = { name: '', description: '', price: '', stock: '' }
}
</script>