<template>
    <div id="rcon-console-component">
        <div class="terminal-box p-6 m-2">
            <div id="terminal-console" ref="terminal-console" class="terminal">{{ output }}</div>
        </div>

        <div class="relative flex items-stretch w-full">
            <input v-on:keyup.enter="sendCommand"
                   v-model="inputText"
                   type="text"
                   class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded"
                   placeholder=""
                   aria-label=""
                   aria-describedby="basic-addon1">

            <div class="input-group-prepend">
                <button class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-2 px-3 leading-normal no-underline text-gray-600 border-gray-600 hover:bg-gray-600 hover:text-white bg-white hover:bg-gray-700" type="button" v-on:click="sendCommand">Send</button>
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