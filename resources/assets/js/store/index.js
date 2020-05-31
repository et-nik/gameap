import Vue from 'vue';
import Vuex from 'vuex';

import dedicatedServers from './dedicatedServers';
import servers from './servers';
import games from './games';
import gameMods from './gameMods';

import activeTab from './activeTab';

// Rcon
import rconConsole from './rcon/console'
import rconPlayers from './rcon/players'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        dedicatedServers,
        servers,
        games,
        gameMods,

        activeTab,

        // Rcon
        rconConsole,
        rconPlayers,
    },
})