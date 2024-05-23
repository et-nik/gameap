import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {
    state: () => ({
        profile: {},
        // This is a counter to keep track of how many API processes are running
        apiProcesses: 0,
    }),
    getters: {
        loading: (state) => state.apiProcesses > 0,
        isAdmin: (state) => {
            return window.user.roles.includes('admin')
        },
        user: (state) => {
            return window.user
        },
    },
    actions: {
        async fetchProfile() {
            this.apiProcesses++
            try {
                const response = await axios.get('/api/profile')
                window.user = response.data
                this.profile = response.data
            } catch (error) {
                throw error
            } finally {
                this.apiProcesses--
            }
        },
        async saveProfile(profile) {
            this.apiProcesses++
            try {
                await axios.put('/api/profile', profile)
            } catch (error) {
                throw error
            } finally {
                this.apiProcesses--
            }
        }
    }
})