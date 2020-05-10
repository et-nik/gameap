import Vue from 'vue';
import Vuex from 'vuex';

import dedicatedServers from './dedicatedServers';
import servers from './servers';
import games from './games';
import gameMods from './gameMods';

import activeTab from './activeTab';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        dedicatedServers,
        servers,
        games,
        gameMods,

        activeTab,
    },
})