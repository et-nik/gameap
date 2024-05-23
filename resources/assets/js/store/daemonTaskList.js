import { defineStore } from 'pinia'

export const useDaemonTaskListStore = defineStore('daemonTaskList', {
    state: () => ({
        daemonTaskList: [],

        // This is a counter to keep track of how many API processes are running
        apiProcesses: 0,
    }),
    getters: {
        loading: (state) => state.apiProcesses > 0,
    },
    actions: {
        async fetchTasks() {
            this.apiProcesses++
            try {
                const response = await axios.get('/api/gdaemon_tasks')
                this.daemonTaskList = response.data;
            } catch (error) {
                throw error
            } finally {
                this.apiProcesses--
            }
        },
    },
})