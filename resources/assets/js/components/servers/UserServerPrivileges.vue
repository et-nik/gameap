<template>
    <div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <td>Name</td>
                    <td>IP:Port</td>
                    <td>Revoke</td>
                </tr>
                </thead>

                <tbody>
                <tr v-for="(server, itemIndex) in items">
                    <td><a v-bind:href="'/admin/servers/' + server.id + '/edit'">{{ server.name }}</a></td>
                    <td>{{ server.server_ip }}:{{ server.server_port }}</td>
                    <td>
                        <input type="hidden" v-model="server.id" v-bind:name="'servers[]'">
                        <button class="btn btn-sm btn-danger" v-on:click.prevent="removeItem(itemIndex)">
                            <span class="fa fa-times"></span>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="form-group">
            <div class="col-12">
                <v-select v-model="selectedServer" v-bind:options="serversListOptions" @search="onSearch">
                    <template slot="option" slot-scope="option">
                        <div class="row">
                            <div class="col-5">{{ option.label }}</div>
                            <div class="col-3">{{ option.game }}</div>
                            <div class="col-4">{{ option.address }}</div>
                        </div>
                    </template>
                </v-select>
            </div>

            <div class="col-1 offset-6 centered mt-2">
                <button class="btn btn-sm btn-success" v-on:click.prevent="addItem"><span class="fa fa-plus"></span>&nbsp;Add</button>
            </div>
        </div>
    </div>
</template>

<script>
    import vSelect from 'vue-select';

    export default {
        props: {
            initialItems: Array,
        },
        components: {
            'v-select': vSelect,
        },
        data: function () {
            return {
                items: this.initialItems,
                selectedServer: null,
                serversList: [],
                serversListOptions: [],
            }
        },
        methods: {
            existsItem(id) {
                for (let item of this.items) {
                    if (item.id === id) {
                        return true;
                    }
                }
            },
            findItem(id) {
                for (let item of this.serversList) {
                    if (item.id === id) {
                        return item;
                    }
                }
            },
            removeListsElem(elemId) {
                this.serversList = this.serversList.filter(function(elem) {
                    return elem.id !== elemId;
                });

                this.serversListOptions = this.serversListOptions.filter(function(elem) {
                    return elem.value !== elemId;
                });
            },
            removeItem: function(index) {
                this.items.splice(index, 1);
            },
            addItem: function() {
                if (!this.selectedServer) {
                    this.alert('Select server');
                    return;
                }

                if (this.existsItem(this.selectedServer.value)) {
                    return;
                }

                const newItem = this.findItem(this.selectedServer.value);

                if (newItem) {
                    this.items.push(newItem);

                    this.removeListsElem(newItem.id);
                    this.selectedServer = null;
                }
            },
            onSearch(search, loading) {
                if (search.length < 3)  {
                    return;
                }

                loading(true);
                axios.get(`/api/servers/search?q=${encodeURI(search)}`)
                    .then(function (response) {
                        this.serversList = [];
                        this.serversListOptions = [];

                        for (let item of response.data) {
                            if (this.existsItem(item.id)) {
                                continue;
                            }

                            this.serversList.push({
                                id: item.id,
                                name: item.name,
                                game: item.game.name,
                                server_ip: item.server_ip,
                                server_port: item.server_port
                            });

                            this.serversListOptions.push({
                                label: item.name,
                                address: `${item.server_ip}:${item.server_port}`,
                                game: item.game.name,
                                value: item.id,
                            });
                        }

                        loading(false);
                    }.bind(this))
                    .catch(function (error) {
                        loading(false);
                        console.log(error);
                        gameap.alert(error.response.data.message);
                });
            },
        }
    }
</script>