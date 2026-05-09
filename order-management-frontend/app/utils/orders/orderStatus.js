export const ORDER_STATUS = {
  Pending:   { icon: '⏳', label: 'Pending',   bg: 'bg-yellow-100 text-yellow-700', statBg: 'bg-yellow-100' },
  Confirmed: { icon: '✅', label: 'Confirmed', bg: 'bg-green-100 text-green-700',   statBg: 'bg-green-100' },
  Cancelled: { icon: '❌', label: 'Cancelled', bg: 'bg-red-100 text-red-700',      statBg: 'bg-red-100' },
}

export const TABS = [
  { label: 'All', value: 'All' },
  ...Object.entries(ORDER_STATUS).map(([value, s]) => ({ label: `${s.icon} ${s.label}`, value })),
]
