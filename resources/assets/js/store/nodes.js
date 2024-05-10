import { defineStore } from 'pinia'

export const useNodesStore = defineStore({
    state: () => ({
        loading: false,
        nodes: [],
    }),
    actions: {
        async fetchNodesByFilter(filter) {
            this.loading = true
            try {
                const response = await axios.get('/api/nodes/')
                this.nodes = response.data;
            } catch (error) {
                throw error
            } finally {
                this.loading = false
            }
        }
    },
})