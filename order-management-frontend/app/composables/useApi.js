export function useApi() {
  const config = useRuntimeConfig()
  const base = config.public.apiBase

  const get = async (url, params) => {
    try {
      return await $fetch(`${base}${url}`, { params })
    } catch (e) {
      throw new Error(e.data?.message || e.message || 'Failed to fetch data')
    }
  }

  const post = async (url, body) => {
    try {
      return await $fetch(`${base}${url}`, { method: 'POST', body })
    } catch (e) {
      throw new Error(e.data?.message || e.message || 'Failed to create')
    }
  }

  const put = async (url, body) => {
    try {
      return await $fetch(`${base}${url}`, { method: 'PUT', body })
    } catch (e) {
      throw new Error(e.data?.message || e.message || 'Failed to update')
    }
  }

  const del = async (url) => {
    try {
      return await $fetch(`${base}${url}`, { method: 'DELETE' })
    } catch (e) {
      throw new Error(e.data?.message || e.message || 'Failed to delete')
    }
  }

  return { get, post, put, del }
}
