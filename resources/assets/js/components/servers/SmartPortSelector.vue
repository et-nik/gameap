<template>
    <div>
        <div class="mb-3">
            <label for="server_port" class="control-label">{{ trans('labels.server_port') }}</label>
            <input class="block appearance-none w-full py-1 px-2 mb-1 leading-normal bg-white text-gray-800 border border-gray-200 rounded" name="server_port" type="number" id="server_port" min="1024" max="65535" v-model="serverPort">
            <span v-if="serverPortWarning" class="help-block"><strong>{{ serverPortWarning }}</strong></span>
        </div>

        <div class="mb-3">
            <label for="query_port" class="control-label">{{ trans('labels.query_port') }}</label>
            <input class="block appearance-none w-full py-1 px-2 mb-1 leading-normal bg-white text-gray-800 border border-gray-200 rounded" name="query_port" type="number" id="query_port" min="1024" max="65535" v-model="queryPort">
        </div>

        <div class="mb-3">
            <label for="rcon_port" class="control-label">{{ trans('labels.rcon_port') }}</label>
            <input class="block appearance-none w-full py-1 px-2 mb-1 leading-normal bg-white text-gray-800 border border-gray-200 rounded" name="rcon_port" type="number" id="rcon_port" min="1024" max="65535" v-model="rconPort">
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex';

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
        props: {
            initialServerIp: String,
            initialServerPort: String,
            initialQueryPort: String,
            initialRconPort: String,
            game: ''
        },
        data: function() {
            return {
                serverPort: parseInt(this.initialServerPort) || 27015,
                queryPort: parseInt(this.initialQueryPort) || 27015,
                rconPort: parseInt(this.initialRconPort) || 27015,
                serverPortWarning: '',
            }
        },
        methods: {
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
                get() { return this.$store.state.servers.ip; },
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
            selectedIp(ip, oldIp) {
                if (oldIp) {
                    this.setPorts();
                }
                this.checkPorts();
            },
            serverPort() {
                this.serverPort = Number(this.serverPort);
                this.correctPorts();
                this.checkPorts();
            },
        }
    }
</script>
