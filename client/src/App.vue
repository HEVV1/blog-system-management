<template>
  <div class="flex mb-4 my-4 pl-4 pr-4 justify-end">
    <CompButton
      v-if="storedToken.token"
      title="Log Out"
      @click="logout" />
  </div>
  <div class="container mx-auto mt-10 max-w-2xl text-slate-700 pl-4 pr-4">
    <RouterView />
  </div>
  <CompSpinner :loading="isLoading.loading" />
</template>

<script setup lang="ts">
import { RouterView } from 'vue-router'
// Comps
import CompSpinner from '@/components/ui/CompSpinner.vue'
// Utils
import { useStoreLoading } from '@/stores/storeLoading.ts'
import { useStoreToken } from '@/stores/storeToken.ts'
import CompButton from '@/components/ui/CompButton.vue'
// Services
import { logout } from '@/services/logout.ts'

const isLoading = useStoreLoading()
const storedToken = useStoreToken()
</script>

<style scoped>

</style>
