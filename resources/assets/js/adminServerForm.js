// ---------------------------------------------
// Admin

Vue.component('ip-list', {
    props: ['ipList'],
    template: '#ip-list-template'
});

new Vue({
    el: "#adminServerForm",
    data: {
        dsId: $('#ds_id').val(),
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