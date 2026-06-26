export const useApi = () => {
  const config = useRuntimeConfig()
  
  const apiFetch = $fetch.create({
    baseURL: config.public.apiBase,
    headers: {
      'Accept': 'application/json',
    },
    async onResponseError({ response }) {
      if (response.status === 422) {
        // Validation errors are handled by components
        return;
      }
      console.error('API Error:', response.status, response._data)
    }
  })

  return apiFetch
}
