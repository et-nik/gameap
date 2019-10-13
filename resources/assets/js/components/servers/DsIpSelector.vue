<template>
    <div>
        <div id="dedicatedServerForm" class="form-group">
            <label for="ds_id" class="control-label">{{ trans('labels.ds_id') }}</label>
            <select id="ds_id" name="ds_id" class="form-control" v-model="selectedDs">
                <option v-for="(dsName, dsId) in dsList" v-bind:value="dsId">{{ dsName }}</option>
            </select>
        </div>

        <div class="form-group">
            <label for="server_ip" class="control-label">{{ trans('labels.server_ip') }}</label>
            <select id="server_ip" name="server_ip" class="form-control" v-model="selectedIp">
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