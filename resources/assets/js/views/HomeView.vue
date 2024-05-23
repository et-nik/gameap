<template>
    <div class="mt-4">
      <GButton class="px-8 py-8 bg-stone-50 hover:bg-stone-100 m-2 h-28" :route="{name: 'servers'}">
        <div class="text-lg">
          <i class="fa-solid fa-server"></i>
          Servers
        </div>
        <div class="mt-3 grid grid-cols-2 content-center">
          <div class="text-xs text-lime-600"><i class="fa-solid fa-heart-pulse"></i>: 4</div>
          <div class="text-xs text-red-600"><i class="fa-solid fa-power-off "></i>: 2</div>
        </div>
      </GButton>

      <GButton v-if="isAdmin" class="px-8 py-8 bg-stone-50 hover:bg-stone-100 m-2 h-28" :route="{name: 'admin.nodes.index'}">
        <div class="text-lg">
          <i class="fa-solid fa-hard-drive"></i>
          Nodes
        </div>
        <div class="mt-3 content-center">
          <span class="text-xs badge-light">
            4
          </span>
        </div>
      </GButton>
    </div>


  <div class="w-full mt-10 p-3 border border-stone-200 bg-stone-50 rounded-lg sm:p-4 dark:bg-stone-800 dark:border-stone-700">
    <div class="grid grid-cols-3 gap-4">
      <h5 class="text-base inline-block align-middle font-semibold text-stone-900 dark:text-white">
        <i class="fa-regular fa-comments mr-1"></i>
        Channels
      </h5>
      <div>
      </div>
      <div>
        <button type="button" class="text-white bg-[#24A1DE] hover:bg-[#24A1DE]/90 focus:outline-none rounded text-sm px-2 py-1 text-center inline-flex items-center me-1 mb-1 mr-2">
          <i class="fa-brands fa-telegram mr-1"></i>
          Telegram
        </button>

        <button type="button" class="text-white bg-[#7289da] hover:bg-[#7289da]/90 focus:outline-none rounded text-sm px-2 py-1 text-center inline-flex items-center me-1 mb-1 mr-2">
          <i class="fa-brands fa-discord mr-1"></i>
          Discord
        </button>
      </div>
    </div>
  </div>

  <div class="w-full mt-5 p-3 border border-stone-200 bg-stone-50 rounded-lg sm:p-4 dark:bg-stone-800 dark:border-stone-700">
    <div class="grid grid-cols-3 gap-4">
      <h5 class="text-base inline-block align-middle font-semibold text-stone-900 dark:text-white">
        <i class="fa-regular fa-heart mr-1"></i>
        Support GameAP
      </h5>
      <div>
      </div>
      <div>
        <button type="button" class="text-white bg-[#24A1DE] hover:bg-[#24A1DE]/90 focus:outline-none rounded text-sm px-2 py-1 text-center inline-flex items-center me-1 mb-1 mr-2">
          <i class="fa-brands fa-telegram mr-1"></i>
          Telegram
        </button>

        <button type="button" class="text-white bg-[#7289da] hover:bg-[#7289da]/90 focus:outline-none rounded text-sm px-2 py-1 text-center inline-flex items-center me-1 mb-1 mr-2">
          <i class="fa-brands fa-discord mr-1"></i>
          Discord
        </button>
      </div>
    </div>
  </div>

  <div class="w-full mt-5 p-3 border border-stone-200 bg-stone-50 rounded-lg sm:p-4 dark:bg-stone-800 dark:border-stone-700">
    <div class="grid grid-cols-3 gap-4">
      <h5 class="text-base inline-block align-middle font-semibold text-stone-900 dark:text-white">
        <i class="fa-regular fa-circle-question mr-1"></i>
        Need help?
      </h5>
      <div>
      </div>
      <div>
        <button type="button" class="text-white bg-sky-500 hover:bg-sky-400 focus:outline-none rounded text-sm px-2 py-1 text-center inline-flex items-center me-1 mb-1 mr-2">
          <i class="fa-solid fa-book mr-1"></i>
          Documentation
        </button>

        <button type="button" class="text-white bg-[#7289da] hover:bg-[#7289da]/90 focus:outline-none rounded text-sm px-2 py-1 text-center inline-flex items-center me-1 mb-1 mr-2">
          <i class="fa-brands fa-discord mr-1"></i>
          Discord
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import {computed} from "vue"
import GButton from "../components/GButton.vue"
import {useAuthStore} from "../store/auth";

const authStore = useAuthStore()

const isAdmin = computed(() => {
  return authStore.isAdmin
})
</script>