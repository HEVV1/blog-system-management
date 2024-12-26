<template>
  <button
    class="font-semibold py-2 px-4 rounded-lg bg-slate-300 hover:bg-slate-400 active:bg-slate-500 focus:outline-none focus:ring focus:ring-slate-300"
    :class="$attrs.class"
    @click="$emit('click')">
    {{ props.title }}
  </button>
</template>

<script setup lang="ts">
import type ButtonProps from '@/interfaces/ButtonProps.ts'

defineOptions({
  inheritAttrs: false
})

const props = defineProps<ButtonProps>()
</script>
