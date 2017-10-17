if( document.getElementById("serverControl") ) {
    Vue.mixin({
        data: function () {
            return {
                serverId: 0,
                watchTaskId: 0,
                watchTaskData: {},
                watchTaskProgress: null,
                callbackTaskComplete: null,
                progressModal: null
            };
        },
        methods: {
            serverCommand: function(command, serverId) {
                if ($.inArray(command, ['start', 'stop', 'restart', 'update']) != -1) {
                    gameap.confirm('Are you sure?', function() {
                        axios.post('/api/servers/' + command + '/' + gameap.serverId)
                            .then(function (response) {
                                gameap.watchTaskId = response.data.gdaemonTaskId;
                                gameap.openProgressModal();
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
                this.serverId = serverId;
                this.serverCommand('start', serverId);

                this.callbackTaskComplete = function() {
                    gameap.getServerStatus(function(serverStatus) {
                        gameap.closeProgressModal();
                        if (serverStatus == true) {
                            gameap.alert('Server started');
                        } else {
                            gameap.alert('Server not started');
                        }
                    });
                };
            },
            stopServer: function(serverId) {
                this.serverId = serverId;
                this.serverCommand('stop', serverId);

                this.callbackTaskComplete = function() {
                    gameap.getServerStatus(function(serverStatus) {
                        gameap.closeProgressModal();
                        if (serverStatus == false) {
                            gameap.alert('Server stopped');
                        } else {
                            gameap.alert('Server not stopped');
                        }
                    });
                };
            },
            restartServer: function(serverId) {
                this.serverId = serverId;
                this.serverCommand('restart', serverId);

                this.callbackTaskComplete = function() {
                    gameap.getServerStatus(function(serverStatus) {
                        gameap.closeProgressModal();
                        if (serverStatus == true) {
                            gameap.alert('Server restarted');
                        } else {
                            gameap.alert('Server not restarted');
                        }
                    });
                };
            },
            updateServer: function(serverId) {
                this.serverId = serverId;
                this.serverCommand('update', serverId);
            },
            openProgressModal: function() {
                this.progressModal = bootbox.dialog({
                    message: '<p class="text-center"><i class="fa fa-spin fa-spinner"></i> Please wait while we do something...</p><div id="progressbar"></div>',
                    callback: function(result) {
                        gameap.watchTaskId = 0;
                    }
                });

                this.watchTaskProgress = this.mountProgressbar('#progressbar');
            },
            closeProgressModal: function() {
                this.progressModal.modal('hide');
            },
            watchTask: function() {
                if (this.watchTaskId <= 0) {
                    return;
                }

                this.getTask();

                if ($.isEmptyObject(this.watchTaskData) == false) {
                    if (this.watchTaskData.status == 'waiting') {
                        this.watchTaskProgress.progress = 10;
                    } else if (this.watchTaskData.status == 'working') {
                        this.watchTaskProgress.progress = 40;
                    } else if (this.watchTaskData.status == 'success') {
                        this.watchTaskProgress.progress = 80;
                        this.setTaskSuccess();
                    } else if (this.watchTaskData.status == 'error') {
                        this.watchTaskProgress.progress = 100;
                        this.setTaskError('Task completed with an error');
                    }
                }

                setTimeout(this.watchTask, 2000);
            },
            setTaskError: function(errorMsg) {
                this.watchTaskId = 0;
                this.closeProgressModal();
                gameap.alert(errorMsg);
            },
            setTaskSuccess: function() {
                this.watchTaskId = 0;
                this.callbackTaskComplete();
            },
            getTask: function() {
                axios.get('/api/gdaemon_tasks/get/' + this.watchTaskId)
                    .then(function (response) {
                        gameap.watchTaskData = response.data;
                    }).catch(function(error) {
                        gameap.setTaskError(error.response.data.message);
                    });
            },
            getServerStatus: function(fn) {
                axios.get('/api/servers/get_status/' + gameap.serverId)
                    .then(function (response) {
                        fn(response.data.processActive);
                    });
            }
        }
    });
}