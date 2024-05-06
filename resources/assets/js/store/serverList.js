import { defineStore } from 'pinia'

export const useServerListStore = defineStore('serverList', {
    state: () => ({
        loading: false,
        servers: [],
    }),
    actions: {
        async fetchServersByFilter(filter) {
            this.loading = true
            try {
                const response = await axios.get('/api/servers/')
                this.servers = response.data;
            } catch (error) {
                throw error
            } finally {
                this.loading = false
            }
        },
        async deleteById(id, deleteFiles) {
            this.loading = true
            try {
                await axios.post(
                    '/api/servers/'+id,
                    {delete_files: deleteFiles},
                    {headers: {'X-Http-Method-Override': 'DELETE'}},
                )
            } catch (error) {
                throw error
            } finally {
                this.loading = false
            }
        }
    },
})