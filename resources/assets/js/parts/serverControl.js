if( document.getElementById("serverControl") ) {
    const WATCH_TASK_TIMEOUT            = 2000; // 2 sec
    const CHECK_SERVER_STATUS_TIMEOUT   = 2000; // 2 sec
    const CLEAR_VARS_TIMEOUT            = 2000; // 2 sec
    const LONG_WAITING_TIME             = 20000; // 20 sec

    Vue.mixin({
        data: function () {
            return {
                // serverId: 0,
                watchTaskId: 0,
                watchTaskData: {},
                watchTaskProgress: null,
                watchTaskStartedTime: 0,
                callbackTaskComplete: function() {
                    gameap.closeProgressModal();
                    gameap.alert(i18n.servers.task_success_msg);
                },
                progressModal: null
            };
        },
        methods: {
            serverCommand: function(command, serverId) {
                if ($.inArray(command, ['start', 'stop', 'restart', 'update', 'reinstall']) !== -1) {
                    gameap.confirm(i18n.main.confirm_message, function() {
                        axios.post('/api/servers/' + command + '/' + gameap.serverId)
                            .then(function (response) {
                                gameap.watchTaskId = response.data.gdaemonTaskId;
                                gameap.openProgressModal();
                                gameap.startWatchTask();
                            }).catch(function (error) {
                                console.log(error);
                                gameap.alert(error.response.data.message, function() { location.reload()});
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
                        if (serverStatus === true) {
                            gameap.alert(i18n.servers.start_success_msg, function() { location.reload()});
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
                        if (serverStatus === false) {
                            gameap.alert(i18n.servers.stop_success_msg, function() { location.reload()});
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
                        if (serverStatus === true) {
                            gameap.alert(i18n.servers.restart_success_msg, function() { location.reload()});
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
            reinstallServer: function(serverId) {
                this.serverId = serverId;
                this.serverCommand('reinstall', serverId);
            },
            openProgressModal: function() {
                this.progressModal = bootbox.dialog({
                    message: '<p class="text-center">' +
                        '<i class="fa fa-spin fa-spinner"></i> ' + i18n.main.wait + '</p>' +
                        '<p id="additional-info"></p>' +
                        '<div id="progressbar"></div>',
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
            startWatchTask: function() {
                this.hideAdditionalInfo();
                this.watchTaskStartedTime = (new Date()).getTime();
                this.watchTask();
            },
            watchTask: function() {
                if (this.watchTaskId <= 0) {
                    return;
                }

                this.getTask();

                if ($.isEmptyObject(this.watchTaskData) === false) {
                    if (this.watchTaskData.status === 'waiting') {
                        this.watchTaskProgress.progress = 10;
                        this.checkLongWaiting();
                    } else if (this.watchTaskData.status === 'working') {
                        this.watchTaskProgress.progress = 40;
                        this.hideAdditionalInfo();
                    } else if (this.watchTaskData.status === 'success') {
                        this.watchTaskProgress.progress = 80;
                        this.setTaskSuccess();
                    } else if (this.watchTaskData.status === 'canceled') {
                        this.watchTaskProgress.progress = 0;
                        this.setTaskError(i18n.gdaemon_tasks.common_canceled_msg);
                    } else if (this.watchTaskData.status === 'error') {
                        this.watchTaskProgress.progress = 100;
                        this.setTaskError(i18n.gdaemon_tasks.common_error_msg);
                    } else {
                        this.watchTaskProgress.progress = 100;
                        this.setTaskError(i18n.gdaemon_tasks.common_error_msg);
                    }
                }

                setTimeout(this.watchTask, WATCH_TASK_TIMEOUT);
            },
            checkLongWaiting: function() {
                if ((new Date()).getTime() - this.watchTaskStartedTime > LONG_WAITING_TIME) {
                    this.showAdditionalInfo(i18n.gdaemon_tasks.long_waiting_doc);
                }
            },
            showAdditionalInfo: function(text = '') {
                let additionalInfo = $('#additional-info');

                if (additionalInfo.is(':hidden')) {
                    additionalInfo.html(text);
                    additionalInfo.show();
                }
            },
            hideAdditionalInfo: function() {
                let additionalInfo = $('#additional-info');
                additionalInfo.hide();
            },
            setTaskError: function(errorMsg) {
                this.watchTaskId = 0;
                this.watchTaskStartedTime = 0;
                this.hideAdditionalInfo();
                this.closeProgressModal();
                gameap.alert(errorMsg);
                setTimeout(this.clearVars, CLEAR_VARS_TIMEOUT);
            },
            setTaskSuccess: function() {
                this.watchTaskId = 0;
                this.watchTaskStartedTime = 0;
                this.hideAdditionalInfo();
                setTimeout(this.callbackTaskComplete, CHECK_SERVER_STATUS_TIMEOUT);
                setTimeout(this.clearVars, CLEAR_VARS_TIMEOUT);
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