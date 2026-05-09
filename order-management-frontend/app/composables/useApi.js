export function useApi() {
  const config = useRuntimeConfig()
  const base = config.public.apiBase

  const get = (url, params) => $fetch(`${base}${url}`, { params })
  const post = (url, body) => $fetch(`${base}${url}`, { method: 'POST', body })
  const put = (url, body) => $fetch(`${base}${url}`, { method: 'PUT', body })
  const del = (url) => $fetch(`${base}${url}`, { method: 'DELETE' })

  return { get, post, put, del }
}
