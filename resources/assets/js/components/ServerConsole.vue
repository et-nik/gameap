<template>
    <div class="terminal-box p-3 m-2">
        <div class="terminal">
            {{ console }}
        </div>
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
</template>

<script>
    export default {
        props: {
            serverId: Number,
            consoleHostname: String
        },
        data: function () {
            return {
                console: null,
                inputText: null,
                lock: false,
                updateConsole: true,
            };
        },
        methods: {
            getConsole() {
                if (!this.updateConsole) {
                    return;
                }
                
                axios.get('/api/servers/console/' + this.serverId)
                    .then(response => (this.console = response.data.console))
                    .catch(function (error) {
                        console.log(error);
                        gameap.alert(error.response.data.message);
                        this.updateConsole = false;
                }.bind(this));
            },
            sendCommand() {
                if (this.lock) {
                    return;
                }

                this.lock = true;
                axios.post('/api/servers/console/' + this.serverId, {'command': this.inputText})
                    .then(function (response) {
                        this.inputText = '';
                        this.lock = false;
                        this.updateConsole = true;
                    }.bind(this)).catch(function (error) {
                        this.lock = false;
                        console.log(error);
                        gameap.alert(error.response.data.message);
                }.bind(this));
            },
        },
        mounted() {
            this.getConsole();
            setInterval(this.getConsole, 10000);
        }
    }
</script>
