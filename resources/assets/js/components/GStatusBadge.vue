<template>
  <span :class="spanClass">{{ status }}</span>
</template>

<script setup>
import {computed, defineProps} from "vue"

const props = defineProps({
  status: {
    type: String,
    required: true
  },
})

const badgeClasses = {
  waiting: 'badge-light',
  working: 'badge-blue',
  error: 'badge-red',
  success: 'badge-green',
  canceled: 'badge-stone',
}

const spanClass = computed(() => {
  return badgeClasses[props.status] ?? 'badge-light'
})
</script>