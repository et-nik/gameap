<template>
    <!-- Component Start -->
    <div v-if="minimized === true" class="items-center w-16 mr-5"></div>
    <div v-if="minimized === true" class="sidebar-menu fixed items-center w-16 h-full overflow-y-scroll no-scrollbar text-stone-400 bg-stone-900">
        <a class="flex items-center w-full px-3 mt-3" href="#">
          <span class="ml-2 w-full text-center text-sm font-bold">—</span>
        </a>

        <div class="w-full px-2">
          <div class="flex flex-col items-center w-full mb-3 border-stone-700">
            <a v-for="link in serversLinks" class="flex items-center transition transform w-full h-10 px-3 mt-2 bg-stone-800 hover:translate-x-2" :href="link.href">
              <i :class="link.icon" class="ml-1"></i>
            </a>
          </div>
        </div>

        <a class="flex items-center w-full px-3 mt-3" href="#">
          <span class="ml-2 w-full text-center text-sm font-bold">—</span>
        </a>

        <div class="w-full px-2">
          <div class="flex flex-col items-center w-full mb-3 border-stone-700">
            <a v-for="link in adminLinks" class="flex items-center transition transform w-full h-10 px-3 mt-2 bg-stone-800 hover:translate-x-2" :href="link.href">
              <i :class="link.icon" class="ml-1"></i>
            </a>
          </div>
        </div>

        <a class="flex items-center w-full px-3 mt-3" href="#">
          <span class="ml-2 w-full text-center text-sm font-bold">—</span>
        </a>

        <div class="w-full px-2">
          <div class="flex flex-col items-center w-full mb-3 border-stone-700">
            <a v-for="link in gameapLinks" class="flex items-center transition transform w-full h-10 px-3 mt-2 bg-stone-800 hover:translate-x-2" :href="link.href">
              <i :class="link.icon" class="ml-1"></i>
            </a>
          </div>
        </div>

        <div class="w-full px-2 mt-3">
          <div class="flex flex-col items-center w-full mb-3 border-stone-700">
            <a v-on:click="toggleMinimized" class="flex items-center transition transform w-full h-10 px-3 mt-2 bg-stone-800 hover:translate-x-2" href="#">
              <i class="fas fa-chevron-right ml-1"></i>
            </a>
          </div>
        </div>

        <div class="mb-20"></div>

      </div>
    <!-- Component End  -->

    <!-- Component Start -->
    <div v-if="minimized === false" class="items-center w-56 mr-5"></div>
    <div v-if="minimized === false" class="sidebar-menu fixed items-center w-56 h-full overflow-y-scroll no-scrollbar text-stone-400 bg-stone-900">
      <a class="flex items-center w-full px-3 mt-3" href="#">
        <span class="ml-2 w-full text-center text-sm font-bold">{{ trans('sidebar.control') }}</span>
      </a>

      <div class="w-full px-2">
        <div class="flex flex-col items-center w-full mb-3 border-stone-700">
          <a v-for="link in serversLinks" class="flex items-center transition transform w-full h-10 px-3 mt-2 bg-stone-800 hover:translate-x-2" :href="link.href">
            <i :class="link.icon" class="ml-1"></i>
            <span class="ml-2 text-sm font-medium">{{ link.text }}</span>
          </a>
        </div>
      </div>

      <a class="flex items-center w-full px-3 mt-3" href="#">
        <span class="ml-2 w-full text-center text-sm font-bold">{{ trans('sidebar.admin') }}</span>
      </a>

      <div class="w-full px-2">
        <div class="flex flex-col items-center w-full mb-3 border-stone-700">
          <a v-for="link in adminLinks" class="flex items-center transition transform w-full h-10 px-3 mt-2 bg-stone-800 hover:translate-x-2" :href="link.href">
            <i :class="link.icon" class="ml-1"></i>
            <span class="ml-2 text-sm font-medium">{{ link.text }}</span>
          </a>
        </div>
      </div>

      <a class="flex items-center w-full px-3 mt-3" href="#">
        <span class="ml-2 w-full text-center text-sm font-bold">{{ trans('sidebar.gameap') }}</span>
      </a>

      <div class="w-full px-2">
        <div class="flex flex-col items-center w-full mb-3 border-stone-700">
          <a v-for="link in gameapLinks" class="flex items-center transition transform w-full h-10 px-3 mt-2 bg-stone-800 hover:translate-x-2" :href="link.href">
            <i :class="link.icon" class="ml-1"></i>
            <span class="ml-2 text-sm font-medium">{{ link.text }}</span>
          </a>
        </div>
      </div>

      <div class="w-full px-2 mt-3">
        <div class="flex flex-col items-center w-full mb-3 border-stone-700">
          <a v-on:click="toggleMinimized" class="flex items-center transition transform w-full h-10 px-3 mt-2 bg-stone-800 hover:translate-x-2" href="#">
            <i class="fas fa-chevron-left ml-1"></i>
            <span class="ml-2 text-sm font-medium">{{ trans('sidebar.minimize') }}</span>
          </a>
        </div>
      </div>

      <div class="mb-20"></div>

    </div>
    <!-- Component End  -->

</template>

<script setup>

import {trans} from "../i18n/i18n";
import {ref} from "vue";

const serversLinks = [
  {
    icon: 'fas fa-play',
    text: trans('sidebar.servers'),
    href: '#',
  }
]

const adminLinks = [
  {
    icon: 'fas fa-hdd',
    text: trans('sidebar.dedicated_servers'),
    href: '#',
  },
  {
    icon: 'fas fa-server',
    text: trans('sidebar.game_servers'),
    href: '#',
  },
  {
    icon: 'fas fa-gamepad',
    text: trans('sidebar.games'),
    href: '#',
  },
  {
    icon: 'fas fa-tasks',
    text: trans('sidebar.gdaemon_tasks'),
    href: '#',
  },
  {
    icon: 'fas fa-users',
    text: trans('sidebar.users'),
    href: '#',
  },
]

const gameapLinks = [
  {
    icon: 'fas fa-puzzle-piece',
    text: trans('sidebar.modules'),
    href: '#'
  },
  {
    icon: 'fas fa-sync',
    text: trans('sidebar.update'),
    href: '#'
  },
  {
    icon: 'fas fa-question',
    text: trans('sidebar.help'),
    href: '#'
  },
]

const minimized = ref(localStorage.getItem('leftMenuState') === 'small');

function toggleMinimized() {
  minimized.value = !minimized.value;

  document.querySelectorAll('.sidebar-menu').forEach((el) => {
    el.scrollTop = 0;
  })

  if (minimized.value) {
    localStorage.setItem('leftMenuState', 'small');
  } else {
    localStorage.setItem('leftMenuState', 'big');
  }
}

</script>

<style scoped>
/* Hide scrollbar for Chrome, Safari and Opera */
.no-scrollbar::-webkit-scrollbar {
  display: none;
}
/* Hide scrollbar for IE, Edge and Firefox */
.no-scrollbar {
  -ms-overflow-style: none;  /* IE and Edge */
  scrollbar-width: none;  /* Firefox */
}
</style>