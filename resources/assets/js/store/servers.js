const state = {
    serverId: 0,

    ip: "",
    port: 0,
    queryPort: 0,
    rconPort: 0,

    tasks: Array(),
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
    },

    fetchTasks({state, commit}) {
        if (state.serverId <= 0) {
            return;
        }

        axios.get('/api/servers/' + state.serverId + '/tasks').then((response) => {
            commit('setTasks', response.data);
        });
    },

    async storeTask({state, commit}, task) {
        const response = await axios.post('/api/servers/' + state.serverId + '/tasks', task);
        task.id = response.data.serverTaskId;
        commit('insertTask', task);
    },

    async updateTask({state, commit}, {taskIndex, task}) {
        const taskId = state.tasks[taskIndex].id;
        await axios.put('/api/servers/' + state.serverId + '/tasks/' + taskId, task);
        commit('updateTask', {taskIndex: taskIndex, task: task});
    },

    async destroyTask({state, commit}, taskIndex) {
        if (state.serverId <= 0) {
            return;
        }

        const taskId = state.tasks[taskIndex].id;
        await axios.delete('/api/servers/' + state.serverId + '/tasks/' + taskId);
        commit('deleteTask', taskIndex);
    },
};

const mutations = {
    setServerId(state, serverId) {
        state.serverId = serverId;
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

    setTasks(state, tasks) {
        state.tasks = tasks;
    },

    updateTask(state, {taskIndex, task}) {
        state.tasks[taskIndex] = Object.assign(state.tasks[taskIndex], task);
    },

    replaceTask(state, {taskIndex, task}) {
        state.tasks[taskIndex] = task;
    },

    insertTask(state, task) {
        state.tasks.push(task);
    },

    deleteTask(state, taskIndex) {
        state.tasks.splice(taskIndex, 1);
    }
};

export default {
    namespaced: true,
    state,
    actions,
    mutations
};