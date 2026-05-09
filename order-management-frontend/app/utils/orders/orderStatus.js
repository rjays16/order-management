export const ORDER_STATUS = {
  Pending:   { icon: 'clock', label: 'Pending',   bg: 'bg-yellow-100 text-yellow-700', statBg: 'bg-yellow-100' },
  Confirmed: { icon: 'check-circle', label: 'Confirmed', bg: 'bg-green-100 text-green-700',   statBg: 'bg-green-100' },
  Cancelled: { icon: 'x-circle', label: 'Cancelled', bg: 'bg-red-100 text-red-700',      statBg: 'bg-red-100' },
}

export const TABS = [
  { icon: '', label: 'All', value: 'All' },
  ...Object.entries(ORDER_STATUS).map(([value, s]) => ({ icon: s.icon, label: s.label, value })),
]
