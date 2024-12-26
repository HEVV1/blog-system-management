// Routes
import router from '@/router'
// Global Store
import { useStoreToken } from '@/stores/storeToken.ts'
import { useStoreLoading } from '@/stores/storeLoading.ts'
// Services
import { api, CSRF } from '@/services/api.ts'

const ENDPOINT = '/logout'
const DEFAULT_ROUTE = '/login'

export const logout = async () => {
  const isLoading = useStoreLoading()
  const token = useStoreToken()

  isLoading.setLoadingTrue()
  await CSRF.get('/sanctum/csrf-cookie').catch((error) => {
    console.log(error)
  })

  await api.post(`${ENDPOINT}`).then(() => {
    token.clearToken()
    router.push(DEFAULT_ROUTE)
  }).catch((error) => {
    console.log(error)
  }).finally(() => {
    isLoading.setLoadingFalse()
  })
}
