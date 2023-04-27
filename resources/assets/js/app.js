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
    NDatePicker,
    NDialog,
    NDialogProvider,
    NMessageProvider,
    NModal,
    NSelect,
    NTooltip,
} from 'naive-ui'

import './bootstrap';

import './parts/leftMenu'
import './parts/form'

import {pluralize, trans} from "./i18n/i18n";

import store from './store'

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

import Progressbar from './components/Progressbar.vue';

const ServerStatus = defineAsyncComponent(() =>
    import('./components/ServerStatus.vue' /* webpackChunkName: "components/server" */)
)

const ServerConsole = defineAsyncComponent(() =>
    import('./components/ServerConsole.vue' /* webpackChunkName: "components/server" */)
)

const ServerTasks = defineAsyncComponent(() =>
    import('./components/ServerTasks.vue' /* webpackChunkName: "components/server" */)
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

const alert = function(message, callback) {
    window.$dialog.error({
        title: message,
        content: "",
        positiveText: trans('main.close'),
        onPositiveClick: () => {
            if (typeof callback === "function") {
                callback();
            }
        },
    });
}

let actionConfirmed = false;
const confirmAction = (e, message) => {
    if (!actionConfirmed) {
        e.preventDefault();

        confirm(message, () => {
            const clonedEvent = new e.constructor(e.type, e);
            e.target.dispatchEvent(clonedEvent);
        });
    }
}

const confirm = (message, callback) => {
    window.$dialog.success({
        title: message,
        content: "",
        positiveText: trans('main.yes'),
        negativeText: trans('main.no'),
        onPositiveClick: () => {
            actionConfirmed = true
            if (typeof callback === "function") {
                callback();
            }
        },
        onNegativeClick: () => {
            actionConfirmed = false
        }
    });
}

const setActiveTab = (tab) => {
    store.dispatch('activeTab/setName', tab);
}

const app = createApp({
    components: {
        ContentView,
        DsIpSelector,
        GameModSelector,
        GameapSelect,
        InputManyList,
        InputTextList,
        Progressbar,
        RconConsole,
        RconPlayers,
        ServerConsole,
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
        mountProgressbar(mountPoint) {
            const ProgressbarComponent = app.component('Progressbar');
            return app.mount(ProgressbarComponent, mountPoint);
        },
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
        NDialog,
        NDatePicker,
        NDialogProvider,
        NMessageProvider,
        NModal,
        NSelect,
        NTooltip,
    ],
})

app.use(store)
app.use(naive)

app.use(fileManager, {store: store})

app.mount("#app")

window.gameap = app
window.gameap.alert = alert
window.gameap.confirm = confirm
window.gameap.confirmAction = confirmAction
window.gameap.setActiveTab = setActiveTab
window.gameap.$store = store;
window.h = h;
