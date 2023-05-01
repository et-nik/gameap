<script setup>
    import {defineAsyncComponent, h, ref, onMounted, computed} from 'vue'
    import {trans} from "../i18n/i18n";
    import store from "../store";

    // Installed statuses
    const NOT_INSTALLED        = 0;
    const INSTALLED            = 1;
    const INSTALLATION_PROCESS = 2;

    const ServerControlButton = defineAsyncComponent(() =>
        import('../components/ServerControlButton.vue' /* webpackChunkName: "components/server" */)
    );

    const createColumns = () => {
        return [
            {
                title: "Name",
                key: "name"
            },
            {
                title: "IP:Port",
                render(row) {
                    return row.server_ip + ":" + row.server_port;
                }
            },
            {
                title: "Status",
                key: "status",
                render(row) {
                    if (row.blocked) {
                        return h('span', {class: "badge text-bg-secondary"}, trans('servers.blocked'));
                    }

                    if (!row.enabled) {
                        return h('span', {class: "badge text-bg-secondary"}, trans('servers.disabled'));
                    }

                    if (!row.installed) {
                        return h('span', {class: "badge text-bg-secondary"}, trans('servers.not_installed'));
                    }

                    if (row.installed === INSTALLATION_PROCESS) {
                        return h('span', {class: "badge text-bg-warning"}, trans('servers.installation'));
                    }

                    if (row.online) {
                        return h(
                            "span",
                            {
                                class: "badge text-bg-success",
                            },
                            trans('servers.online'),
                        );
                    }

                    return h(
                        "span",
                        {
                            class: "badge text-bg-danger",
                        },
                        trans('servers.offline'),
                    );
                }
            },
            {
                title: "Commands",
                render(row) {
                    if (!row.enabled || row.blocked) {
                        return [];
                    }

                    if (row.installed === NOT_INSTALLED) {
                        return h(ServerControlButton,
                            {
                                "command": "install",
                                "button": "btn btn-small btn-warning btn-sm",
                                "icon": "fa fa-download",
                                "text": trans('servers.install'),
                                "server-id": row.id,
                            });
                    }

                    let buttons = [];

                    if (!row.online) {
                        buttons.push(
                            h(ServerControlButton,
                            {
                                "command": "start",
                                "button": "btn btn-small btn-success btn-sm",
                                "icon": "fa fa-play",
                                "text": trans('servers.start'),
                                "server-id": row.id,
                            }),
                            " "
                        );
                    } else {
                        buttons.push(
                            h(ServerControlButton,
                                {
                                    "command": "stop",
                                    "button": "btn btn-small btn-danger btn-sm",
                                    "icon": "fa fa-stop",
                                    "text": trans('servers.stop'),
                                    "server-id": row.id,
                            }),
                            " ",
                        );
                    }

                    buttons.push(
                        h(ServerControlButton,
                            {
                                "command": "restart",
                                "button": "btn btn-small btn-warning btn-sm",
                                "icon": "fa fa-redo",
                                "text": trans('servers.restart'),
                                "server-id": row.id,
                        }),
                        " ",
                        h('a',
                            {
                                "class": "btn btn-small btn-primary btn-sm",
                                "href": "/servers/" + row.id,
                            },
                            [
                                h('span', {"class": "d-none d-xl-inline"}, trans('servers.control')),
                                " ",
                                h('span', {"class": "fa fa-angle-double-right"}),
                            ])
                    );

                    return buttons;
                }
            },
        ];
    };

    const columns = ref(createColumns());
    const pagination = {
        pageSize: 10,
    };
    const loading = ref(true);
    const tableRef = ref(null);

    const selectedGame = ref(null);
    const selectedIP = ref(null);

    onMounted(() => {
        store.dispatch('servers/fetchServers');
        loading.value = false;

        try {
            const f = JSON.parse(localStorage.getItem("server-filters"))
            if (f !== null) {
                if (f["server_ip"] !== null) {
                    selectedIP.value = f["server_ip"]
                }

                if (f["game_name"] !== null) {
                    selectedGame.value = f["game_name"]
                }
            }
        } catch (e) {
            console.log(e);
        }

    });

    const data = computed(() => {
        return store.state.servers.serversList.filter((server) => {
            let skip = false;

            if (
                selectedGame.value !== null &&
                selectedGame.value !== "" &&
                selectedGame.value.length > 0
            ) {
                skip = !selectedGame.value.includes(server.game.name)
            }

            if (
                !skip &&
                selectedIP.value !== null &&
                selectedIP.value !== "" &&
                selectedIP.value.length > 0
            ) {
                skip = !selectedIP.value.includes(server.server_ip)
            }

            return !skip
        });
    });

    const games = computed(() => {
        const set = new Set;
        for (const idx in store.state.servers.serversList) {
            set.add(store.state.servers.serversList[idx].game.name)
        }

        return Array.from(set).sort();
    });

    const gamesOptions = computed(() => {
        var options = [];

        for (const el of games.value) {
            options.push({label: el, value: el});
        }
        return options;
    });

    const gamesIPOptions = computed(() => {
        const set = new Set;
        for (const idx in store.state.servers.serversList) {
            set.add(store.state.servers.serversList[idx].server_ip)
        }

        var options = [];
        for (const el of Array.from(set).sort()) {
            options.push({label: el, value: el});
        }

        return options;
    });

    function handleUpdateFilters() {
        // tableRef.value.filter({
        //     'server_ip': selectedIP.value,
        // })

        localStorage.setItem("server-filters", JSON.stringify({
            'server_ip': selectedIP.value,
            'game_name': selectedGame.value,
        }));
    }
</script>

<template>
    <div class="row mb-4">
        <n-collapse>
            <n-collapse-item :title="trans('servers.filters')" name="filters">
                <div class="row">
                    <div class="col-md-3">
                        <n-select
                            v-model:value="selectedGame"
                            :options="gamesOptions"
                            multiple
                            :placeholder="trans('servers.select_game_filter_placeholder')"
                            @update:value="handleUpdateFilters"
                        >
                        </n-select>
                    </div>

                    <div class="col-md-3">
                        <n-select
                            v-model:value="selectedIP"
                            :options="gamesIPOptions"
                            multiple
                            :placeholder="trans('servers.select_ip_filter_placeholder')"
                            @update:value="handleUpdateFilters"
                        >
                        </n-select>
                    </div>
                </div>
            </n-collapse-item>
        </n-collapse>
    </div>

    <n-data-table
        ref="tableRef"
        :bordered="false"
        :single-line="true"
        :columns="columns"
        :data="data"
        :loading="loading"
        :pagination="pagination"
    />
</template>
