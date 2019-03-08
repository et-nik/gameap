if( document.getElementById("serverControl") ) {
    Vue.mixin({
        data: function () {
            return {
                // serverId: 0,
                watchTaskId: 0,
                watchTaskData: {},
                watchTaskProgress: null,
                callbackTaskComplete: function() {
                    gameap.closeProgressModal();
                    gameap.alert(i18n.servers.task_success_msg);
                },
                progressModal: null
            };
        },
        methods: {
            serverCommand: function(command, serverId) {
                if ($.inArray(command, ['start', 'stop', 'restart', 'update']) != -1) {
                    gameap.confirm(i18n.main.confirm_message, function() {
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
                    gameap.alert(i18n.servers.unknown_command_msg + ': ' + command);
                }
            },
            startServer: function(serverId) {
                this.serverId = serverId;
                this.serverCommand('start', serverId);

                this.callbackTaskComplete = function() {
                    gameap.getServerStatus(function(serverStatus) {
                        gameap.closeProgressModal();
                        if (serverStatus == true) {
                            gameap.alert(i18n.servers.start_success_msg);
                        } else {
                            gameap.alert(i18n.servers.start_fail_msg);
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
                            gameap.alert(i18n.servers.stop_success_msg);
                        } else {
                            gameap.alert(i18n.servers.stop_fail_msg);
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
                            gameap.alert(i18n.servers.restart_success_msg);
                        } else {
                            gameap.alert(i18n.servers.restart_success_msg);
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
                    message: '<p class="text-center"><i class="fa fa-spin fa-spinner"></i> ' + i18n.main.wait + '</p><div id="progressbar"></div>',
                    callback: function(result) {
                        gameap.watchTaskId = 0;
                    }
                });

                this.watchTaskProgress = this.mountProgressbar('#progressbar');
                this.watchTaskProgress.progress = 0;
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
                setTimeout(this.clearVars, 1000);
            },
            setTaskSuccess: function() {
                this.watchTaskId = 0;
                this.callbackTaskComplete();
                setTimeout(this.clearVars, 1000);
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
            },
            clearVars: function() {
                this.watchTaskProgress.progress = 0;
                this.watchTaskData = {};
            }
        }
    });
}