<template>
  <LayoutCard>
    <CompSingleBlog
      :blog="blog">
    </CompSingleBlog>
    <div class="flex mb-4 justify-end">
      <CompButton
        class="mr-4"
        title="Edit"
        @click="redirectTo(`/blog/edit/${blog?.id}`)" />
      <CompButton
        title="Delete"
        @click="redirectTo(`/blog/delete/${blog?.id}`)" />
    </div>
  </LayoutCard>
</template>
<script setup lang="ts">
import { onMounted, ref, type Ref } from 'vue'
// Layout
import LayoutCard from '@/components/layouts/LayoutCard.vue'
import CompSingleBlog from '@/components/ui/CompSingleBlog.vue'
// Services
import { api, CSRF } from '@/services/api.ts'
// Global store
import { useStoreLoading } from '@/stores/storeLoading.ts'
// Interfaces
import type Blog from '@/interfaces/Blog.ts'
import { useRoute } from 'vue-router'
import CompButton from '@/components/ui/CompButton.vue'
import { redirectTo } from '@/services/redirectTo.ts'

const isLoading = useStoreLoading()
const route = useRoute()

const ENDPOINT = route.fullPath;

const blog: Ref<Blog> = ref<Blog>({
  createdAt: new Date(),
  description: '',
  id: 0,
  status: '',
  title: '',
  user: { email: '', id: 0, username: '' }
})

onMounted(async () => {
  isLoading.setLoadingTrue()

  await CSRF.get('/sanctum/csrf-cookie').catch((error) => {
    console.log(error)
  })

  await api.get(`${ENDPOINT}`
  ).then((response) => {
    blog.value = response.data.data
  }).catch((error) => {
    console.log(error)
  }).finally(() => {
    isLoading.setLoadingFalse()
  })
})
</script>
