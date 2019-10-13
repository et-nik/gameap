const state = {
    serverId: 0,

    ip: "",
    port: 0,
    queryPort: 0,
    rconPort: 0,
};

const actions = {
    setServerId({commit}, serverId) {
        commit('setServerId', serverId);
    },

    setIp({commit}, ip) {
        commit('setIp', ip);
    },

    setPort({commit}, port) {
        commit('setPort', port);
    },

    setQueryPort({commit}, queryPort) {
        commit('setQueryPort', queryPort);
    },

    setRconPort({commit}, rconPort) {
        commit('setRconPort', rconPort);
    }
};

const mutations = {
    setServerId(state, serverId) {
        state.gameCode = serverId;
    },

    setIp(state, ip) {
        state.ip = ip;
    },

    setPort(state, port) {
        state.port = port;
    },

    setQueryPort(state, queryPort) {
        state.queryPort = queryPort;
    },

    setRconPort(state, rconPort) {
        state.rconPort = rconPort;
    },
};

export default {
    namespaced: true,
    state,
    actions,
    mutations
};