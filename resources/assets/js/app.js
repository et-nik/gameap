
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// var app = new Vue({
//     el: '#app',
//     data: {
//         messages: ['azaza', 'ololo', 'haha']
//     }
// });

// ---------------------------------------------
// Admin

Vue.component('ip-list', {
    props: ['ipList'],
    template: '#ip-list-template'
});

new Vue({
    el: "#adminServerForm",
    data: {
        dsId: 1,
        ipList: []
    },
    created: function() {
        this.fetchIpList();
    },
    methods: {
        fetchIpList: function() {
            axios.get('/ajax/dedicated_servers/get_ip_list/' + this.dsId).then(function(response) {
                this.ipList = response.data;
            }.bind(this));
        },
        dsChangeHandler: function() {
            this.fetchIpList();
        }
    }
})