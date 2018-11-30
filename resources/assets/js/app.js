/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

require('./parts/adminServerForm');
require('./parts/serverControl');

import Vuex from 'vuex';
import FileManager from 'gameap-file-manager'

Vue.use(Vuex);
const store = new Vuex.Store();
Vue.use(FileManager, {store});

import Progressbar from './components/Progressbar';
import InputTextList from './components/InputTextList';
import InputManyList from './components/InputManyList';
import ServerStatus from './components/ServerStatus';

var vm = new Vue({
    el: "#app",
    data: {
        actionConfirmed: false
    },
    components: {
        'progressbar': Progressbar,
        'input-text-list': InputTextList,
        'input-many-list': InputManyList,
        'server-status': ServerStatus,
    },
    methods: {
        alert: function(message) {
            bootbox.alert(message);
        },
        confirm: function(message, callback) {
            bootbox.confirm(message, function(result) {
                if (result) {
                    callback();
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
        }
    },
    store
});

import fontawesome from '@fortawesome/fontawesome-free';

window.gameap = vm.$root;