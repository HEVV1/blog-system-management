<template>

</template>
<script setup lang="ts">
import { onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
// Services
import { api, CSRF } from '@/services/api.ts'
// Global Store
import { useStoreLoading } from '@/stores/storeLoading.ts'

const router = useRouter()
const route = useRoute()

const ENDPOINT = `/blogs/${route.params.id}`
const DEFAULT_ROUTE = '/blogs'

const isLoading = useStoreLoading()

onMounted(async () => {
  isLoading.setLoadingTrue()
  await CSRF.get('/sanctum/csrf-cookie').catch((error) => {
    console.log(error)
  })

  await api.delete(`${ENDPOINT}`
  ).then(() => {
    router.push(DEFAULT_ROUTE)
  }).catch((error) => {
    console.log(error)
  }).finally(() => {
    isLoading.setLoadingFalse()
  })
})


</script>
