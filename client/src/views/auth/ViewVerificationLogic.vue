<template>
  <div v-if="false"></div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue'
import { api, CSRF } from '@/services/api.ts'
import { useRouter } from 'vue-router'

const ENDPOINT = '/email/verify'
const DEFAULT_ROUTE = '/login'

const router = useRouter()

onMounted(async () => {
  await CSRF.get('/sanctum/csrf-cookie').catch((error) => {
    console.log(error)
  })

  const queryParams = new URLSearchParams(window.location.search)
  const id = queryParams.get('id')
  const hash = queryParams.get('hash')
  const expires = queryParams.get('expires')
  const signature = queryParams.get('signature')

  await api.get(`${ENDPOINT}/${id}/${hash}?expires=${expires}&signature=${signature}`
  ).then(() => {
    router.push(DEFAULT_ROUTE)
  }).catch((error) => {
    console.log(error)
  })
})
</script>
