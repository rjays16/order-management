<template>
  <div class="space-y-6">
    <ProductsHeader @add="openAddModal" />
    <ProductsStats :stats="stats" />
    <ProductsSearch v-model="search" />
    <ProductsTable
      :products="filteredProducts"
      @edit="editProduct"
      @delete="deleteProduct"
    />
    <ProductFormModal
      :show="showAddModal || showEditModal"
      :is-edit="showEditModal"
      :form="form"
      @save="saveProduct"
      @close="closeModal"
    />
  </div>
</template>

<script setup>
import { stockStatus, SEED_PRODUCTS } from '~/utils/products/productStorage'

definePageMeta({ layout: 'default' })

const search = ref('')
const showAddModal = ref(false)
const showEditModal = ref(false)
const editingId = ref(null)

const form = ref({ name: '', description: '', price: '', stock: '' })
const products = ref(SEED_PRODUCTS.map(p => ({ ...p })))

const filteredProducts = computed(() =>
  products.value.filter(p =>
    p.name.toLowerCase().includes(search.value.toLowerCase())
  )
)

const stats = computed(() => [
  { icon: '📦', bg: 'bg-blue-100', label: 'Total Products', count: products.value.length },
  { icon: '✅', bg: 'bg-green-100', label: 'In Stock', count: products.value.filter(p => p.stock > 10).length },
  { icon: '⚠️', bg: 'bg-red-100', label: 'Low Stock', count: products.value.filter(p => p.stock <= 10).length },
])

const openAddModal = () => {
  form.value = { name: '', description: '', price: '', stock: '' }
  showAddModal.value = true
}

const editProduct = (product) => {
  editingId.value = product.id
  form.value = { ...product }
  showEditModal.value = true
}

const deleteProduct = (id) => {
  products.value = products.value.filter(p => p.id !== id)
}

const saveProduct = (data) => {
  if (showEditModal.value) {
    const index = products.value.findIndex(p => p.id === editingId.value)
    products.value[index] = { ...data, id: editingId.value }
  } else {
    products.value.push({
      id: Date.now(),
      ...data,
      price: Number(data.price),
      stock: Number(data.stock),
    })
  }
  closeModal()
}

const closeModal = () => {
  showAddModal.value = false
  showEditModal.value = false
  editingId.value = null
}
</script>
