/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./parts/leftMenu');

import Vuex from 'vuex';
import vSelect from 'vue-select';

import store from './store'

import FileManager from 'gameap-file-manager';

import Progressbar from './components/Progressbar';

const InputTextList = () => import('./components/InputTextList' /* webpackChunkName: "components/input-text-list" */);
const InputManyList = () => import('./components/InputManyList' /* webpackChunkName: "components/input-many-list" */);
const ServerStatus = () => import('./components/ServerStatus' /* webpackChunkName: "components/server-status" */);
const ServerConsole = () => import('./components/ServerConsole' /* webpackChunkName: "components/server-console" */);
const TaskOutput = () => import('./components/TaskOutput' /* webpackChunkName: "components/task-output" */);
const UserServerPrivileges = () => import('./components/servers/UserServerPrivileges' /* webpackChunkName: "components/user-server-privileges" */);
const GameModSelector = () => import('./components/servers/GameModSelector' /* webpackChunkName: "components/game-mod-selector" */);
const DsIpSelector = () => import('./components/servers/DsIpSelector' /* webpackChunkName: "components/game-mod-selector" */);
const SmartPortSelector = () => import('./components/servers/SmartPortSelector' /* webpackChunkName: "components/smart-port-selector" */);

const SettingsParameters = () => import('./components/SettingsParameters' /* webpackChunkName: "components/user-server-privileges" */);

Vue.use(Vuex);

Vue.use(FileManager, {store: store, lang: document.documentElement.lang});

require('./parts/serverControl');

var vm = new Vue({
    el: "#app",
    data: {
        actionConfirmed: false
    },
    components: {
        'v-select': vSelect,
        'progressbar': Progressbar,
        'input-text-list': InputTextList,
        'input-many-list': InputManyList,
        'server-status': ServerStatus,
        'server-console': ServerConsole,
        'task-output': TaskOutput,

        'user-server-privileges': UserServerPrivileges,
        'smart-port-selector': SmartPortSelector,
        'settings-parameters': SettingsParameters,
        'game-mod-selector': GameModSelector,
        'ds-ip-selector': DsIpSelector,
    },
    methods: {
        alert: function(message, callback) {
            bootbox.alert(message, function() {
                if (typeof callback === "function") {
                    callback();
                }
            });
        },
        confirm: function(message, callback) {
            bootbox.confirm({
                message: message,
                buttons: {
                    confirm: {
                        label: this.trans('main.yes'),
                        className: 'btn-success'
                    },
                    cancel: {
                        label: this.trans('main.no'),
                        className: 'btn-danger'
                    }
                },
                callback: function(result) {
                    if (result) {
                        callback();
                    }
                }
            });
        },
        confirmAction: function (e, message) {
            if (!this.actionConfirmed) {
                e.preventDefault();

                this.confirm(message, function () {
                    this.actionConfirmed = true;
                    $(e.target).trigger(e.type);
                }.bind(this));
            }

            this.actionConfirmed = false;
        },
        mountProgressbar: function(mountPoint) {
            var progressbar = Vue.extend(this.$options.components.progressbar);
            return new progressbar().$mount(mountPoint);
        },
        appendComponent: function(componentName, appendPoint) {
            var component = Vue.extend(this.$options.components[componentName]);

            var componentInstance = new component().$mount();
            $(appendPoint).append(componentInstance.$el);
            return componentInstance;
        },
        increment () {
            store.commit('increment')
        },
        decrement () {
            store.commit('decrement')
        }
    },
    computed: {
        count () {
            return store.state.count
        }
    },
    store
});

import fontawesome from '@fortawesome/fontawesome-free';

window.gameap = vm.$root;