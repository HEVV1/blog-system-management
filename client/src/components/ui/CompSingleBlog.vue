<template>
  <article class="rounded-md border border-slate-300 bg-white p-4 mb-4 shadow-sm">
    <div class="mb-4">
      <div class="flex justify-between mb-4">
        <div class="text-sm font-medium flex items-center">
          <img class="w-6 h-6 mr-2" src="../icons/ic_user.png" alt="">
          <span>
            {{ props.blog?.user?.username }}
          </span>
        </div>
        <span class="text-slate-400 text-xs">
          {{ formattedDate }}
        </span>
      </div>
      <h2 class="font-semibold text-slate-500 text-xl mb-4">
        {{ props.blog?.description }}
      </h2>
      <span class="text-sm text-slate-500">
        Status: {{ props.blog?.status }}
      </span>
    </div>
  </article>
</template>

<script setup lang="ts">
import { computed } from 'vue'

const props = defineProps({
  blog: {
    type: Object
  }
})

const formattedDate = computed(() => {
  const options: object = { year: 'numeric', month: 'long', day: 'numeric' }
  return new Date(props.blog?.created_at).toLocaleDateString('en-US', options)
})
</script>
