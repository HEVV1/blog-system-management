// Routes
import router from '@/router'
// Global Store

export const redirectTo = async (route: string) => {
  await router.push(route)
}
