<template>
    <!-- Component Start -->
    <div v-if="minimized === true" class="items-center w-16 mr-5"></div>
    <div v-if="minimized === true" class="sidebar-menu fixed items-center w-16 h-full overflow-y-scroll no-scrollbar text-stone-400 bg-stone-900">
        <a class="flex items-center w-full px-3 mt-3" href="#">
          <span class="ml-2 w-full text-center text-sm font-bold">—</span>
        </a>

        <div class="w-full px-2">
          <div class="flex flex-col items-center w-full mb-3 border-stone-700">
            <router-link v-for="link in serversLinks" :to="link.route" class="flex items-center transition transform w-full h-10 px-3 mt-2 bg-stone-800 hover:translate-x-2">
              <i :class="link.icon" class="ml-1"></i>
            </router-link>
          </div>
        </div>

        <a v-if="isAdmin" class="flex items-center w-full px-3 mt-3" href="#">
          <span class="ml-2 w-full text-center text-sm font-bold">—</span>
        </a>

        <div v-if="isAdmin" class="w-full px-2">
          <div class="flex flex-col items-center w-full mb-3 border-stone-700">
            <router-link v-for="link in adminLinks" :to="link.route" class="flex items-center transition transform w-full h-10 px-3 mt-2 bg-stone-800 hover:translate-x-2">
              <i :class="link.icon" class="ml-1"></i>
            </router-link>
          </div>
        </div>

        <div class="w-full px-2 mt-3">
          <div class="flex flex-col items-center w-full mb-3 border-stone-700">
            <a v-on:click="toggleMinimized" class="flex items-center transition transform w-full h-10 px-3 mt-2 bg-stone-800 hover:translate-x-2">
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
          <template v-for="link in serversLinks">
            <router-link :to="link.route" class="flex items-center transition transform w-full h-10 px-3 mt-2 bg-stone-800 hover:translate-x-2">
              <i :class="link.icon" class="ml-1"></i>
              <span class="ml-2 text-sm font-medium">{{ link.text }}</span>
            </router-link>
          </template>
        </div>
      </div>

      <a v-if="isAdmin" class="flex items-center w-full px-3 mt-3" href="#">
        <span class="ml-2 w-full text-center text-sm font-bold">{{ trans('sidebar.admin') }}</span>
      </a>

      <div v-if="isAdmin" class="w-full px-2">
        <div class="flex flex-col items-center w-full mb-3 border-stone-700">
          <router-link v-for="link in adminLinks" :to="link.route" class="flex items-center transition transform w-full h-10 px-3 mt-2 bg-stone-800 hover:translate-x-2">
            <i :class="link.icon" class="ml-1"></i>
            <span class="ml-2 text-sm font-medium">{{ link.text }}</span>
          </router-link>
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
import {ref, computed} from "vue";
import {adminLinks, serversLinks} from "./bars";
import {useAuthStore} from "../store/auth";

const authStore = useAuthStore()

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

const isAdmin = computed(() => {
  return authStore.isAdmin
})
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