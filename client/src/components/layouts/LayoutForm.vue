<template>
  <Form
    :validation-schema="validationSchema"
    @submit="$emit('request')">
    <h1 class="my-10 text-center text-3xl font-medium text-slate-600">{{ props.formHeader }}</h1>
    <slot></slot>
  </Form>
</template>

<script setup lang="ts">
import { Form } from 'vee-validate'

const props = defineProps({
  formHeader: {
    type: String,
    default: ''
  },
  validationSchema: {
    type: Object
  }
})
</script>
