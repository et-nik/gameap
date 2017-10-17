if( document.getElementById("serverControl") ) {
    Vue.mixin({
        data: function () {
            return {
                watchTaskId: 0
            };
        },
        methods: {
            serverCommand: function(command, serverId) {
                if ($.inArray(command, ['start', 'stop', 'restart', 'update']) != -1) {
                    gameap.confirm('Are you sure?', function() {
                        axios.post('/api/servers/' + command + '/' + serverId)
                            .then(function (response) {
                                gameap.watchTaskId = response.data.gdaemonTaskId;
                                gameap.watchTask();
                            }).catch(function (error) {
                                console.log(error);
                                gameap.alert(error.response.data.message);
                            });
                    });
                } else {
                    gameap.alert('Unknown server command: ' + command);
                }
            },
            startServer: function(serverId) {
                this.serverCommand('start', serverId);
            },
            stopServer: function(serverId) {
                this.serverCommand('stop', serverId);
            },
            restartServer: function(serverId) {
                this.serverCommand('restart', serverId);
            },
            updateServer: function(serverId) {
                this.serverCommand('update', serverId);
            },
            watchTask: function() {
                this.getTask();
                
                var dialog = bootbox.dialog({
                    message: '<p class="text-center"><i class="fa fa-spin fa-spinner"></i> Please wait while we do something...</p><div id="progressbar"></div>'
                });
                
                progress = gameap.mountProgressbar('#progressbar');
                progress.progress = 10;
            },
            getTask: function() {
                if (this.watchTaskId <= 0) {
                    return;
                }
                
                axios.get('/api/gdaemon_tasks/get/' + this.watchTaskId)
                    .then(function (response) {
                        console.log(response.data);
                    });
            },
        }
    });
}