<template>
  <LayoutCard>
    <LayoutForm
      :formHeader="'Change the Password'"
      :validationSchema="registerSchema"
      @request="handleRequest">
      <CompInput
        class="mt-4"
        :type="'password'"
        :placeholder="'Type the password'"
        :name="'password'"
        :id="'password'"
        :label="'Password'"
        v-model="formData.password"
      />
      <CompInput
        class="mt-4"
        :type="'password'"
        :placeholder="'Type the password confirmation'"
        :name="'password_confirmation'"
        :id="'password_confirmation'"
        :label="'Confirm Password'"
        v-model="formData.password_confirmation"
      />
      <CompErrorMsg
        v-if="errorMsg"
        :message="errorMsg" />
      <div class="mb-4 my-8 flex justify-between text-sm font-medium">
        <CompButton type="submit" title="Submit" />
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

const ENDPOINT = '/password/reset'
const DEFAULT_ROUTE = '/password-reset-success'

const router = useRouter()

const isLoading = useStoreLoading()

const errorMsg: Ref<string | null> = ref<string | null>(null)

const formData: Ref = ref({
  password: '',
  password_confirmation: ''
})

const registerSchema = yup.object({
  password: yup
    .string()
    .required('Password is required')
    .min(8, 'Password must be at least 8 characters'),
  password_confirmation: yup
    .string()
    .required('Please confirm your password')
    .oneOf([yup.ref('password')], 'Password doesn\'t match')
})

const handleRequest = async () => {
  isLoading.setLoadingTrue()
  await CSRF.get('/sanctum/csrf-cookie').catch((error) => {
    console.log(error)
  })

  const queryParams = new URLSearchParams(window.location.search)
  const token = queryParams.get('token')
  const email = decodeURIComponent(queryParams.get('email') || '');

  await api.post(`${ENDPOINT}`, {
    token: token,
    email: email,
    password: formData.value.password,
    password_confirmation: formData.value.password_confirmation
  }).then(() => {
    router.push(DEFAULT_ROUTE)
  }).catch((error) => {
    console.log(error)
  }).finally(() => {
    isLoading.setLoadingFalse()
  })
}

</script>
