<template>
    <div>
        <div class="terminal-box p-6 m-2">
            <div id="terminalConsole" ref="terminalConsole" class="terminal">
              <div v-if="!serverActive" class="bg-red-500 text-white font-bold rounded px-4 py-2 mb-3">
                {{ trans('servers.offline_console_msg') }}
              </div>
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

<script setup>
import {ref, computed, onMounted, onUnmounted} from 'vue';
import axios from 'axios';

const props = defineProps({
  serverId: Number,
  consoleHostname: String,
  serverActive: Boolean,
});

const output = ref(null);
const inputText = ref(null);
const lock = ref(false);
const updateConsole = ref(true);
const autoScroll = ref(true);

function scroll() {
  if (autoScroll.value && this.$refs && this.$refs.terminalConsole) {
    this.$refs.terminalConsole.scrollTop = this.$refs.terminalConsole.scrollHeight;
  }
}

function getConsole() {
  if (!updateConsole.value) {
    return;
  }

  axios.get(`/api/servers/${props.serverId}/console`)
      .then(response => {
        output.value = response.data.console;
        setTimeout(scroll, 1000);
      })
      .catch(error => {
        console.log(error);
        updateConsole.value = false;
      });
}

function sendCommand() {
  if (lock.value) {
    return;
  }

  lock.value = true;
  axios.post(`/api/servers/${props.serverId}/console`, { command: inputText.value })
      .then(response => {
        inputText.value = '';
        lock.value = false;
        updateConsole.value = true;
        setTimeout(getConsole, 1000);
      })
      .catch(error => {
        lock.value = false;
        console.log(error);
        gameap.alert(error.response.data.message);
      });
}

let interval;

onMounted(() => {
  getConsole();
  interval = setInterval(getConsole, 10000);
});
onUnmounted(() => {
  updateConsole.value = false;
  clearInterval(interval);
});
</script>

<style>
.server-offline-note {
    color: #880808;
    font-weight: bold;
}
</style>