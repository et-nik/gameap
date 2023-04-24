<template>
    <div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <td>{{ trans('servers.name') }}</td>
                    <td>{{ trans('servers.ip_port') }}</td>
                    <td>&nbsp;</td>
                </tr>
                </thead>

                <tbody>
                <tr v-for="(server, itemIndex) in items">
                    <td><a v-bind:href="'/admin/servers/' + server.id + '/edit'">{{ server.name }}</a></td>
                    <td>{{ server.server_ip }}:{{ server.server_port }}</td>
                    <td>
                        <a class="btn btn-sm btn-info" v-bind:href="'/admin/users/' + userId + '/servers/' + server.id + '/edit'">
                            <i class="fas fa-lock"></i>
                        </a>
                        <input type="hidden" v-model="server.id" v-bind:name="'servers[]'">
                        <button class="btn btn-sm btn-danger" v-on:click.prevent="removeItem(itemIndex)">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="form-group">
            <div class="col-md-12">
                <n-select
                    v-model:value="selectedServer"
                    filterable
                    :placeholder="trans('users.servers_privileges_placeholder')"
                    :options="serversListOptions"
                    :loading="loading"
                    clearable
                    remote
                    @search="onSearch"
                />

<!--                <v-select-->
<!--                        v-model="selectedServer"-->
<!--                        v-bind:options="serversListOptions"-->
<!--                        @search="onSearch"-->
<!--                        :placeholder="trans('users.servers_privileges_placeholder')"-->
<!--                >-->
<!--                    <template slot="option" slot-scope="option">-->
<!--                        <div class="row">-->
<!--                            <div class="col-md-5">{{ option.label }}</div>-->
<!--                            <div class="col-md-3">{{ option.game }}</div>-->
<!--                            <div class="col-md-4">{{ option.address }}</div>-->
<!--                        </div>-->
<!--                    </template>-->
<!--                </v-select>-->
            </div>

            <div class="col-md-2 offset-md-5 centered mt-2">
                <button class="btn btn-sm btn-success" v-on:click.prevent="addItem"><span class="fa fa-plus"></span>&nbsp;{{ trans('main.add') }}</button>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive, toRefs } from 'vue';
import axios from 'axios';

export default {
    props: {
        initialItems: Array,
        userId: Number,
    },
    setup(props) {
        const state = reactive({
            items: props.initialItems,
            selectedServer: null,
            serversList: [],
            serversListOptions: [],
            loading: false,
        });

        function existsItem(id) {
            for (let item of state.items) {
                if (item.id === id) {
                    return true;
                }
            }
        }

        function findItem(id) {
            for (let item of state.serversList) {
                if (item.id === id) {
                    return item;
                }
            }
        }

        function removeListsElem(elemId) {
            state.serversList = state.serversList.filter(function(elem) {
                return elem.id !== elemId;
            });

            state.serversListOptions = state.serversListOptions.filter(function(elem) {
                return elem.value !== elemId;
            });
        }

        function removeItem(index) {
            state.items.splice(index, 1);
        }

        function addItem() {
            if (!state.selectedServer) {
                window.gameap.alert('Select server');
                return;
            }

            if (existsItem(state.selectedServer)) {
                window.gameap.alert('Server already exists');
                return;
            }

            const newItem = findItem(state.selectedServer);

            if (newItem) {
                state.items.push(newItem);

                removeListsElem(newItem.id);
                state.selectedServer = null;
            }
        }

        function onSearch(search) {
            if (search.length < 3) {
                return;
            }

            state.loading = true;

            axios.get(`/api/servers/search?q=${encodeURI(search)}`)
                .then(function (response) {
                    state.serversList = [];
                    state.serversListOptions = [];

                    for (let item of response.data) {
                        if (existsItem(item.id)) {
                            continue;
                        }

                        state.serversList.push({
                            id: item.id,
                            name: item.name,
                            game: item.game.name,
                            server_ip: item.server_ip,
                            server_port: item.server_port
                        });

                        state.serversListOptions.push({
                            label: item.name + ' (' + item.game.name + ')' + ' - ' + item.server_ip + ':' + item.server_port,
                            address: `${item.server_ip}:${item.server_port}`,
                            game: item.game.name,
                            value: item.id,
                        });
                    }

                    state.loading = false;
                })
                .catch(function (error) {
                    state.loading = false;
                    console.log(error);
                    alert(error.response.data.message);
                });
        }

        return {
            ...toRefs(state),
            existsItem,
            findItem,
            removeListsElem,
            removeItem,
            addItem,
            onSearch,
        };
    },
};
</script>
