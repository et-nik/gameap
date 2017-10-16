
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
bootbox = require('bootbox');

window.Vue = require('vue');

require('./adminServerForm');

var app = new Vue({
    el: "#app",
    data: {
        actionConfirmed: false
    },
    methods: {
        confirmAction: function (e, message) {
            /*
            // Default
            if (!confirm(message)) {
                event.preventDefault();
            }
            */

            if (!this.actionConfirmed) {
                e.preventDefault();

                bootbox.confirm(message, function (result) {
                    if (result) {
                        this.actionConfirmed = true;
                        $(e.target).trigger(e.type);
                    }
                }.bind(this));
            }

            this.actionConfirmed = false;
        }
    }
});