<template>
  <GBreadcrumbs :items="breadcrumbs"></GBreadcrumbs>

  <n-tabs type="line" class="flex justify-between" animated>
    <n-tab-pane name="control">
      <template #tab>
        <i class="fas fa-play mr-1"></i>
        {{ trans('servers.control') }}
      </template>

      <div class="flex flex-wrap mt-2">
        <div class="md:w-full">
          <n-card
              class="mb-3"
          >
            <Loading v-if="loading"></Loading>
            <ServerStatus v-if="!loading" :server-id="serverId"></ServerStatus>
          </n-card>
        </div>
      </div>

      <div class="flex flex-wrap mt-2">
        <div class="md:w-1/2 pr-8">
          <n-card
              :title="trans('servers.commands')"
              class="mb-3"
              header-class="bg-stone-100"
              :segmented="{
                          content: true,
                          footer: 'soft'
                        }"
          >
            <Loading v-if="loading"></Loading>
            <div v-if="!loading" id="serverControl">
              <ServerControlButton
                  command="start"
                  v-if="serverStore.canStart && !serverOnline"
                  :server-id="serverId"
                  button="m-1"
                  button-color="green"
                  icon="fas fa-play"
                  :text="trans('servers.start')"
              ></ServerControlButton>

              <ServerControlButton
                  command="stop"
                  v-if="serverStore.canStop && serverOnline"
                  :server-id="serverId"
                  button="m-1"
                  button-color="red"
                  icon="fas fa-stop"
                  :text="trans('servers.stop')"
              ></ServerControlButton>

              <ServerControlButton
                  command="restart"
                  v-if="serverStore.canRestart"
                  :server-id="serverId"
                  button="m-1"
                  button-color="orange"
                  icon="fas fa-redo"
                  :text="trans('servers.restart')"
              ></ServerControlButton>

              <ServerControlButton
                  command="update"
                  v-if="serverStore.canUpdate"
                  :server-id="serverId"
                  button="m-1"
                  button-color="black"
                  icon="fas fa-sync"
                  :text="trans('servers.update')"
              ></ServerControlButton>

              <ServerControlButton
                  command="reinstall"
                  v-if="serverStore.canUpdate"
                  :server-id="serverId"
                  button="m-1"
                  button-color="black"
                  icon="fas fa-reply-all"
                  :text="trans('servers.reinstall')"
              ></ServerControlButton>
            </div>
          </n-card>
        </div>

        <div class="md:w-1/2">
          <n-card
              :title="trans('servers.process_status')"
              class="mb-3"
              header-class="bg-stone-100"
              :segmented="{
                          content: true,
                          footer: 'soft'
                        }"
          >
            <Loading v-if="loading"></Loading>
            <ul v-if="!loading" class="flex flex-col pl-0 mb-0">
              <li v-if="serverOnline" class="relative block py-3 px-6 -mb-px">
                {{ trans('servers.status') }}: <span class="badge-green">{{ trans('servers.active') }}</span>
              </li>
              <li v-else class="relative block py-3 px-6 -mb-px">
                {{ trans('servers.status') }}: <span class="badge-red">{{ trans('servers.inactive') }}</span>
              </li>

              <li class="relative block py-3 px-6 -mb-px">{{ trans('servers.last_check') }}: </li>
            </ul>
          </n-card>
        </div>
      </div>

      <div class="flex flex-wrap mt-2" v-if="serverStore.canReadConsole">
        <div class="md:w-full">
          <n-card
              :title="trans('servers.console')"
              class="mb-3"
              header-class="bg-stone-100"
              :segmented="{
                          content: true,
                          footer: 'soft'
                        }"
          >
            <Loading v-if="loading"></Loading>
            <ServerConsole
                v-if="!loading"
                :console-hostname="server?.name"
                :server-id="serverId"
                :server-active="server?.online"
                :send-command-available="serverStore.canSendConsole"
            >
            </ServerConsole>
          </n-card>
        </div>
      </div>

    </n-tab-pane>

    <n-tab-pane name="rcon" v-if="rconTabPossible">
      <template #tab>
        <i class="fas fa-user-astronaut mr-1"></i>
        RCON
      </template>

      <div class="flex flex-wrap mt-2">
        <div class="md:w-full">
          <div :class="'grid ' + (rconSupportedFeatures.playersManage ? 'grid-cols-2' : 'grid-cols-1')">
            <div v-if="rconSupportedFeatures.playersManage" class="pr-8">
              <n-card
                  :title="trans('rcon.players_manage')"
                  class="mb-3"
                  header-class="bg-stone-100"
                  :segmented="{
                      content: true,
                      footer: 'soft'
                    }">
                <Loading v-if="loading"></Loading>
                <rcon-players :server-id="serverId" v-if="!loading">
                </rcon-players>
              </n-card>
            </div>

            <div>
              <n-card
                  :title="trans('rcon.console')"
                  class="mb-3"
                  header-class="bg-stone-100"
                  :segmented="{
                      content: true,
                      footer: 'soft'
                    }">
                <Loading v-if="loading"></Loading>
                <rcon-console :server-id="serverId" v-if="!loading">
                </rcon-console>
              </n-card>
            </div>

          </div>
        </div>
      </div>
    </n-tab-pane>

    <n-tab-pane name="files" v-if="serverStore.canManageFiles">
      <template #tab>
        <i class="fa fa-folder-open mr-1"></i>
        {{ trans('servers.files') }}
      </template>

      <div class="flex flex-wrap mt-2">
        <div class="md:w-full">
          <div class="flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300 p-2">
            <file-manager
                :settings="{
                    'baseUrl': '/file-manager/'+$route.params.id,
                    'headers':{
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                }"
            />
          </div>
        </div>
      </div>
    </n-tab-pane>

    <n-tab-pane name="schedules" v-if="serverStore.canManageTasks">
      <template #tab>
        <i class="far fa-calendar-alt mr-1"></i>
        {{ trans('servers.task_scheduler') }}
      </template>

      <ServerTasks
          :server-id="serverId"
          :privileges="privileges"
      ></ServerTasks>
    </n-tab-pane>

    <n-tab-pane name="settings" v-if="serverStore.canManageSettings">
      <template #tab>
        <i class="fa fa-cogs mr-1"></i>
        {{ trans('servers.settings') }}
      </template>

      <div class="flex flex-wrap mt-2">
        <div class="md:w-full">
          <n-card class="mb-3">
            <div>
              <ServerSettings :class="loading ? 'opacity-20' : ''"></ServerSettings>
              <Loading v-if="loading" class="absolute inset-0 flex justify-center items-center z-10"></Loading>
            </div>
          </n-card>
        </div>
      </div>
    </n-tab-pane>

    <template #suffix v-if="isAdmin">
      <div class="order-last ml-auto text-red-500 hover:text-red-600">
        <router-link :to="{name: 'admin.servers.edit', params: {id: serverId}}">
          <i class="fa fa-hammer mr-1"></i>
          {{ trans('servers.admin') }}
        </router-link>
      </div>
    </template>

  </n-tabs>
</template>

<script setup>
import {computed, defineAsyncComponent, onMounted} from "vue";
import {useRoute} from "vue-router";
import {storeToRefs} from "pinia";

const ServerStatus = defineAsyncComponent(() =>
    import('./servertabs/ServerStatus.vue' /* webpackChunkName: "components/server" */)
)

const ServerTasks = defineAsyncComponent(() =>
    import('./servertabs/ServerTasks.vue' /* webpackChunkName: "components/server" */)
)

const ServerControlButton = defineAsyncComponent(() =>
    import('./servertabs/ServerControlButton.vue' /* webpackChunkName: "components/server" */)
)

const ServerConsole = defineAsyncComponent(() =>
    import('./servertabs/ServerConsole.vue' /* webpackChunkName: "components/server" */)
)

const ServerSettings = defineAsyncComponent(() =>
    import('./servertabs/ServerSettings.vue' /* webpackChunkName: "components/server" */)
)

const RconPlayers = defineAsyncComponent(() =>
    import('../components/rcon/RconPlayers.vue' /* webpackChunkName: "components/rcon" */)
)

const RconConsole = defineAsyncComponent(() =>
    import('../components/rcon/RconConsole.vue' /* webpackChunkName: "components/rcon" */)
)

import GBreadcrumbs from "../components/GBreadcrumbs.vue";
import Loading from "../components/Loading.vue";

import {useServerStore} from "../store/server"
import {useAuthStore} from "../store/auth";
import {trans} from "../i18n/i18n";

const route = useRoute()
const serverStore = useServerStore()
const authStore = useAuthStore()

const {
  loading,
  serverId,
  server,
  rconSupportedFeatures,
} = storeToRefs(serverStore)

onMounted(() => {
  serverStore.setServerId(Number(route.params.id))
  serverStore.fetchServer()
  serverStore.fetchAbilities()
  serverStore.fetchRconSupportedFeatures()
});

const privileges = computed(() => {
  return {
    'start': serverStore.canStart,
    'stop': serverStore.canStop,
    'restart': serverStore.canRestart,
    'update': serverStore.canUpdate,
  }
})

const serverOnline = computed(() => {
  return Boolean(server.value?.online)
})

const rconTabPossible = computed(() => {
  return (rconSupportedFeatures.value.rcon || rconSupportedFeatures.value.playersManage) &&
      serverStore.canUseRcon &&
      serverOnline.value
})

const breadcrumbs = computed(() => {
  const bc = [
    {'route':'/', 'text':'GameAP', 'icon': 'gicon gicon-gameap'},
    {'route':{name: 'servers'}, 'text':trans('servers.game_servers')},
  ]

  if (server.value?.name) {
    bc.push({'text': server.value.name})
  }

  return bc
})

const isAdmin = computed(() => {
  return authStore.isAdmin
})

</script>