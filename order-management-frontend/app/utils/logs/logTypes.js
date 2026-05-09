export const LOG_TYPES = {
  add:    { icon: 'plus', label: 'Addition',   dotClass: 'bg-green-500', badgeClass: 'bg-green-100 text-green-700', statBg: 'bg-green-100' },
  deduct: { icon: 'minus', label: 'Deduction',  dotClass: 'bg-red-500', badgeClass: 'bg-red-100 text-red-700', statBg: 'bg-red-100' },
  restore: { icon: 'refresh', label: 'Restore',   dotClass: 'bg-yellow-500', badgeClass: 'bg-yellow-100 text-yellow-700', statBg: 'bg-yellow-100' },
  order:  { icon: 'shopping-cart', label: 'Order',     dotClass: 'bg-blue-500', badgeClass: 'bg-blue-100 text-blue-700', statBg: 'bg-blue-100' },
}

export const logConfig = (type) => LOG_TYPES[type] || { icon: 'clipboard-list', dotClass: 'bg-gray-500', badgeClass: 'bg-gray-100 text-gray-700', statBg: 'bg-gray-100' }
