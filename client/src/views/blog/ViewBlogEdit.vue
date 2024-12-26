<template>
  <LayoutCard>
    <LayoutForm
      :formHeader="'Create blog'"
      :validation-schema="registerSchema"
      @request="handleRequest">
      <CompInput
        class="mt-4"
        :type="'text'"
        :placeholder="'Title here...'"
        :name="'title'"
        :id="'title'"
        :label="'Title of the blog'"
        v-model="formData.title"
      />
      <CompInput
        class="mt-4"
        :type="'text'"
        :placeholder="'Description here...'"
        :name="'description'"
        :id="'description'"
        :label="'Description of the blog'"
        v-model="formData.description"
      />
      <CompInput
        class="mt-4"
        :type="'text'"
        :placeholder="'Status here...'"
        :name="'status'"
        :id="'status'"
        :label="'Status of the blog'"
        v-model="formData.status"
      />
      <CompButton class="my-4 w-full" type="submit" title="Edit" />
    </LayoutForm>
  </LayoutCard>
</template>

<style scoped lang="scss">

</style>
<script setup lang="ts">
import { ref, type Ref } from 'vue'
import * as yup from 'yup'
import { useRoute, useRouter } from 'vue-router'
// Comps
import CompInput from '@/components/ui/CompInput.vue'
import CompButton from '@/components/ui/CompButton.vue'
// Layouts
import LayoutForm from '@/components/layouts/LayoutForm.vue'
import LayoutCard from '@/components/layouts/LayoutCard.vue'
// Services
import { api, CSRF } from '@/services/api.ts'
// Global Store
import { useStoreLoading } from '@/stores/storeLoading.ts'

const isLoading = useStoreLoading()
const router = useRouter()
const route = useRoute()

const ENDPOINT = `/blogs/${route.params.id}`
const DEFAULT_ROUTE = '/blogs'

const formData: Ref = ref({
  title: '',
  description: '',
  status: ''
})

const registerSchema = yup.object({
  title: yup
    .string()
    .required('Title is required'),
  status: yup
    .string()
    .required('Status is required')
})

const handleRequest = async () => {
  isLoading.setLoadingTrue()
  await CSRF.get('/sanctum/csrf-cookie').catch((error) => {
    console.log(error)
  })

  await api.put(`${ENDPOINT}`, {
    title: formData.value.title,
    description: formData.value.description,
    status: formData.value.status
  }).then(() => {
    router.push(DEFAULT_ROUTE)
  }).catch((error) => {
    console.log(error)
  }).finally(() => {
    isLoading.setLoadingFalse()
  })
}

</script>
