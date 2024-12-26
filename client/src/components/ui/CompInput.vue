<template>
  <div :class="$attrs.class">
    <label class="mb-1 block text-md font-medium text-slate-900"
           v-if="props.label"
           :for="props.name">{{ props.label }}</label>
    <Field
      class="w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 ring-slate-300 placeholder:text-slate-400 focus:ring-2"
      :type="props.type"
      :placeholder="props.placeholder"
      :name="props.name"
      :value="props.modelValue"
      :id="props.id"
      @input="onInput" />
    <ErrorMessage class="valid-alert" :name="props.name" />
  </div>
</template>


<script setup lang="ts">
// libs
import { ErrorMessage, Field } from 'vee-validate'
// types
import type { InputProps } from '@/interfaces/InputProps.ts'

const props = defineProps<InputProps>()

const emits = defineEmits(['update:modelValue'])

defineOptions({
  inheritAttrs: false
})

const onInput = (event: Event) => {
  const target = event.target as HTMLInputElement
  emits('update:modelValue', target.value)
}
</script>

<style scoped lang="scss">
.valid-alert{
  color: red;
}
</style>
