const state = {
    gameModsList: [],
};

const actions = {
    fetchGameModsList({commit}, gameId) {
        if (typeof gameId == 'undefined' || !gameId) {
            return;
        }

        axios.get('/api/game_mods/get_list_for_game/' + gameId).then(function (response) {
            commit('setModsList', response.data);
        }.bind(this));
    },
};

const mutations = {
    setModsList (state, modsList) {
        state.gameModsList = modsList;
    },
};

export default {
    namespaced: true,
    state,
    actions,
    mutations
};