export const SEED_PRODUCTS = [
  { id: 1, name: 'Laptop Stand', description: 'Adjustable aluminum stand', price: 1200, stock: 5 },
  { id: 2, name: 'Mechanical Keyboard', description: 'RGB backlit, tactile switches', price: 3500, stock: 23 },
  { id: 3, name: 'USB-C Hub', description: '7-in-1 multiport adapter', price: 1800, stock: 8 },
  { id: 4, name: 'Webcam HD', description: '1080p with built-in mic', price: 2500, stock: 35 },
  { id: 5, name: 'Mouse Pad XL', description: 'Extra large desk mat', price: 650, stock: 42 },
  { id: 6, name: 'Monitor Light', description: 'USB powered screen bar', price: 1900, stock: 0 },
]

export const stockStatus = (stock) => {
  if (stock === 0) return { label: 'Out of Stock', bg: 'bg-red-100 text-red-700' }
  if (stock <= 10) return { label: 'Low Stock', bg: 'bg-yellow-100 text-yellow-700' }
  return { label: 'In Stock', bg: 'bg-green-100 text-green-700' }
}
