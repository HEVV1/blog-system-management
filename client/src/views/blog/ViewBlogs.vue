<template>
  <LayoutCard>
    <h1 class="uppercase font-semibold text-4xl mb-6 text-center text-slate-700">Blogs</h1>
    <div class="mb-4">
      <LayoutForm
        :formHeader="'Sign Up'"
        @request="handleRequest">
        <CompInput
          class="mt-4"
          :type="'text'"
          :placeholder="'Type the blog status or date'"
          :name="'search'"
          :id="'search'"
          :label="'Search for blog'"
          v-model="formData.search"
        />
        <CompButton class="my-4 w-full" type="submit" title="Search" />
      </LayoutForm>
    </div>
    <CompButton
      class="w-full mb-8"
      title="Create"
      @click="redirectTo('/blog/create')" />
    <div v-for="(item) in blogs">
      <router-link :to="{name: 'Blog', params: {id: item.id}}">
        <CompSingleBlog
          :blog="item">
        </CompSingleBlog>
      </router-link>
    </div>
  </LayoutCard>
</template>

<script setup lang="ts">

import { onMounted, ref, type Ref } from 'vue'
// Layout
import LayoutCard from '@/components/layouts/LayoutCard.vue'
import LayoutForm from '@/components/layouts/LayoutForm.vue'
// Comps
import CompInput from '@/components/ui/CompInput.vue'
import CompButton from '@/components/ui/CompButton.vue'
import CompSingleBlog from '@/components/ui/CompSingleBlog.vue'
// Services
import { api, CSRF } from '@/services/api.ts'
// Global store
import { useStoreLoading } from '@/stores/storeLoading.ts'
// Interfaces
import type Blog from '@/interfaces/Blog.ts'
import { redirectTo } from '@/services/redirectTo.ts'

const isLoading = useStoreLoading()

const formData: Ref = ref({
  search: ''
})

const ENDPOINT = '/blogs'

const blogs: Ref<Blog[]> = ref<Blog[]>([])
const links: Ref<object> = ref<object>({})
const meta: Ref = ref()

onMounted(async () => {
  isLoading.setLoadingTrue()
  await CSRF.get('/sanctum/csrf-cookie').catch((error) => {
    console.log(error)
  })

  await api.get(`${ENDPOINT}`
  ).then((response) => {
    blogs.value = [...response.data.data]
    links.value = response.data.links
    meta.value = response.data.meta
  }).catch((error) => {
    console.log(error)
  }).finally(() => {
    isLoading.setLoadingFalse()
  })
})

const handleRequest = async () => {
  isLoading.setLoadingTrue()
  await CSRF.get('/sanctum/csrf-cookie').catch((error) => {
    console.log(error)
  })

  await api.get(`${ENDPOINT}?search=${formData.value.search}`
  ).then((response) => {
    blogs.value = [...response.data.data]
    links.value = response.data.links
    meta.value = response.data.meta
  }).catch((error) => {
    console.log(error)
  }).finally(() => {
    isLoading.setLoadingFalse()
  })
}

const showBlog = (event) => {
  console.log('asdasdasd', event)
}
</script>
