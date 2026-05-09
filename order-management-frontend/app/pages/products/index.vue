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
import { stockStatus } from '~/utils/products/productStorage'

definePageMeta({ layout: 'default' })

const { get, post, put, del } = useApi()

const search = ref('')
const showAddModal = ref(false)
const showEditModal = ref(false)
const editingId = ref(null)
const form = ref({ name: '', description: '', price: '', stock: '' })
const products = ref([])

const { data: productsData } = await useAsyncData('products', () => get('/products'))

watch(productsData, (val) => { products.value = val?.data ?? [] }, { immediate: true })

const filteredProducts = computed(() =>
  products.value.filter(p =>
    p.name.toLowerCase().includes(search.value.toLowerCase())
  )
)

const stats = computed(() => [
  { icon: 'package', bg: 'bg-blue-100', label: 'Total Products', count: products.value.length },
  { icon: 'check-circle', bg: 'bg-green-100', label: 'In Stock', count: products.value.filter(p => p.stock > 10).length },
  { icon: 'alert-triangle', bg: 'bg-red-100', label: 'Low Stock', count: products.value.filter(p => p.stock <= 10).length },
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

const deleteProduct = async (id) => {
  await del(`/products/${id}`)
  products.value = products.value.filter(p => p.id !== id)
}

const saveProduct = async (data) => {
  const payload = {
    name: data.name,
    description: data.description,
    price: Number(data.price),
    stock: Number(data.stock),
  }

  if (showEditModal.value) {
    const res = await put(`/products/${editingId.value}`, payload)
    const idx = products.value.findIndex(p => p.id === editingId.value)
    if (idx !== -1) products.value[idx] = res.data
  } else {
    const res = await post('/products', payload)
    products.value.push(res.data)
  }
  closeModal()
}

const closeModal = () => {
  showAddModal.value = false
  showEditModal.value = false
  editingId.value = null
}
</script>
