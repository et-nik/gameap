<template>
  <n-config-provider
      :locale="pageLanguage() === 'ru' ? ruRU : enUS"
      :theme-overrides='{
                  "common": {
                    "primaryColor": "#84cc16",
                    "primaryColorHover": "#65a30d",
                    "primaryColorPressed": "#65a30d",
                    "successColor": "#84CC16FF",
                    "successColorHover": "#65A30DFF",
                    "successColorPressed": "#65A30DFF",
                    "successColorSuppl": "#65A30DFF",
                    "warningColor": "#fb923cFF",
                    "warningColorHover": "#f97316FF",
                    "warningColorPressed": "#f97316FF",
                    "warningColorSuppl": "#f97316FF",
                    "errorColor": "#ef4444FF",
                    "errorColorHover": "#dc2626ff",
                    "errorColorPressed": "#dc2626ff",
                    "errorColorSuppl": "#dc2626ff",
                    "tableHeaderColor": "#f5f5f4ff"
                  },
                  "Tabs": {
                    "tabTextColorLine": "#78716c",
                    "tabTextColorActiveLine": "#1c1917",
                    "tabTextColorHoverLine": "#1c1917",
                    "barColor": "#1c1917"
                  }
            }'>
    <n-dialog-provider>
      <n-message-provider>
        <div v-if="user">
          <main-navbar></main-navbar>

          <div id="main-section" class="mt-16 mr-5 sm:flex">
            <div class="sm:visible invisible flex-none">
              <main-sidebar></main-sidebar>
            </div>

            <div class="sm:flex-1">
              <div class="max-w-full">
                <div class="pt-3 pb-5 content">
                  <content-view></content-view>

                  <div v-if="!$route.name">
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-else>
          <guest-navbar></guest-navbar>

          <div id="main-section" class="mt-16 mr-5 sm:flex">
            <div class="sm:flex-1">
              <div class="max-w-full">
                <div class="pt-3 pb-5 content">
                  <content-view></content-view>
                </div>
              </div>
            </div>
          </div>
        </div>
      </n-message-provider>
    </n-dialog-provider>
  </n-config-provider>

</template>

<script setup>
import {computed, ref} from "vue"
import {
  NConfigProvider,
  NDialogProvider,
  NMessageProvider,
  ruRU,
  enUS,
} from "naive-ui"
import MainNavbar from "./components/MainNavbar.vue"
import GuestNavbar from "./components/GuestNavbar.vue"
import MainSidebar from "./components/MainSidebar.vue"
import ContentView from "./components/ContentView.vue"
import {pageLanguage} from "./i18n/i18n"

import {useRoute, useRouter} from "vue-router"

import {useAuthStore} from "./store/auth"
import {useNodeStore} from "./store/node"
import {useDaemonTaskStore} from "./store/daemonTask"
import {useGameStore} from "./store/game"
import {useServerStore} from "./store/server"
import {useUserStore} from "./store/user"

const route = useRoute()
const router = useRouter()

const authStore = useAuthStore()
const nodeStore = useNodeStore()
const daemonTaskStore = useDaemonTaskStore()
const gameStore = useGameStore()
const serverStore = useServerStore()
const userStore = useUserStore()

const user = computed(() => {
  return authStore.user
})


const onAnyStoreAction = ({
  name, // name of the action
  store, // store instance, same as `someStore`
  args, // array of parameters passed to the action
  after, // hook after the action returns or resolves
  onError, // hook if the action throws or rejects
}) => {
  onError((error) => {

    if (error.response && error.response.status) {
      console.log(error.response)
      console.log(error.response.status)

      switch (error.response.status) {
        case 401:
          authStore.logout()
          router.push({name: 'login'})
          break
        case 403:
          router.push({name: 'error403'})
          break
        case 404:
          router.push({name: 'error404'})
          break
      }
    }
  })
}

nodeStore.$onAction(onAnyStoreAction)
daemonTaskStore.$onAction(onAnyStoreAction)
gameStore.$onAction(onAnyStoreAction)
serverStore.$onAction(onAnyStoreAction)
userStore.$onAction(onAnyStoreAction)

</script>