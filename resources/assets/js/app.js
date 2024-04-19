/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import {createApp, h} from "vue";
import {defineAsyncComponent} from 'vue'

import {
    create,
    NAlert,
    NButton,
    NCard,
    NCollapse,
    NCollapseItem,
    NDatePicker,
    NDataTable,
    NDialog,
    NDialogProvider,
    NEmpty,
    NMessageProvider,
    NModal,
    NProgress,
    NSelect,
    NTable,
    NTabs,
    NTabPane,
    NTooltip,
} from 'naive-ui'

import './bootstrap';

import './parts/form'
import {alert, confirmAction, confirm} from './parts/dialogs'

import {pluralize, trans} from "./i18n/i18n";

import store from './store'

import GBreadcrumbs from "./components/GBreadcrumbs.vue";
import GButton from "./components/GButton.vue";

import MainNavbar from './components/MainNavbar.vue';
import MainSidebar from './components/MainSidebar.vue';

import ContentView from './components/ContentView.vue';

const InputTextList = defineAsyncComponent(() =>
    import('./components/input/InputTextList.vue' /* webpackChunkName: "components/input" */)
)

const InputManyList = defineAsyncComponent(() =>
    import('./components/input/InputManyList.vue' /* webpackChunkName: "components/input" */)
)

const GameapSelect = defineAsyncComponent(() =>
    import('./components/input/GameapSelect.vue' /* webpackChunkName: "components/input" */)
)

import fileManager from 'gameap-file-manager';

const ServerStatus = defineAsyncComponent(() =>
    import('./components/ServerStatus.vue' /* webpackChunkName: "components/server" */)
)

const ServerConsole = defineAsyncComponent(() =>
    import('./components/ServerConsole.vue' /* webpackChunkName: "components/server" */)
)

const ServerTasks = defineAsyncComponent(() =>
    import('./components/ServerTasks.vue' /* webpackChunkName: "components/server" */)
)

const ServerControlButton = defineAsyncComponent(() =>
    import('./components/ServerControlButton.vue' /* webpackChunkName: "components/server" */)
)

const ServerMainList = defineAsyncComponent(() =>
    import('./components/ServerMainList.vue' /* webpackChunkName: "components/server" */)
)

const TaskOutput = defineAsyncComponent(() =>
    import('./components/TaskOutput.vue' /* webpackChunkName: "components/task-output" */)
)

const UserServerPrivileges = defineAsyncComponent(() =>
    import('./components/servers/UserServerPrivileges.vue' /* webpackChunkName: "components/user-server-privileges" */)
)

const GameModSelector = defineAsyncComponent(() =>
    import('./components/servers/GameModSelector.vue' /* webpackChunkName: "components/game-mod-selector" */)
)

const DsIpSelector = defineAsyncComponent(() =>
    import('./components/servers/DsIpSelector.vue' /* webpackChunkName: "components/game-mod-selector" */)
)

const SmartPortSelector = defineAsyncComponent(() =>
    import('./components/servers/SmartPortSelector.vue' /* webpackChunkName: "components/smart-port-selector" */)
)

const ServerSelector = defineAsyncComponent(() =>
    import('./components/servers/ServerSelector.vue' /* webpackChunkName: "components/server" */)
)

const RconPlayers = defineAsyncComponent(() =>
    import('./components/rcon/RconPlayers.vue' /* webpackChunkName: "components/rcon" */)
)

const RconConsole = defineAsyncComponent(() =>
    import('./components/rcon/RconConsole.vue' /* webpackChunkName: "components/rcon" */)
)

const SettingsParameters = defineAsyncComponent(() =>
    import('./components/SettingsParameters.vue' /* webpackChunkName: "components/settings" */)
)

const setActiveTab = (tab) => {
    store.dispatch('activeTab/setName', tab);
}

const app = createApp({
    components: {
        GBreadcrumbs,
        GButton,
        MainNavbar,
        MainSidebar,
        ContentView,
        DsIpSelector,
        GameModSelector,
        GameapSelect,
        InputManyList,
        InputTextList,
        RconConsole,
        RconPlayers,
        ServerConsole,
        ServerControlButton,
        ServerMainList,
        ServerSelector,
        ServerStatus,
        ServerTasks,
        SettingsParameters,
        SmartPortSelector,
        TaskOutput,
        UserServerPrivileges,
    },
    setup: () => {

    },
    methods: {
        alert: alert,
        confirm: confirm,
        confirmAction: confirmAction,
        // mountProgressbar(mountPoint) {
        //     const ProgressbarComponent = app.component('Progressbar');
        //     return app.mount(ProgressbarComponent, mountPoint);
        // },
        setActiveTab: setActiveTab,
    },
    computed: {
        activeTab: {
            get() { return store.state.activeTab.name; },
            set(tab) { store.dispatch('activeTab/setName', tab) },
        },
    },
})

app.config.globalProperties.pluralize = pluralize;
app.config.globalProperties.trans = trans;

const naive = create({
    components: [
        NAlert,
        NButton,
        NCard,
        NCollapse,
        NCollapseItem,
        NDialog,
        NDataTable,
        NDatePicker,
        NDialogProvider,
        NEmpty,
        NMessageProvider,
        NModal,
        NProgress,
        NSelect,
        NTable,
        NTabs,
        NTabPane,
        NTooltip,
    ],
})

app.use(store)
app.use(naive)

app.use(fileManager, {store: store})

const meta = document.createElement('meta')
meta.name = 'naive-ui-style'
document.head.appendChild(meta)

app.mount("#app")

window.gameap = app
window.gameap.alert = alert
window.gameap.confirm = confirm
window.gameap.confirmAction = confirmAction
window.gameap.setActiveTab = setActiveTab
window.gameap.$store = store;
window.h = h;
