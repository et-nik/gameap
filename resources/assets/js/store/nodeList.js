import { defineStore } from 'pinia'

export const useNodeListStore = defineStore("nodeList",{
    state: () => ({
        loading: false,
        nodes: [],
    }),
    actions: {
        async fetchNodesByFilter(filter) {
            this.loading = true
            try {
                const response = await axios.get('/api/dedicated_servers/')
                this.nodes = response.data;
            } catch (error) {
                throw error
            } finally {
                this.loading = false
            }
        }
    },
})