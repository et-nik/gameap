<template>
    <div>
        <n-form-item :label="trans('labels.server_port')" :path="serverPortPath">
          <input class="block appearance-none w-full py-1 px-2 mb-1 leading-normal bg-white text-gray-800 border border-gray-200 rounded" name="server_port" type="number" id="server_port" min="1024" max="65535" v-model="serverPort">
          <template #feedback>
            <span v-if="serverPortWarning" class="help-block"><strong>{{ serverPortWarning }}</strong></span>
          </template>
        </n-form-item>

      <n-form-item :label="trans('labels.query_port')" :path="queryPortPath">
        <input class="block appearance-none w-full py-1 px-2 mb-1 leading-normal bg-white text-gray-800 border border-gray-200 rounded" name="query_port" type="number" id="server_port" min="1024" max="65535" v-model="queryPort">
      </n-form-item>

      <n-form-item :label="trans('labels.rcon_port')" :path="rconPortPath">
        <input class="block appearance-none w-full py-1 px-2 mb-1 leading-normal bg-white text-gray-800 border border-gray-200 rounded" name="rcon_port" type="number" id="server_port" min="1024" max="65535" v-model="rconPort">
      </n-form-item>
    </div>
</template>

<script>
    import { mapState } from 'vuex';
    import {NFormItem} from "naive-ui";
    import {trans} from "../../i18n/i18n";

    const DEFAULT_PORTS = {
        'arma2': 2302,
        'arma2ao': 2302,
        'arma3': 2302,
        'cod4': 28960,
        'mta': 22003,
        'samp': 7777,
        'hurtworld': 12871,
        'justcause': 7777,
        'fivem': 30120,
        'ark': 7777,
        'rust': 28015,
        'minecraft': 25565,
        'rok': 7350,
        'teamspeak3': 9987,
        'default': 27015,
    };

    const PORT_DIFF = {
        'arma2': [0, 0],
        'arma2ao': [0, 0],
        'arma3': [0, 0],
        'cod4': [0, 0],
        'mta': [0, 2],
        'samp': [0, 0],
        'hurtworld': [10, 0],
        'justcause': [0, 0],
        'fivem': [0, 0],
        'ark': [0, 0],
        'rust': [0, 1],
        'minecraft': [0, 1],
        'rok': [0, 0],
        'teamspeak3': [24, 35], // Default port 9987, query 10011, rcon 10022
        'default': [0, 0],
    };

    export default {
        name: "SmartPortSelector",
      components: {NFormItem},
        props: {
            initialServerIp: String,
            initialServerPort: String,
            initialQueryPort: String,
            initialRconPort: String,
            game: '',
            serverPortPath: 'serverPort',
            rconPortPath: 'rconPort',
            queryPortPath: 'queryPort',
        },
        emits: ['update:serverPort', 'update:rconPort', 'update:queryPort'],
        data: function() {
            return {
                serverPort: parseInt(this.initialServerPort) || 27015,
                queryPort: parseInt(this.initialQueryPort) || 27015,
                rconPort: parseInt(this.initialRconPort) || 27015,
                serverPortWarning: '',
            }
        },
        methods: {
          trans,
            initPorts() {
                if (!this.initialServerPort) {
                    this.setPorts();
                }
            },
            setPorts() {
                if(this.initialServerIp === this.selectedIp) {
                    this.serverPort = parseInt(this.initialServerPort) || 27015;
                    this.queryPort = parseInt(this.initialQueryPort) || 27015;
                    this.rconPort = parseInt(this.initialRconPort) || 27015;
                }

                const gameCode = this.getExistsPortGameCode();

                let portCorrect = -1;

                do {
                    portCorrect++;
                    this.serverPort = DEFAULT_PORTS[gameCode] + portCorrect;
                }
                while(this.isBusy(this.selectedIp, DEFAULT_PORTS[gameCode] + portCorrect));
            },
            correctPorts() {
                const gameCode = this.getExistsPortGameCode();

                this.queryPort = this.serverPort + PORT_DIFF[gameCode][0];
                this.rconPort = this.serverPort + PORT_DIFF[gameCode][1];
            },
            getExistsPortGameCode() {
                return DEFAULT_PORTS.hasOwnProperty(this.gameCode)
                    ? this.gameCode
                    : 'default';
            },
            isBusy(serverIp, serverPort) {
                if (typeof this.initialServerIp != 'undefined'
                    && typeof this.initialServerPort != 'undefined'
                    && serverIp === this.initialServerIp
                    && serverPort === this.initialServerPort
                ) {
                    return false;
                }

                return this.busyPorts.hasOwnProperty(serverIp)
                    && this.busyPorts[serverIp].indexOf(serverPort) !== -1
            },
            checkPorts() {
                if (this.isBusy(this.selectedIp, this.serverPort)) {
                    this.serverPortWarning = this.trans('validation.unique', {attribute: this.trans('labels.server_port')});
                } else {
                    this.serverPortWarning = '';
                }
            }
        },
        computed: {
            ...mapState({
                ipList: state => state.dedicatedServers.ipList,
                dsId: state => state.dedicatedServers.dsId,
                busyPorts: state => state.dedicatedServers.busyPorts,
                gameCode: state => state.games.gameCode,
            }),
            selectedIp: {
                get() {
                  if (!this.$store.state.servers.ip || this.$store.state.servers.ip === "") {
                    return null;
                  }

                  return this.$store.state.servers.ip;
                },
                set(selectedIp) { this.$store.dispatch('servers/setIp', selectedIp) },
            },
        },
        mounted() {
            this.$store.dispatch('dedicatedServers/fetchBusyPorts', this.initPorts);
        },
        watch: {
            dsId() {
                this.$store.dispatch('dedicatedServers/fetchBusyPorts', this.setPorts);
            },
            gameCode() {
                this.setPorts();
            },
            serverPort(v, oldVal) {
                console.log("new:", v);
                console.log("old: ", oldVal);
                console.log("serverPort: ", this.serverPort);

                this.serverPort = Number(this.serverPort);
                this.correctPorts();
                this.checkPorts();
                this.$emit('update:serverPort', this.serverPort)
            },
            rconPort() {
              this.$emit('update:rconPort', this.rconPort)
            },
            queryPort() {
              this.$emit('update:queryPort', this.queryPort)
            },
        }
    }
</script>
