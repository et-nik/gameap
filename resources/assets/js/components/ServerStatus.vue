<template>
    <div id="server-status-component">
        <div class="flex flex-wrap ">
            <div class="md:w-1/6 pr-4 pl-4">
                <strong>{{ trans('servers.query') }}</strong>
            </div>

            <div class="md:w-1/6 pr-4 pl-4">
                <div v-if="status === 'online'" class="inline">
                    <span class="inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded text-bg-success">{{ trans('servers.online') }}</span>
                </div>

                <div v-else-if="status === 'offline'" class="inline">
                    <span class="inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded text-bg-danger">{{ trans('servers.offline') }}</span>
                </div>

                <div v-else class="inline">
                    <span class="inline-block p-1 text-center font-semibold text-sm align-baseline leading-none rounded text-bg-warning">-</span>
                </div>
            </div>

            <div v-if="showHostname" class="md:w-1/3 pr-4 pl-4">
                <div v-if="useJoinLink" class="inline">
                    <a :href="items.joinlink">{{ items.hostname }}</a>
                </div>

                <div v-else>{{ items.hostname }}</div>
            </div>

            <div v-if="showPlayersNum" class="md:w-1/4 pr-4 pl-4">
                {{ trans('servers.query_players') }}: {{ items.players }}
            </div>

            <div v-if="showMap" class="md:w-1/4 pr-4 pl-4">
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
