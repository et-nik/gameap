import { defineStore } from 'pinia'

export const useAuthStore = defineStore('auth', {
    state: () => ({
        profile: {},
        serversAbilities: {},
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
        canServerAbility: (state) => (serverId, ability) => {
            if (state.isAdmin) {
                return true
            }

            if (!state.serversAbilities[serverId]) {
                return false
            }

            return state.serversAbilities[serverId][ability]
        }
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
        },
        async fetchServersAbilities() {
            this.apiProcesses++
            try {
                const response = await axios.get('/api/user/servers_abilities')
                this.serversAbilities = response.data
            } catch (error) {
                throw error
            } finally {
                this.apiProcesses--
            }
        },
        async login(credentials) {
            this.apiProcesses++
            try {
                await axios.post(
                    '/api/auth/login',
                    credentials,
                    {withCredentials: true},
                )
            } catch (error) {
                throw error
            } finally {
                this.apiProcesses--
            }
        },
        async logout() {
            this.apiProcesses++
            try {
                await axios.post('/api/auth/logout')
            } catch (error) {
                throw error
            } finally {
                this.apiProcesses--
            }
        },
    }
})