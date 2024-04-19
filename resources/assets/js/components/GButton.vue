<template>
  <a v-if="link" :class='classes' :href="link">
    <slot></slot>
  </a>
  <button v-else :class='classes'>
    <slot></slot>
  </button>
</template>

<script setup>
import {computed} from 'vue'

const colors = {
  white: 'inline-block align-middle text-center select-none font-normal whitespace-no-wrap rounded py-2 px-3 leading-normal no-underline bg-white text-gray-700 hover:bg-gray-200',
  green: 'inline-block align-middle text-center select-none font-normal whitespace-no-wrap rounded py-2 px-3 leading-normal no-underline bg-lime-500 text-white hover:bg-lime-600',
  orange: 'inline-block align-middle text-center select-none font-normal whitespace-no-wrap rounded py-2 px-3 leading-normal no-underline bg-orange-400 text-white hover:bg-orange-500',
}

const sizes = {
  small: 'text-sm',
  middle: 'text-base',
  large: 'text-lg',
}

const props = defineProps({
  color: 'white',
  size: 'middle',
  link: null,
  class: '',
})

const classes = computed(() => {
  let c = []
  if (colors[props.color]) {
    c.push(colors[props.color])
  }

  if (sizes[props.size]) {
    c.push(sizes[props.size])
  }

  if (props.class) {
    c.push(props.class)
  }

  return c.join(' ')
})

</script>

<style scoped>

</style>