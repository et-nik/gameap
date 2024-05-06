<template>
  <a v-if="link" :class='classes' :href="link">
    <slot></slot>
  </a>
  <router-link v-else-if="route" :to="route" :class='classes'>
    <slot></slot>
  </router-link>
  <button v-else :class='classes' v-on:click="buttonClick">
    <slot></slot>
  </button>
</template>

<script setup>
import {computed} from 'vue'

const colors = {
  black: 'inline-block align-middle text-center select-none font-normal whitespace-no-wrap rounded leading-normal no-underline bg-stone-700 text-white hover:bg-stone-800',
  white: 'inline-block align-middle text-center select-none font-normal whitespace-no-wrap rounded leading-normal no-underline text-black bg-white border border-stone-300 focus:outline-none hover:bg-stone-100 focus:ring-4 focus:ring-stone-100 dark:bg-stone-800 dark:text-white dark:border-stone-600 dark:hover:bg-stone-700 dark:hover:border-stone-600 dark:focus:ring-stone-700',
  green: 'inline-block align-middle text-center select-none font-normal whitespace-no-wrap rounded leading-normal no-underline bg-lime-500 text-white hover:bg-lime-600',
  red: 'inline-block align-middle text-center select-none font-normal whitespace-no-wrap rounded leading-normal no-underline bg-red-500 text-white hover:bg-red-600',
  orange: 'inline-block align-middle text-center select-none font-normal whitespace-no-wrap rounded leading-normal no-underline bg-orange-400 text-white hover:bg-orange-500',
  blue: 'inline-block align-middle text-center select-none font-normal whitespace-no-wrap rounded leading-normal no-underline bg-sky-500 text-white hover:bg-sky-600',
}

const sizes = {
  small: 'text-xs py-1.5 px-2',
  middle: 'py-2 px-3',
  large: 'text-lg py-3 px-4',
}

const props = defineProps({
  color: 'white',
  size: 'middle',
  link: null,
  route: null,
  class: '',
})

const classes = computed(() => {
  const color = colors[props.color] || colors.white
  const size = sizes[props.size] || sizes.middle

  let c = []

  c.push(color)
  c.push(size)

  if (props.class) {
    c.push(props.class)
  }

  return c.join(' ')
})

const emits = defineEmits(["click"])

const buttonClick = () => {
  emits("click")
}

</script>

<style scoped>

</style>