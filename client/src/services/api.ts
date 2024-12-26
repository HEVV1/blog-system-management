import axios from 'axios'
import router from '@/router'
import { useStoreToken } from '@/stores/storeToken.ts'

const api = axios.create({
  baseURL: 'http://127.0.0.1:8000/api',
  timeout: 12000,
  withCredentials: true
})

api.interceptors.request.use(
  (config) => {
    const tokenStore = useStoreToken()
    if (tokenStore) {
      config.headers.Authorization = `Bearer ${tokenStore.token}`
    }
    return config
  },
  (error) => {
    return Promise.reject(error)
  }
)

api.interceptors.response.use(
  (response) => {
    return response
  },
  async (error) => {
    if (error.response && error.response.status === 401) {
      await router.push({ path: '/login' })
    }
    return Promise.reject(error)
  }
)

const CSRF = axios.create({
  baseURL: 'http://127.0.0.1:8000'
})

export { api, CSRF }
