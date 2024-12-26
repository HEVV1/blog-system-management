import { defineStore } from 'pinia'

export const useStoreLoading = defineStore('loading', {
  state: () => ({
    loading: false
  }),
  actions: {
    setLoadingTrue() {
      this.loading = true
    },
    setLoadingFalse() {
      this.loading = false
    }
  }
})
