<template>
  <div class="flex w-full justify-center my-4 mb-4">
    <span class="mb-1 block text-md font-light text-rose-600">{{ props.message }}</span>
  </div>
</template>

<script setup lang="ts">
const props = defineProps({
  message: {
    type: [String, null],
    default: ''
  }
})
</script>
