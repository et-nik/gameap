
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');

require('./parts/adminServerForm');
require('./parts/serverControl');

var vm = new Vue({
    el: "#app",
    data: {
        actionConfirmed: false
    },
    components: {'progressbar': require('./components/progressbar.vue')},
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
            /*
            // Default
            if (!confirm(message)) {
                event.preventDefault();
            }
            */

            if (!this.actionConfirmed) {
                e.preventDefault();

                this.confirm(message, function () {
                    this.actionConfirmed = true;
                    $(e.target).trigger(e.type);
                }.bind(this));
            }

            this.actionConfirmed = false;
        },
        mountProgressbar: function(mount) {
            var progressbar = Vue.extend(this.$options.components.progressbar);
            return new progressbar().$mount(mount);
        }
    }
});

window.gameap = vm.$root;