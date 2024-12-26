<template>
  <LayoutCard>
    <LayoutForm
      :formHeader="'Sign Up'"
      :validationSchema="registerSchema"
      @request="handleRequest">
      <CompInput
        :type="'text'"
        :placeholder="'Type a user name'"
        :name="'username'"
        :id="'username'"
        :label="'User Name'"
        v-model="formData.username"
      />
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
      <CompInput
        class="mt-4"
        :type="'password'"
        :placeholder="'Type the password confirmation'"
        :name="'password_confirmation'"
        :id="'password_confirmation'"
        :label="'Confirm Password'"
        v-model="formData.password_confirmation"
      />
      <div class="mt-4">
        <label class="mb-1 block text-md font-medium text-slate-900" for="country">Country:</label>
        <select
          class="w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 ring-slate-300 placeholder:text-slate-400 focus:ring-2"
          id="country"
          v-model="selectedCountry"
          @change="onCountryChange"
        >
          <option value="">Select Country</option>
          <option
            v-for="item in jsonCountryData"
            :key="item.country"
            :value="item.country"
          >
            {{ item.country }}
          </option>
        </select>
      </div>
      <div class="mt-4">
        <label class="mb-1 block text-md font-medium text-slate-900" for="language">Language:</label>
        <select
          class="w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 ring-slate-300 placeholder:text-slate-400 focus:ring-2"
          id="language"
          v-model="selectedLanguage">
          <option value="">Select Language</option>
          <option
            v-for="(lang, index) in availableLanguages"
            :key="index"
            :value="lang"
          >
            {{ lang }}
          </option>
        </select>
      </div>
      <CompErrorMsg
        v-if="errorMsg"
        :message="errorMsg" />
      <div class="mb-4 my-8 flex justify-between text-sm font-medium">
        <router-link to="/login" class="text-indigo-600 hover:underline flex items-center">
          Already have an account?
        </router-link>
        <CompButton type="submit" title="Register" />
      </div>
    </LayoutForm>
  </LayoutCard>
</template>

<script setup lang="ts">
import { onMounted, ref, type Ref, watch } from 'vue'
import {
  useRouter
} from 'vue-router'
import * as yup from 'yup'
// Layouts
import LayoutCard from '@/components/layouts/LayoutCard.vue'
import LayoutForm from '@/components/layouts/LayoutForm.vue'
// Comps
import CompInput from '@/components/ui/CompInput.vue'
import CompButton from '@/components/ui/CompButton.vue'
// Interfaces aka Types
import type { RegisterRequest } from '@/interfaces/authRequest.ts'
// Services
import {
  api,
  CSRF
} from '@/services/api.ts'
// Global Store
import { useStoreLoading } from '@/stores/storeLoading.ts'
// API Composition
import CompErrorMsg from '@/components/ui/CompErrorMsg.vue'

const ENDPOINT = '/register'
const ENDPOINT_GET_JSON_DATA = '/countries-language-json'
const DEFAULT_ROUTE = '/verification-message'

const router = useRouter()

const isLoading = useStoreLoading()
const errorMsg: Ref<string | null> = ref<string | null>(null)

const formData: Ref<RegisterRequest> = ref<RegisterRequest>({
  username: '',
  email: '',
  password: '',
  password_confirmation: ''
})

interface CountryLang {
  country: string,
  languages: Array<string>
}

const jsonCountryData: Ref<CountryLang[]> = ref<CountryLang[]>([
  {
    country: '',
    languages: []
  }
])

const selectedCountry = ref('')
const selectedLanguage = ref('')

const availableLanguages = ref([''])

const registerSchema = yup.object({
  username: yup
    .string()
    .required('Username is required'),
  email: yup
    .string()
    .required('Email is required')
    .email('Please enter a correct email'),
  password: yup
    .string()
    .required('Password is required')
    .min(8, 'Password must be at least 8 characters'),
  password_confirmation: yup
    .string()
    .required('Please confirm your password')
    .oneOf([yup.ref('password')], 'Password doesn\'t match')
})

onMounted(async () => {
  isLoading.setLoadingTrue()
  await CSRF.get('/sanctum/csrf-cookie').catch((error) => {
    console.log(error)
  })

  await api.get(`${ENDPOINT_GET_JSON_DATA}`
  ).then((response) => {
    jsonCountryData.value = response.data
  }).catch((error) => {
    console.log(error)
  }).finally(() => {
    isLoading.setLoadingFalse()
  })
})

const onCountryChange = () => {
  selectedLanguage.value = ''
  const selected = jsonCountryData.value.find(
    (c) => c.country === selectedCountry.value
  )
  availableLanguages.value = selected ? selected.languages : []
}

const handleRequest = async () => {
  isLoading.setLoadingTrue()
  await CSRF.get('/sanctum/csrf-cookie').catch((error) => {
    console.log(error)
  })

  await api.post(`${ENDPOINT}`, {
    username: formData.value.username,
    email: formData.value.email,
    password: formData.value.password,
    password_confirmation: formData.value.password_confirmation,
    country: selectedCountry.value,
    language: selectedLanguage.value
  }).then(() => {
    router.push(DEFAULT_ROUTE)
  }).catch((error) => {
    console.log(error)
    errorMsg.value = error.response.data.message
  }).finally(() => {
    isLoading.setLoadingFalse()
  })
}

</script>
