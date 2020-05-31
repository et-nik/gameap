<template>
    <div id="rcon-players-component">
        <button class="btn btn-success m-1" v-on:click="updatePlayers()">
            <i class="fas fa-sync"></i>
        </button>

        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <td>{{ trans('rcon.player_name') }}</td>
                <td v-if="scoreRow">{{ trans('rcon.player_score') }}</td>
                <td v-if="pingRow">{{ trans('rcon.player_ping') }}</td>
                <td v-if="ipRow">{{ trans('rcon.player_ip') }}</td>
                <td>{{ trans('main.actions') }}</td>
            </tr>
            </thead>
            <tbody v-for="(value, key) in players">
            <tr>
                <td>{{ value.name }}</td>
                <td v-if="scoreRow">{{ value.score }}</td>
                <td v-if="pingRow">{{ value.ping }}</td>
                <td v-if="ipRow">{{ value.ip }}</td>
                <td>
                    <button v-on:click="openDialog('kick', key)" class="btn btn-sm btn-info btn-warning m-1">
                        <i class="gicon gicon-kick"></i>
                        <span class="d-none d-xl-inline">{{ trans('rcon.kick') }}</span>
                    </button>

                    <button v-on:click="openDialog('ban', key)" class="btn btn-sm btn-info btn-danger m-1">
                        <i class="fas fa-ban"></i>
                        <span class="d-none d-xl-inline">{{ trans('rcon.ban') }}</span>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="modal fade" tabindex="-1" role="dialog" id="player-control-modal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ dialogTitle }}</h5>
                        <button type="button" class="close" data-dismiss="modal" :aria-label="trans('main.close')">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form>
                            <div class="form-group" v-if="dialogAction === 'ban' || dialogAction === 'kick'">
                                <label for="input-reason" class="control-label">{{ trans('rcon.reason') }}</label>
                                <input v-model.number="form.reason" id="input-reason" type="text" class="form-control">

                                <span v-if="errors['reason']" class="help-block">
                                    <strong class="text-danger">{{ errors['reason'] }}</strong>
                                </span>
                            </div>

                            <div class="form-group" v-if="dialogAction === 'ban'">
                                <label for="input-time" class="control-label">{{ trans('rcon.time') }}</label>
                                <input v-model.number="form.time" id="input-time" type="number" class="form-control">

                                <span v-if="errors['time']" class="help-block">
                                    <strong class="text-danger">{{ errors['time'] }}</strong>
                                </span>
                            </div>

                            <div class="form-group" v-if="dialogAction === 'message'">
                                <label for="input-mesage" class="control-label">{{ trans('rcon.message') }}</label>
                                <input v-model.number="form.message" id="input-mesage" type="text" class="form-control">

                                <span v-if="errors['message']" class="help-block">
                                    <strong class="text-danger">{{ errors['message'] }}</strong>
                                </span>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('main.close') }}</button>
                        <button type="button" class="btn btn-primary" v-on:click="send">{{ trans('main.send') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex';

    export default {
        name: "RconPlayers",
        props: {
            serverId: Number,
        },
        data: function () {
            return {
                dialogAction: null,
                dialogPlayerIndex: null,
                dialogPlayerName: null,
                form: {
                    playerId: null,
                    reason: null,
                    time: null,
                    message: null,
                },
                errors: {
                    reason: null,
                    time: null,
                    message: null,
                },
            };
        },
        methods: {
            updatePlayers() {
                this.$store.dispatch('rconPlayers/fetchPlayers');
            },
            openDialog(action, playerIndex) {
                this.resetErrors();
                this.resetForm();

                this.dialogAction = action;
                this.dialogPlayerName = this.players[playerIndex].name;

                this.form.playerId = this.players[playerIndex].id;

                this.showModal();
            },
            showModal() {
                $('#player-control-modal').modal('show');
            },
            hideModal() {
                $('#player-control-modal').modal('hide');
            },
            send() {
                if (!this.checkForm()) {
                    return;
                }

                if (this.dialogAction === 'ban') {
                    this.ban();
                }

                if (this.dialogAction === 'kick') {
                    this.kick();
                }

                if (this.dialogAction === 'message') {
                    this.sendMessage();
                }
            },
            checkForm() {
                this.resetErrors();
                let error = false;

                // noinspection FallThroughInSwitchStatementJS
                switch (this.dialogAction) {
                    case 'ban':
                        if (!this.form.time) {
                            error = true;
                            this.errors.time = 'Empty time';
                        }
                    case 'kick':
                        if (!this.form.reason) {
                            error = true;
                            this.errors.reason = 'Empty reason';
                        }
                        break;

                    case 'message':
                        if (!this.form.message) {
                            error = true;
                            this.errors.reason = 'Empty message';
                        }
                        break;
                }

                return !error;
            },
            resetErrors() {
                this.errors = {
                    reason: null,
                    time: null,
                    message: null,
                };
            },
            resetForm() {
                this.form = {
                    playerId: null,
                    reason: null,
                    time: null,
                    message: null,
                };
            },
            ban() {
                this.$store.dispatch('rconPlayers/banPlayer', {
                    playerId: this.form.playerId,
                    reason: this.form.reason,
                    time: this.form.time,
                }).then(() => {
                    this.hideModal();

                    gameap.alert(this.trans('rcon.ban_msg_success'))
                }).catch((e) => {
                    this.hideModal();

                    _.has(e, 'response.data.message')
                        ? gameap.alert(e.response.data.message)
                        : gameap.alert(e);
                });
            },
            kick() {
                this.$store.dispatch('rconPlayers/kickPlayer', {
                    playerId: this.form.playerId,
                    reason: this.form.reason
                }).then(() => {
                    this.hideModal();

                    gameap.alert(this.trans('rcon.kick_msg_success'))
                }).catch((e) => {
                    this.hideModal();

                    _.has(e, 'response.data.message')
                        ? gameap.alert(e.response.data.message)
                        : gameap.alert(e);
                });
            },
            sendMessage() {
                this.$store.dispatch('rconPlayers/sendMessage', {
                    playerId: this.form.playerId,
                    message: this.form.message
                }).then(() => {
                    this.hideModal();

                    gameap.alert(this.trans('rcon.message_msg_success'))
                }).catch((e) => {
                    this.hideModal();

                    _.has(e, 'response.data.message')
                        ? gameap.alert(e.response.data.message)
                        : gameap.alert(e);
                });
            }
        },
        computed: {
            ...mapState({
                players: state => state.rconPlayers.players,
            }),
            dialogTitle() {
                switch (this.dialogAction) {
                    case 'ban':
                        return this.trans('rcon.modal_title_ban', {player: this.dialogPlayerName});
                    case 'kick':
                        return this.trans('rcon.modal_title_kick', {player: this.dialogPlayerName});
                    case 'message':
                        return this.trans('rcon.modal_title_msg', {player: this.dialogPlayerName});
                }
            },
            ipRow() {
                return _.has(_.head(this.players), 'ip');
            },
            pingRow() {
                return _.has(_.head(this.players), 'ping');
            },
            scoreRow() {
                return _.has(_.head(this.players), 'score');
            }
        },
        mounted() {
            this.$store.dispatch('servers/setServerId', this.serverId);
            this.$store.dispatch('rconPlayers/fetchPlayers');
        }
    }
</script>

<style scoped>

</style>