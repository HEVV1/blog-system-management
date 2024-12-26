import { defineStore } from 'pinia'

export const useStoreToken = defineStore('auth', {
  state: () => ({
    token: localStorage.getItem('token')
  }),
  actions: {
    setToken(token: string) {
      localStorage.setItem('token', token)
      this.token = token
    },
    clearToken() {
      localStorage.removeItem('token')
      this.token = localStorage.getItem('token')
    }
  }
})
