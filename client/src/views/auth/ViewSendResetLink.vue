<template>
  <LayoutCard>
    <LayoutForm
      :formHeader="'Your email'"
      :validationSchema="registerSchema"
      @request="handleRequest">
      <CompInput
        class="mt-4"
        :type="'email'"
        :placeholder="'Type an email address'"
        :name="'email'"
        :id="'email'"
        :label="'Email Address'"
        v-model="formData.email"
      />
      <CompErrorMsg
        v-if="errorMsg"
        :message="errorMsg"/>
      <div class="mb-4 my-8 flex justify-between text-sm font-medium">
        <CompButton type="submit" title="Send Reset Link" />
      </div>
    </LayoutForm>
  </LayoutCard>
</template>
<script setup lang="ts">
import { ref, type Ref } from 'vue'
import * as yup from 'yup'
import { useRouter } from 'vue-router'
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
// Utils
import CompErrorMsg from '@/components/ui/CompErrorMsg.vue'

const ENDPOINT = '/password/email'
const DEFAULT_ROUTE = '/password-reset-message'

const router = useRouter()

const isLoading = useStoreLoading()

const errorMsg: Ref<string | null> = ref<string | null>(null);

const formData: Ref = ref({
  email: ''
})

const registerSchema = yup.object({
  email: yup
    .string()
    .required('Email is required')
    .email('Please enter a correct email'),
})

const handleRequest = async () => {
  isLoading.setLoadingTrue()
  await CSRF.get('/sanctum/csrf-cookie').catch((error) => {
    console.log(error)
  })

  await api.post(`${ENDPOINT}`, {
    email: formData.value.email,
  }).then(() => {
    router.push(DEFAULT_ROUTE)
  }).catch((error) => {
    console.log(error)
  }).finally(() => {
    isLoading.setLoadingFalse()
  })
}

</script>
