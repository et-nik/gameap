if( document.getElementById("serverControl") ) {
    const WATCH_TASK_TIMEOUT            = 2000; // 2 sec
    const CLEAR_VARS_TIMEOUT            = 2000; // 2 sec
    const LONG_WAITING_TIME             = 20000; // 20 sec

    const PROGRESS_PERCENT_NULL = 10;
    const PROGRESS_PERCENT_WAITING = 10;
    const PROGRESS_PERCENT_WORKING = 40;
    const PROGRESS_PERCENT_TASK_SUCCESS = 80;
    const PROGRESS_PERCENT_COMPLETE = 100;

    const CHECK_SERVER_STATUS_TRIES = 10;
    const CHECK_SERVER_STATUS_TIMEOUT   = 2000; // 2 sec

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
                progressModal: null,
                complete: false,
                statusTries: CHECK_SERVER_STATUS_TRIES,

                checkServerStatusAfterTask: false,
                serverStatus: false,
                expectedStatus: false,
                detailError: false,
            };
        },
        methods: {
            serverCommand: function(command, serverId) {
                if ($.inArray('admin', window.user.roles) !== -1) {
                    this.detailError = true;
                }

                if ($.inArray(command, ['start', 'stop', 'restart', 'update', 'install', 'reinstall']) !== -1) {
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
                this.expectedStatus = true;
                this.checkServerStatusAfterTask = true;
                this.serverCommand('start', serverId);

                this.callbackTaskComplete = () => {
                    this.closeProgressModal();
                    if (this.serverStatus === this.expectedStatus) {
                        gameap.alert(i18n.servers.start_success_msg, function() { location.reload()});
                    } else {
                        this.setTaskError(i18n.servers.start_fail_msg);
                    }
                };
            },
            stopServer: function(serverId) {
                this.serverId = serverId;
                this.expectedStatus = false;
                this.checkServerStatusAfterTask = true;
                this.serverCommand('stop', serverId);

                this.callbackTaskComplete = () => {
                    this.closeProgressModal();
                    if (this.serverStatus === this.expectedStatus) {
                        this.alert(i18n.servers.stop_success_msg, function() { location.reload()});
                    } else {
                        this.setTaskError(i18n.servers.stop_fail_msg);
                    }
                };
            },
            restartServer: function(serverId) {
                this.serverId = serverId;
                this.expectedStatus = true;
                this.checkServerStatusAfterTask = true;
                this.serverCommand('restart', serverId);

                this.callbackTaskComplete = () => {
                    this.closeProgressModal();
                    if (this.serverStatus === this.expectedStatus) {
                        this.alert(i18n.servers.restart_success_msg, function() { location.reload()});
                    } else {
                        this.setTaskError(i18n.servers.restart_fail_msg);
                    }
                };
            },
            installServer: function(serverId) {
                this.serverId = serverId;
                this.checkServerStatusAfterTask = false;
                this.serverCommand('install', serverId);
            },
            updateServer: function(serverId) {
                this.serverId = serverId;
                this.checkServerStatusAfterTask = false;
                this.serverCommand('update', serverId);
            },
            reinstallServer: function(serverId) {
                this.serverId = serverId;
                this.checkServerStatusAfterTask = false;
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
                        this.watchTaskProgress.progress = PROGRESS_PERCENT_WAITING;
                        this.checkLongWaiting();
                    } else if (this.watchTaskData.status === 'working') {
                        this.watchTaskProgress.progress = PROGRESS_PERCENT_WORKING;
                        this.hideAdditionalInfo();
                    } else if (this.watchTaskData.status === 'success') {
                        this.watchTaskProgress.progress = PROGRESS_PERCENT_TASK_SUCCESS;
                        this.setTaskSuccess();
                    } else if (this.watchTaskData.status === 'canceled') {
                        this.watchTaskProgress.progress = PROGRESS_PERCENT_NULL;
                        this.setTaskError(i18n.gdaemon_tasks.common_canceled_msg);
                    } else if (this.watchTaskData.status === 'error') {
                        this.watchTaskProgress.progress = PROGRESS_PERCENT_COMPLETE;
                        this.setTaskError(i18n.gdaemon_tasks.common_error_msg);
                    } else {
                        this.watchTaskProgress.progress = PROGRESS_PERCENT_COMPLETE;
                        this.setTaskError(i18n.gdaemon_tasks.common_error_msg);
                    }
                }

                setTimeout(this.watchTask, WATCH_TASK_TIMEOUT);
            },
            watchServerStatus: function() {
                this.getServerStatus((serverStatus) => {
                    this.serverStatus = serverStatus;

                    if (this.serverStatus === this.expectedStatus || this.statusTries <= 0) {
                        this.callbackTaskComplete();
                        setTimeout(this.clearVars, CLEAR_VARS_TIMEOUT);
                    } else {
                        this.statusTries--;
                        this.watchTaskProgress.progress++;
                        setTimeout(this.watchServerStatus, CHECK_SERVER_STATUS_TIMEOUT);
                    }
                });
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
                if (this.detailError) {
                    gameap.alert(errorMsg + '<br><br>' +
                        this.trans('servers.task_see_log', {
                            link: '/admin/gdaemon_tasks/' + this.watchTaskData.id
                        })
                    );
                } else {
                    gameap.alert(errorMsg);
                }

                this.watchTaskId = 0;
                this.watchTaskStartedTime = 0;
                this.hideAdditionalInfo();
                this.closeProgressModal();
                setTimeout(this.clearVars, CLEAR_VARS_TIMEOUT);
            },
            setTaskSuccess: function() {
                this.hideAdditionalInfo();
                this.watchTaskId = 0;
                this.watchTaskStartedTime = 0;

                if (this.checkServerStatusAfterTask) {
                    setTimeout(this.watchServerStatus, CHECK_SERVER_STATUS_TIMEOUT);
                } else {
                    this.callbackTaskComplete();
                    setTimeout(this.clearVars, CLEAR_VARS_TIMEOUT);
                }
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
                this.serverStatus = false;
                this.expectedStatus = false;
                this.statusTries = CHECK_SERVER_STATUS_TRIES;

                this.checkServerStatusAfterTask = false;

                this.callbackTaskComplete = () => {
                    gameap.closeProgressModal();
                    gameap.alert(i18n.servers.task_success_msg);
                };
            }
        }
    });
}
