<template>
    <div>
        <div id="dedicatedServerForm" class="mb-3">
            <label for="ds_id" class="control-label">{{ trans('labels.ds_id') }}</label>
            <select id="ds_id" v-bind:name="dsIdFieldName" class="form-select" v-model="selectedDs">
                <option v-for="(dsName, dsId) in dsList" v-bind:value="dsId">{{ dsName }}</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="server_ip" class="control-label">{{ trans('labels.server_ip') }}</label>
            <select id="server_ip" v-bind:name="serverIpFieldName" class="form-select" v-model="selectedIp">
                <option v-for="ip in ipList" v-bind:value="ip">{{ ip }}</option>
            </select>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex';

    export default {
        name: "DsIpSelector",
        props: {
            dsList: Object,
            initialDsId: Number,
            initialIp: String,
            serverIpFieldName: {
                type: String,
                default: 'server_ip',
            },
            dsIdFieldName: {
                type: String,
                default: 'ds_id',
            }
        },
        mounted() {
            this.selectedDs = this.initialDsId || -1;
            this.selectedIp = this.initialIp;
        },
        computed: {
            ...mapState({
                ipList: state => state.dedicatedServers.ipList,
            }),
            selectedDs: {
                get() { return this.$store.state.dedicatedServers.dsId; },
                set(dsId) { this.$store.dispatch('dedicatedServers/setDsId', dsId) }
            },
            selectedIp: {
                get() { return this.$store.state.servers.ip; },
                set(selectedIp) { this.$store.dispatch('servers/setIp', selectedIp) },
            },
        },
        watch: {
            ipList(list) {
                if (list.length >= 1 && list.indexOf(this.selectedIp) === -1) {
                    this.selectedIp = list[0];
                }
            },
            selectedDs(val) {
                this.$store.dispatch('dedicatedServers/fetchIpList');
            }
        }
    }
</script>
