<template>
    <div id="rcon-console-component">
        <div class="terminal-box p-3 m-2">
            <div id="terminal-console" ref="terminal-console" class="terminal">{{ output }}</div>
        </div>

        <div class="input-group">
            <input v-on:keyup.enter="sendCommand"
                   v-model="inputText"
                   type="text"
                   class="form-control"
                   placeholder=""
                   aria-label=""
                   aria-describedby="basic-addon1">

            <div class="input-group-prepend">
                <button class="btn btn-outline-secondary" type="button" v-on:click="sendCommand">Send</button>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex';

    export default {
        name: "RconConsole",
        props: {
            serverId: Number
        },
        data: function () {
            return {
                inputText: null,
            };
        },
        methods: {
            async sendCommand() {
                await this.$store.dispatch('rconConsole/sendCommand', this.inputText).then(() => {
                    this.inputText = '';
                }).catch((error) => {
                    gameap.alert(error);
                    console.log(error);
                });
            },
        },
        computed: {
            ...mapState({
                output: state => state.rconConsole.output,
            })
        },
        mounted() {
            this.$store.dispatch('servers/setServerId', this.serverId);
        }
    }
</script>

<style scoped>
    .terminal {
        min-height: 250px;
    }
</style>