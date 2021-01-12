const state = {
    output: '',
};

const actions = {
    async sendCommand({state, commit, dispatch, rootState}, command) {
        const response = await axios.post('/web-api/servers/' + rootState.servers.serverId + '/rcon', {
            command: command
        });
        commit('setOutput', response.data.output);
    },
};

const mutations = {
    setOutput(state, output) {
        state.output = output;
    },
};

export default {
    namespaced: true,
    state,
    actions,
    mutations
};
