<template>
  <div v-if="show"
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-lg mx-4">
      <h3 class="text-xl font-bold text-gray-800 mb-6">➕ Create New Order</h3>

      <div class="space-y-4 mb-6">
        <div v-for="(item, index) in items" :key="index"
          class="flex items-center gap-3">
          <select
            v-model="item.productId"
            class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-400 text-gray-700"
          >
            <option value="">Select product</option>
            <option v-for="p in products" :key="p.id" :value="p.id">
              {{ p.name }} — ₱{{ p.price.toLocaleString() }}
            </option>
          </select>
          <input
            v-model.number="item.qty"
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
      >+ Add Item</button>

      <div class="flex justify-between items-center bg-gray-50 rounded-xl px-4 py-3 mb-6">
        <span class="font-semibold text-gray-700">Total</span>
        <span class="text-xl font-bold text-blue-600">₱{{ total.toLocaleString() }}</span>
      </div>

      <div class="flex gap-3">
        <button
          @click="$emit('close')"
          class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition-all font-medium"
        >Cancel</button>
        <button
          @click="submit"
          class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all font-medium"
        >Create Order</button>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  show: { type: Boolean, required: true },
  products: { type: Array, required: true },
})

const emit = defineEmits(['close', 'create'])

const items = ref([{ productId: '', qty: 1 }])

const total = computed(() =>
  items.value.reduce((sum, item) => {
    const product = props.products.find(p => p.id === item.productId)
    return sum + (product ? product.price * (item.qty || 0) : 0)
  }, 0)
)

const addItem = () => items.value.push({ productId: '', qty: 1 })
const removeItem = (index) => items.value.splice(index, 1)

const submit = () => {
  emit('create', items.value.filter(i => i.productId))
  items.value = [{ productId: '', qty: 1 }]
}
</script>
