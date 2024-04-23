<script setup>
    import {defineAsyncComponent, h, ref, onMounted, computed} from 'vue'
    import {trans} from "../i18n/i18n";
    import store from "../store";

    import GButton from "./GButton.vue";

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
                        return h('span', {class: "badge-stone"}, trans('servers.blocked'));
                    }

                    if (!row.enabled) {
                        return h('span', {class: "badge-stone"}, trans('servers.disabled'));
                    }

                    if (!row.installed) {
                        return h('span', {class: "badge-stone"}, trans('servers.not_installed'));
                    }

                    if (row.installed === INSTALLATION_PROCESS) {
                        return h('span', {class: "badge-orange"}, trans('servers.installation'));
                    }

                    if (row.online) {
                        return h(
                            "span",
                            {
                                class: "badge-green",
                            },
                            trans('servers.online'),
                        );
                    }

                    return h(
                        "span",
                        {
                            class: "badge-red",
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
                                "button-color": "orange",
                                "button-size": "small",
                                "icon": "fa fa-download",
                                "text": trans('servers.install'),
                                "server-id": row.id,
                            });
                    }

                    let buttons = [];

                    if (row.installed === INSTALLED) {
                        if (row.online) {
                            buttons.push(
                                h(ServerControlButton,
                                    {
                                        "command": "stop",
                                        "button-color": "red",
                                        "button-size": "small",
                                        "icon": "fa fa-stop",
                                        "text": trans('servers.stop'),
                                        "server-id": row.id,
                                    }),
                                " ",
                            );
                        } else {
                            buttons.push(
                                h(ServerControlButton,
                                    {
                                        "command": "start",
                                        "button-color": "green",
                                        "button-size": "small",
                                        "icon": "fa fa-play",
                                        "text": trans('servers.start'),
                                        "server-id": row.id,
                                    }),
                                " "
                            );
                        }

                        buttons.push(
                            h(ServerControlButton,
                                {
                                    "command": "restart",
                                    "button-color": "orange",
                                    "button-size": "small",
                                    "icon": "fa fa-redo",
                                    "text": trans('servers.restart'),
                                    "server-id": row.id,
                                }),
                            " ",
                        );
                    }

                    buttons.push(
                        h(GButton,
                            {
                                "color": "black",
                                "size": "small",
                                "link": "/servers/" + row.id,
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
        pageSize: 20,
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
        localStorage.setItem("server-filters", JSON.stringify({
            'server_ip': selectedIP.value,
            'game_name': selectedGame.value,
        }));
    }

    function clearFilters() {
        selectedIP.value = null;
        selectedGame.value = null;

        handleUpdateFilters();
    }

    function isFiltersSet() {
        return selectedIP.value !== null || selectedGame.value !== null
    }
</script>

<template>
    <div class="flex flex-wrap  mb-4">
        <n-collapse>
            <n-collapse-item :title="trans('servers.filters')" name="filters">
                <div class="flex flex-wrap ">
                    <div class="md:w-1/4 pr-4 pl-4">
                        <n-select
                            v-model:value="selectedGame"
                            :options="gamesOptions"
                            multiple
                            :placeholder="trans('servers.select_game_filter_placeholder')"
                            @update:value="handleUpdateFilters"
                        >
                        </n-select>
                    </div>

                    <div class="md:w-1/4 pr-4 pl-4">
                        <n-select
                            v-model:value="selectedIP"
                            :options="gamesIPOptions"
                            multiple
                            :placeholder="trans('servers.select_ip_filter_placeholder')"
                            @update:value="handleUpdateFilters"
                        >
                        </n-select>
                    </div>

                    <div class="md:w-1/4 pr-4 pl-4">
                        <n-button @click="clearFilters" type="error" :disabled="!isFiltersSet()" ghost>
                            <i class="fa fa-eraser"></i><span class="hidden xl:inline">&nbsp;{{ trans('main.clear') }}</span>
                        </n-button>
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
    >
        <template #empty>
            <n-empty :description="trans('servers.empty_list')">
            </n-empty>
        </template>
    </n-data-table>
</template>
