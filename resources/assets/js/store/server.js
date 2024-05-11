// Pinia store. Vuex should be replaced with Pinia in the future.

import { defineStore } from 'pinia'
import {errorNotification} from "../parts/dialogs";

export const useServerStore = defineStore('server', {
    state: () => ({
        errors: [],
        loading: false,
        serverId: 0,
        abilities: {
            'game-server-common': false,
            'game-server-start': false,
            'game-server-stop': false,
            'game-server-restart': false,
            'game-server-pause': false,
            'game-server-update': false,
            'game-server-files': false,
            'game-server-tasks': false,
            'game-server-settings': false,

            'game-server-console-view': false,
            'game-server-console-send': false,

            'game-server-rcon-console': false,
            'game-server-rcon-players': false,
        },
        server: {
            id: 0,
            uuid: '',
            uuid_short: '',
            enabled: false,
            installed: false,
            blocked: false,
            name: '',
            ds_id: 0,
            game_id: 0,
            game_mod_id: 0,
            server_ip: '',
            server_port: 0,
            query_port: 0,
            rcon_port: 0,
            game: {},
            online: false,
        },
        settings: [],
        rconSupportedFeatures: {
            rcon: false,
            playersManage: false,
        },
    }),
    getters: {
        canStart(state) {
            return Boolean(state.abilities['game-server-start'])
        },
        canStop(state) {
            return Boolean(state.abilities['game-server-stop'])
        },
        canRestart(state) {
            return Boolean(state.abilities['game-server-restart'])
        },
        canUpdate(state) {
            return Boolean(state.abilities['game-server-update'])
        },
        canReadConsole(state) {
            return Boolean(state.abilities['game-server-console-view'])
        },
        canSendConsole(state) {
            return Boolean(state.abilities['game-server-console-send'])
        },
        canManageFiles(state) {
            return Boolean(state.abilities['game-server-files'])
        },
        canManageTasks(state) {
            return Boolean(state.abilities['game-server-tasks'])
        },
        canManageSettings(state) {
            return Boolean(state.abilities['game-server-settings'])
        },
        canUseRcon(state) {
            return Boolean(state.abilities['game-server-rcon-console'])
        },
        canManageRconPlayers(state) {
            return Boolean(state.abilities['game-server-rcon-players'])
        },
        getServer(state) {
            return state.server;
        }
    },
    actions: {
        setServerId(serverId) {
            this.serverId = serverId;
        },
        async fetchServer() {
            this.loading = true;

            try {
                const response = await axios.get('/api/servers/' + this.serverId)
                this.server = response.data;
            } catch (error) {
                this.errors.push(error)
                console.error(error)
            } finally {
                this.loading = false;
            }
        },
        async fetchAbilities() {
            this.loading = true;

            try {
                const response = await axios.get('/api/servers/' + this.serverId + '/abilities')
                this.abilities = response.data;
            } catch (error) {
                errorNotification('', error)
                this.errors.push(error)
                console.error(error)
            } finally {
                this.loading = false;
            }
        },
        async fetchSettings() {
            this.loading = true;

            try {
                const response = await axios.get('/api/servers/' + this.serverId + '/settings')
                this.settings = response.data;
            } catch (error) {
                throw error
            } finally {
                this.loading = false;
            }
        },
        async saveSettings(settings) {
            this.loading = true;

            try {
                await axios.put('/api/servers/' + this.serverId + '/settings', settings)
            } catch (error) {
                throw error
            } finally {
                this.loading = false;
            }
        },
        async fetchRconSupportedFeatures() {
            this.loading = true;

            try {
                const response = await axios.get('/api/servers/' + this.serverId + '/rcon/features')
                this.rconSupportedFeatures = response.data;
            } catch (error) {
                errorNotification('', error)
                this.errors.push(error)
                console.error(error)
            } finally {
                this.loading = false;
            }
        }
    },
})