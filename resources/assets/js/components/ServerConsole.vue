<template>
    <div>
        <div class="terminal-box p-3 m-2">
            <div id="terminalConsole" ref="terminalConsole" class="terminal">{{ console }}</div>
            <div class="form-group m-0">
                <div class="input-group">
                    <div class="terminal-input">
                        {{ consoleHostname }}:~$&nbsp;
                        <input
                                v-on:keyup.enter="sendCommand"
                                v-model="inputText"
                                type="text"
                                class="terminal-input m-0 p-0">
                    </div>
                </div>
            </div>
        </div>

        <div class="p-3 m-2">
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
        },
        data: function () {
            return {
                console: null,
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
                
                axios.get('/web-api/servers/console/' + this.serverId)
                    .then(function(response) {
                        this.console = response.data.console;
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
                axios.post('/web-api/servers/console/' + this.serverId, {'command': this.inputText})
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
