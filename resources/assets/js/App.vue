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
import {computed} from "vue";
import {useAuthStore} from "./store/auth";
import {
  NConfigProvider,
  NDialogProvider,
  NMessageProvider,
  ruRU,
  enUS,
} from "naive-ui"
import MainNavbar from "./components/MainNavbar.vue";
import GuestNavbar from "./components/GuestNavbar.vue";
import MainSidebar from "./components/MainSidebar.vue";
import ContentView from "./components/ContentView.vue";
import {pageLanguage} from "./i18n/i18n";

const authStore = useAuthStore()

const user = computed(() => {
  return authStore.user
})

</script>