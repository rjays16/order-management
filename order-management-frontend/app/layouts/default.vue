<template>
  <div class="flex h-screen bg-gray-100">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg flex flex-col">

      <!-- Logo -->
      <div class="bg-blue-600 px-6 py-5">
        <h1 class="text-white font-bold text-xl flex items-center gap-2"><Icon name="package" class="text-white" /> OrderSync</h1>
        <p class="text-blue-200 text-xs mt-1">Management System</p>
      </div>

      <!-- Nav Links -->
      <nav class="flex-1 px-4 py-6 space-y-2">
        <NuxtLink
          to="/"
          class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-all"
          active-class="bg-blue-50 text-blue-600 font-semibold"
        >
          <Icon name="chart-bar" class="w-5 h-5" />
          <span>Dashboard</span>
        </NuxtLink>

        <NuxtLink
          to="/products"
          class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-all"
          active-class="bg-blue-50 text-blue-600 font-semibold"
        >
          <Icon name="package" class="w-5 h-5" />
          <span>Products</span>
        </NuxtLink>

        <NuxtLink
          to="/orders"
          class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-all"
          active-class="bg-blue-50 text-blue-600 font-semibold"
        >
          <Icon name="shopping-cart" class="w-5 h-5" />
          <span>Orders</span>
        </NuxtLink>

        <NuxtLink
          to="/logs"
          class="flex items-center gap-3 px-4 py-3 rounded-xl text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-all"
          active-class="bg-blue-50 text-blue-600 font-semibold"
        >
          <Icon name="clipboard-list" class="w-5 h-5" />
          <span>Activity Logs</span>
        </NuxtLink>
      </nav>

      <!-- Footer -->
      <div class="px-6 py-4 border-t border-gray-100">
        <p class="text-xs text-gray-400">DIG Technical Exam</p>
        <p class="text-xs text-gray-400">Order Management v1.0</p>
      </div>

    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">

      <!-- Top Navbar -->
      <header class="bg-white shadow-sm px-8 py-4 flex items-center justify-between">
        <h2 class="text-xl font-semibold text-gray-700">
          {{ pageTitle }}
        </h2>
        <div class="flex items-center gap-3">
          <span class="text-sm text-gray-500 flex items-center gap-1.5"><Icon name="user" class="w-4 h-4" /> Admin</span>
          <div class="w-9 h-9 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
            A
          </div>
        </div>
      </header>

      <!-- Page Content -->
      <main class="flex-1 overflow-y-auto p-8">
        <slot />
      </main>

    </div>
  </div>
</template>

<script setup>
const route = useRoute()

const pageTitle = computed(() => {
  const titles = {
    '/': 'Dashboard',
    '/products': 'Products',
    '/orders': 'Orders',
    '/logs': 'Activity Logs',
  }
  return titles[route.path] || 'Dashboard'
})
</script>