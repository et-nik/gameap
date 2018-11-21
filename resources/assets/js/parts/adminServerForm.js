// ---------------------------------------------
// Admin

if( document.getElementById("adminServerForm") ) {
    Vue.mixin({
        data: function () {
            return {
                dsId: $('#ds_id').val(),
                gameId: $('#game_id').val(),
                ipList: [],
                gameModsList: []
            };
        },
        created: function () {
            this.fetchIpList();
            this.fetchGameModsList();
        },
        methods: {
            fetchIpList: function () {
                axios.get('/api/dedicated_servers/get_ip_list/' + this.dsId).then(function (response) {
                    this.ipList = response.data;
                }.bind(this));
            },
            fetchGameModsList: function () {
                axios.get('/api/game_mods/get_list_for_game/' + this.gameId).then(function (response) {
                    this.gameModsList = response.data;
                }.bind(this));
            },
            dsChangeHandler: function () {
                this.fetchIpList();
            },
            gameChangeHandler: function () {
                this.fetchGameModsList();
            }
        }
    });

    Vue.component('ip-list', {
        props: ['ipList'],
        template: '#ip-list-template'
    });

    Vue.component('game-mod-list', {
        props: ['gameModsList'],
        template: '#game-mod-list-template'
    });
}