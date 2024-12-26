<template>
  <div class="rounded-md border border-slate-300 bg-white p-4 shadow-sm"
       :class="$attrs.class">
    <slot></slot>
  </div>
</template>

<script setup lang="ts">

defineOptions({
  inheritAttrs: false
})
</script>
