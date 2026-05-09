<template>
  <div v-if="show"
    class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
    <div class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md mx-4">
      <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
        <Icon :name="isEdit ? 'pencil' : 'plus'" class="w-5 h-5" /> {{ isEdit ? 'Edit Product' : 'Add Product' }}
      </h3>

      <div class="space-y-4">
        <div>
          <label class="text-sm font-medium text-gray-600 mb-1 block">Product Name</label>
          <input
            v-model="localForm.name"
            type="text"
            placeholder="Enter product name"
            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-400"
          />
        </div>
        <div>
          <label class="text-sm font-medium text-gray-600 mb-1 block">Description</label>
          <input
            v-model="localForm.description"
            type="text"
            placeholder="Enter description"
            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-400"
          />
        </div>
        <div>
          <label class="text-sm font-medium text-gray-600 mb-1 block">Price (₱)</label>
          <input
            v-model="localForm.price"
            type="number"
            placeholder="0.00"
            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-400"
          />
        </div>
        <div>
          <label class="text-sm font-medium text-gray-600 mb-1 block">Stock Quantity</label>
          <input
            v-model="localForm.stock"
            type="number"
            placeholder="0"
            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl focus:outline-none focus:border-blue-400"
          />
        </div>
      </div>

      <div class="flex gap-3 mt-6">
        <button
          @click="$emit('close')"
          class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition-all font-medium"
        >Cancel</button>
        <button
          @click="submit"
          class="flex-1 px-4 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all font-medium"
        >{{ isEdit ? 'Update' : 'Add Product' }}</button>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  show: { type: Boolean, required: true },
  isEdit: { type: Boolean, default: false },
  form: { type: Object, default: () => ({ name: '', description: '', price: '', stock: '' }) },
})

const emit = defineEmits(['close', 'save'])

const localForm = ref({ ...props.form })

watch(() => props.form, (val) => {
  localForm.value = { ...val }
}, { deep: true })

watch(() => props.show, (val) => {
  if (val) localForm.value = { ...props.form }
})

const submit = () => {
  emit('save', { ...localForm.value })
}
</script>
