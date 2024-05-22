<template>
  <Menu as="div" :class="$attrs.class" class="relative inline-block text-left">
    <div class="sm:hidden">
      <MenuButton @click="onMenuButtonClick" class="gap-x-1.5 mt-4 text-white hover:bg-stone-800 px-4 py-2 rounded">
        <i v-if="buttonIcon" :class="buttonIcon"></i>
      </MenuButton>
    </div>

    <div class="sm:visible invisible">
      <MenuButton @click="onMenuButtonClick" class="w-full gap-x-1.5 text-white hover:bg-stone-800 md:px-4 md:py-2 rounded">
        <i v-if="buttonIcon" :class="buttonIcon" class="mr-1"></i>
        <span class="md:visible collapse">{{ props.buttonText }}</span>
        <i v-if="!clicked" class="fa-solid fa-chevron-down ml-4 md:visible collapse"></i>
        <i v-else class="fa-solid fa-chevron-up ml-4 md:visible collapse"></i>
      </MenuButton>
    </div>

    <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
      <MenuItems class="absolute right-0 z-10 mt-2 w-56 origin-top-right divide-y divide-stone-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
        <div class="py-1" v-for="itemGroup in items">
          <MenuItem v-slot="{ active }" v-for="item in itemGroup">
            <router-link
                v-if="item.route"
                :to="item.route"
                :class="[active ? 'bg-stone-100 text-stone-900' : 'text-stone-700', 'block px-4 py-2 text-sm']"
            >
              <i v-if="item.icon" :class="item.icon"></i>
              {{ item.label }}
            </router-link>
            <router-link
                v-else-if="item.link"
                :href="item.link"
                :class="[active ? 'bg-stone-100 text-stone-900' : 'text-stone-700', 'block px-4 py-2 text-sm']"
            >
              <i v-if="item.icon" :class="item.icon"></i>
              {{ item.label }}
            </router-link>
          </MenuItem>
        </div>
      </MenuItems>
    </transition>
  </Menu>
</template>

<script setup>
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import {defineProps, ref} from "vue"

const props = defineProps({
  buttonText: {
    type: String,
    required: true,
  },
  buttonIcon: {
    type: String,
    required: false,
  },
  items: {
    type: Array,
    required: false,
  },
})

const clicked = ref(false)

const onMenuButtonClick = () => {
  clicked.value = !clicked.value;
}


</script>