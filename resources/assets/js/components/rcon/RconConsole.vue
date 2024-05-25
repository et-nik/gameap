<template>
    <div id="rcon-console-component">
      <div class="coding inverse-toggle px-5 pt-4 shadow-lg text-stone-100 text-sm font-mono subpixel-antialiased
              bg-stone-800  pb-6 pt-4 rounded-lg leading-normal overflow-hidden">
        <div ref="consoleRef" class="whitespace-pre-wrap mt-4 flex h-[40vh] overflow-y-scroll overscroll-contain">
          {{ output }}
        </div>
      </div>

        <div class="grid grid-cols-12 gap-4 mt-2">
          <NInput
              v-model:value="inputText"
              v-on:keyup.enter="sendCommand"
              class="col-span-11"
              type="text"
              placeholder=""
          />

          <GButton color="black" size="small" v-on:click="sendCommand">
            <i class="fa-solid fa-terminal mr-1"></i>
            <span class="hidden xl:inline">&nbsp;{{ trans('main.send') }}</span>
          </GButton>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex';
    import {
      NInput,
    } from "naive-ui";
    import GButton from "../GButton.vue";
    import {errorNotification} from "../../parts/dialogs";

    export default {
        name: "RconConsole",
      components: {GButton},
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
                    errorNotification(error);
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