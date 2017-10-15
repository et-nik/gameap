// ---------------------------------------------
// Admin

Vue.component('ip-list', {
    props: ['ipList'],
    template: '#ip-list-template'
});

Vue.component('game-mod-list', {
    props: ['gameModsList'],
    template: '#game-mod-list-template'
});

new Vue({
    el: "#adminServerForm",
    data: {
        dsId: $('#ds_id').val(),
        gameId: $('#game_id').val(),
        ipList: [],
        gameModsList: []
    },
    created: function() {
        this.fetchIpList();
        this.fetchGameModsList();
    },
    methods: {
        fetchIpList: function() {
            axios.get('/api/dedicated_servers/get_ip_list/' + this.dsId).then(function(response) {
                this.ipList = response.data;
            }.bind(this));
        },
        fetchGameModsList: function() {
            this.gameModsList = [{id: 5, name: 'Game1'}, {id: 6, name: 'Game2'}];
        },
        dsChangeHandler: function() {
            this.fetchIpList();
        }
    }
})