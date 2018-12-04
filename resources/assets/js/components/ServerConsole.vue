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
                block: false,
            };
        },
        methods: {
            getConsole() {
                axios.get('/api/servers/console/' + this.serverId)
                    .then(response => (this.console = response.data.console))
                    .catch(function (error) {
                        console.log(error);
                        gameap.alert(error.response.data.message);
                });
            },
            sendCommand() {
                if (this.block) {
                    return;
                }

                this.block = true;
                axios.post('/api/servers/console/' + this.serverId, {'command': this.inputText})
                    .then(function (response) {
                        this.inputText = '';
                        this.block = false;
                    }.bind(this)).catch(function (error) {
                        this.block = false;
                        console.log(error);
                        gameap.alert(error.response.data.message);
                });
            },
        },
        mounted() {
            this.getConsole();
            setInterval(this.getConsole, 10000)
        }
    }
</script>
