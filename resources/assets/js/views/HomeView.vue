<template>
    <div class="mt-4">
      <GButton class="px-8 py-8 bg-stone-50 hover:bg-stone-100 m-2 h-28 min-w-48" :route="{name: 'servers'}">
        <div class="text-lg">
          <i class="fa-solid fa-server"></i>
          {{ trans('servers.servers') }}
        </div>
        <div class="mt-3 grid grid-cols-2 content-center">
          <div class="text-xs text-lime-600">
            <div class="inline" v-if="!loading">
              <i class="fa-solid fa-heart-pulse"></i>:
            </div>
            <i v-if="loading" class="fa-solid fa-gear fa-spin"></i>
            <span v-else>{{ serverListStore.summary.online }}</span>
          </div>
          <div class="text-xs text-red-600">
            <div class="inline" v-if="!loading">
              <i class="fa-solid fa-skull"></i>:
            </div>
            <i v-if="loading" class="fa-solid fa-gear fa-spin"></i>
            <span v-else>{{ serverListStore.summary.offline }}</span>
          </div>
        </div>
      </GButton>

      <GButton v-if="isAdmin" class="px-8 py-8 bg-stone-50 hover:bg-stone-100 m-2 h-28 min-w-48" :route="{name: 'admin.nodes.index'}">
        <div class="text-lg">
          <i class="fa-solid fa-hard-drive"></i>
          {{ trans('dedicated_servers.nodes' )}}
        </div>
        <div class="mt-3 grid grid-cols-2 content-center">
          <div class="text-xs text-lime-600">
            <div class="inline" v-if="!loading">
              <i class="fa-solid fa-heart-pulse"></i>:
            </div>
            <i v-if="loading" class="fa-solid fa-gear fa-spin"></i>
            <span v-else>{{ nodeListStore.summary.online }}</span>
          </div>
          <div class="text-xs text-red-600">
            <div class="inline" v-if="!loading">
              <i class="fa-solid fa-power-off"></i>:
            </div>
            <i v-if="loading" class="fa-solid fa-gear fa-spin"></i>
            <span v-else>{{ nodeListStore.summary.offline }}</span>
          </div>
        </div>
      </GButton>
    </div>


  <div class="w-full mt-10 p-3 border border-stone-200 bg-stone-50 rounded-lg sm:p-4 dark:bg-stone-800 dark:border-stone-700">
    <div class="grid grid-cols-5 gap-4">
      <h5 class="col-span-3 text-base inline-block align-middle font-semibold text-stone-900 dark:text-white">
        <i class="fa-regular fa-comments mr-1"></i>
        {{ trans('home.channels') }}
      </h5>
      <div class="col-span-2">
        <a
            type="button"
            class="text-white bg-[#24A1DE] hover:bg-[#24A1DE]/90 focus:outline-none rounded text-sm px-2 py-1 text-center inline-flex items-center me-1 mb-1 mr-2"
            href="https://t.me/gameap"
            target="_blank"
        >
          <i class="fa-brands fa-telegram mr-1"></i>
          Telegram
        </a>

        <a
            type="button"
            class="text-white bg-[#7289da] hover:bg-[#7289da]/90 focus:outline-none rounded text-sm px-2 py-1 text-center inline-flex items-center me-1 mb-1 mr-2"
            href="https://discord.gg/SqtHpZc"
            target="_blank"
        >
          <i class="fa-brands fa-discord mr-1"></i>
          Discord
        </a>

        <a
            v-if="pageLanguage() === 'ru'"
            type="button"
            class="text-white bg-[#0077FF] hover:bg-[#0077FF]/90 focus:outline-none rounded text-sm px-2 py-1 text-center inline-flex items-center me-1 mb-1 mr-2"
            href="https://vk.com/gameap"
            target="_blank"
        >
          <i class="fa-brands fa-vk mr-1"></i>
          VKontakte
        </a>

      </div>
    </div>
  </div>

  <div class="w-full mt-5 p-3 border border-stone-200 bg-stone-50 rounded-lg sm:p-4 dark:bg-stone-800 dark:border-stone-700">
    <div class="grid grid-cols-5 gap-4">
      <h5 class="col-span-3 text-base inline-block align-middle font-semibold text-stone-900 dark:text-white">
        <i class="fa-regular fa-heart mr-1"></i>
        {{ trans('home.support_gameap') }}
      </h5>
      <div class="col-span-2">
        <a
            type="button"
            class="text-white bg-[#F96854] hover:bg-[#F96854]/90 focus:outline-none rounded text-sm px-2 py-1 text-center inline-flex items-center me-1 mb-1 mr-2"
            href="https://www.patreon.com/gameap"
            target="_blank"
        >
          <i class="fa-brands fa-patreon mr-1"></i>
          Patreon
        </a>
      </div>
    </div>
  </div>

  <div class="w-full mt-5 p-3 border border-stone-200 bg-stone-50 rounded-lg sm:p-4 dark:bg-stone-800 dark:border-stone-700">
    <div class="grid grid-cols-5 gap-4">
      <h5 class="col-span-3 text-base inline-block align-middle font-semibold text-stone-900 dark:text-white">
        <i class="fa-regular fa-circle-question mr-1"></i>
        {{ trans('home.need_help') }}
      </h5>
      <div class="col-span-2">
        <a
            type="button"
            class="text-white bg-sky-500 hover:bg-sky-400 focus:outline-none rounded text-sm px-2 py-1 text-center inline-flex items-center me-1 mb-1 mr-2"
            :href=" (pageLanguage() === 'ru') ? 'https://docs.gameap.com/ru/' : 'https://docs.gameap.com/en/'"
            target="_blank"
        >
          <i class="fa-solid fa-book mr-1"></i>
          {{ trans('home.documentation') }}
        </a>

        <a
            type="button"
            class="text-white bg-sky-500 hover:bg-sky-400 focus:outline-none rounded text-sm px-2 py-1 text-center inline-flex items-center me-1 mb-1 mr-2"
            href="https://openapi.gameap.io/"
            target="_blank"
        >
          <i class="fa-solid fa-book mr-1"></i>
          {{ trans('home.api_documentation') }}
        </a>

        <a
            type="button"
            class="text-white bg-[#7289da] hover:bg-[#7289da]/90 focus:outline-none rounded text-sm px-2 py-1 text-center inline-flex items-center me-1 mb-1 mr-2"
            href="https://discord.gg/SqtHpZc"
            target="_blank"
        >
          <i class="fa-brands fa-discord mr-1"></i>
          Discord
        </a>
      </div>
    </div>
  </div>
</template>

<script setup>
import {computed, onMounted} from "vue"
import GButton from "../components/GButton.vue"
import {useAuthStore} from "../store/auth"
import {useNodeListStore} from "../store/nodeList"
import {useServerListStore} from "../store/serverList"
import {trans, pageLanguage} from "../i18n/i18n";

const authStore = useAuthStore()
const nodeListStore = useNodeListStore()
const serverListStore = useServerListStore()

const isAdmin = computed(() => {
  return authStore.isAdmin
})

const loading = computed(() => {
  return serverListStore.loading || nodeListStore.loading
})

onMounted(() => {
  fetchServersSummary()

  if (isAdmin.value) {
    fetchNodesSummary()
  }
})

const fetchServersSummary = () => {
  serverListStore.fetchServersSummary().catch((error) => {
    errorNotification(error)
  })
}

const fetchNodesSummary = () => {
  nodeListStore.fetchNodesSummary().catch((error) => {
    errorNotification(error)
  })
}

</script>