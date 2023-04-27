<template>
    <div id="server-status-component">
        <div class="row">
            <div class="col-md-1">
                <strong>{{ trans('servers.query') }}</strong>
            </div>

            <div class="col-md-1">
                <div v-if="status === 'online'" class="d-inline">
                    <span class="badge text-bg-success">{{ trans('servers.online') }}</span>
                </div>

                <div v-else-if="status === 'offline'" class="d-inline">
                    <span class="badge text-bg-danger">{{ trans('servers.offline') }}</span>
                </div>

                <div v-else class="d-inline">
                    <span class="badge text-bg-warning">-</span>
                </div>
            </div>

            <div v-if="showHostname" class="col-md-4">
                <div v-if="useJoinLink" class="d-inline">
                    <a :href="items.joinlink">{{ items.hostname }}</a>
                </div>

                <div v-else>{{ items.hostname }}</div>
            </div>

            <div v-if="showPlayersNum" class="col-md-3">
                {{ trans('servers.query_players') }}: {{ items.players }}
            </div>

            <div v-if="showMap" class="col-md-3">
                {{ trans('servers.query_map') }}: {{ items.map }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            serverId: Number
        },
        data: function () {
            return { items: null };
        },
        computed: {
            status() {
                if (! _.has(this.items, 'status')) {
                    return 'unknown';
                }

                if (this.items.status === 'online') {
                    return 'online';
                } else {
                    return 'offline';
                }
            },
            showHostname() {
                return _.has(this.items, 'hostname');
            },
            showPlayersNum() {
                return _.has(this.items, 'players');
            },
            showMap() {
                return _.has(this.items, 'map');
            },
            useJoinLink() {
                return _.has(this.items, 'joinlink')
                    && this.items.joinlink.length > 0;
            }
        },
        mounted() {
            axios.get('/api/servers/' + this.serverId + '/query')
                .then(response => (this.items = response.data));
        }
    }
</script>
