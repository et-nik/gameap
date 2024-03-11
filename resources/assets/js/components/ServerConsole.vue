<template>
    <div>
        <div class="terminal-box p-6 m-2">
            <div id="terminalConsole" ref="terminalConsole" class="terminal">
              <span v-if="!serverActive" class="server-offline-note">{{ trans('servers.offline_console_msg') }}<br></span>
              {{ output }}
            </div>
            <div v-if="serverActive" class="mb-3 m-0">
                <div class="relative flex items-stretch w-full">
                    <div class="terminal-input">
                        {{ consoleHostname }}:~$&nbsp;
                        <input
                          v-on:keyup.enter="sendCommand"
                          v-model="inputText"
                          type="text"
                          class="terminal-input m-0 p-0"
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="p-6 m-2">
            <input type="checkbox" id="checkbox" v-model="autoScroll">
            <label for="checkbox">{{ trans('main.autoscroll') }}</label>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex';

    const ACTIVE_CONSOLE_TABS = ['main', ''];

    export default {
        props: {
            serverId: Number,
            consoleHostname: String,
            serverActive: Boolean,
        },
        data: function () {
            return {
                output: null,
                inputText: null,
                lock: false,
                updateConsole: true,
                autoScroll: true,
            };
        },
        methods: {
            scroll() {
                if (this.autoScroll) {
                    this.$refs.terminalConsole.scrollTop = this.$refs.terminalConsole.scrollHeight;
                }
            },
            getConsole() {
                if (!this.updateConsole) {
                    return;
                }

                if (!ACTIVE_CONSOLE_TABS.includes(this.activeTabName)) {
                    return;
                }

                axios.get('/api/servers/' + this.serverId + '/console')
                    .then(function(response) {
                        this.output = response.data.console;
                        setTimeout(this.scroll, 1000)
                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                        this.updateConsole = false;
                    }.bind(this));
            },
            sendCommand() {
                if (this.lock) {
                    return;
                }

                this.lock = true;
                axios.post('/api/servers/' + this.serverId + '/console', {'command': this.inputText})
                    .then(function (response) {
                        this.inputText = '';
                        this.lock = false;
                        this.updateConsole = true;
                        setTimeout(this.getConsole, 1000);
                    }.bind(this)).catch(function (error) {
                        this.lock = false;
                        console.log(error);
                        gameap.alert(error.response.data.message);
                }.bind(this));
            },
        },
        computed: {
            ...mapState({
                activeTabName: state => state.activeTab.name,
            }),
        },
        mounted() {
            this.getConsole();
            setInterval(this.getConsole, 10000);
        }
    }
</script>

<style>
.server-offline-note {
    color: #880808;
    font-weight: bold;
}
</style>