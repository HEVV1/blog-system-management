<template>
  <LayoutCard>
    <LayoutForm
      :formHeader="'Sign Up'"
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
      <CompInput
        class="mt-4"
        :type="'password'"
        :placeholder="'Type the password'"
        :name="'password'"
        :id="'password'"
        :label="'Password'"
        v-model="formData.password"
      />
      <CompErrorMsg
        v-if="errorMsg"
        :message="errorMsg"/>
      <div class="mb-4 my-8 flex justify-between text-sm font-medium">
        <div>
          <router-link to="/register" class="text-indigo-600 hover:underline flex items-center">
            Don't have an account?
          </router-link>
          <router-link to="/password-reset-send" class="text-indigo-600 hover:underline flex items-center">
            Forgot the password?
          </router-link>
        </div>
        <CompButton type="submit" title="Log In" />
      </div>
    </LayoutForm>
  </LayoutCard>
</template>

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
// Interfaces
import type { LoginRequest } from '@/interfaces/authRequest.ts'
// Services
import { api, CSRF } from '@/services/api.ts'
// Global Store
import { useStoreLoading } from '@/stores/storeLoading.ts'
import { useStoreToken } from '@/stores/storeToken.ts'
// Utils
import { useRouteRedirect } from '@/utils/useRouteRedirect.ts'
import CompErrorMsg from '@/components/ui/CompErrorMsg.vue'

const ENDPOINT = '/login'
const DEFAULT_ROUTE = '/blogs'

const router = useRouter()
const route = useRoute()

const isLoading = useStoreLoading()
const storeAuthToken = useStoreToken()

const errorMsg: Ref<string | null> = ref<string | null>(null);

const formData: Ref<LoginRequest> = ref<LoginRequest>({
  email: '',
  password: ''
})

const registerSchema = yup.object({
  email: yup
    .string()
    .required('Email is required')
    .email('Please enter a correct email'),
  password: yup
    .string()
    .required('Password is required')
    .min(8, 'Password must be at least 8 characters')
})

const handleRequest = async () => {
  isLoading.setLoadingTrue()
  await CSRF.get('/sanctum/csrf-cookie').catch((error) => {
    console.log(error)
  })

  await api.post(`${ENDPOINT}`, {
    email: formData.value.email,
    password: formData.value.password
  }).then(response => {
    const token = response.data.token
    storeAuthToken.setToken(token)
    router.push(useRouteRedirect(DEFAULT_ROUTE, route.query.redirect))
  }).catch((error) => {
    console.log(error)
    errorMsg.value = error.response.data.message
  }).finally(() => {
    isLoading.setLoadingFalse()
  })
}


</script>
