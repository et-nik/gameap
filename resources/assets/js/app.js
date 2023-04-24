/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import {createApp} from "vue";
import {defineAsyncComponent} from 'vue'

import {
    create,
    NSelect,
    NDatePicker,
} from 'naive-ui'

import './bootstrap';

import './parts/leftMenu.js'

import {pluralize, trans} from "./i18n/i18n";

import store from './store'

const InputTextList = defineAsyncComponent(() =>
    import('./components/InputTextList.vue' /* webpackChunkName: "components/input" */)
)

const InputManyList = defineAsyncComponent(() =>
    import('./components/InputManyList.vue' /* webpackChunkName: "components/input" */)
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

// Vue.use(Vuex);

const alert = function(message, callback) {
    bootbox.alert(message, () => {
        if (typeof callback === "function") {
            callback();
        }
    });
}

const confirm = function(message, callback) {
    bootbox.confirm({
        message: message,
        buttons: {
            confirm: {
                label: trans('main.yes'),
                className: 'btn-success'
            },
            cancel: {
                label: trans('main.no'),
                className: 'btn-danger'
            }
        },
        callback: (result) => {
            if (result) {
                callback();
            }
        }
    });
}

let actionConfirmed = false;
const confirmAction = (e, message) => {
    if (!actionConfirmed) {
        e.preventDefault();

        confirm(message, () => {
            actionConfirmed = true;
            $(e.target).trigger(e.type);
        });
    }

    actionConfirmed = false;
}

const setActiveTab = function() {
    store.commit('activeTab');
}

const app = createApp({
    components: {
        Progressbar,
        InputTextList,
        InputManyList,
        ServerStatus,
        ServerConsole,
        ServerTasks,
        TaskOutput,
        RconPlayers,
        RconConsole,
        UserServerPrivileges,
        SmartPortSelector,
        SettingsParameters,
        GameModSelector,
        DsIpSelector,
        ServerSelector,
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
        NSelect,
        NDatePicker,
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
