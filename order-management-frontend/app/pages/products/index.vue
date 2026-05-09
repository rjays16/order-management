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
import ProductFormModal from '~/components/products/ProductFormModal.vue'

definePageMeta({ layout: 'default' })

const { get, post, put, del } = useApi()
const toast = useToast()

const search = ref('')
const showAddModal = ref(false)
const showEditModal = ref(false)
const editingId = ref(null)
const form = ref({ name: '', description: '', price: '', stock: '' })
const products = ref([])

onMounted(async () => {
  try {
    const res = await get('/products')
    products.value = res?.data ?? []
  } catch (e) {
    // handled by useApi
  }
})

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
  try {
    await del(`/products/${id}`)
    products.value = products.value.filter(p => p.id !== id)
    toast.success('Product deleted successfully')
  } catch (e) {
    toast.error(e.message)
  }
}

const saveProduct = async (data) => {
  try {
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
      toast.success('Product updated successfully')
    } else {
      const res = await post('/products', payload)
      products.value.push(res.data)
      toast.success('Product added successfully')
    }
    closeModal()
  } catch (e) {
    toast.error(e.message)
  }
}

const closeModal = () => {
  showAddModal.value = false
  showEditModal.value = false
  editingId.value = null
}
</script>
