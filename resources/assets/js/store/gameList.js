import { defineStore } from 'pinia'

export const useGameListStore = defineStore('games', {
    state: () => ({
        loading: false,
        games: [],
        gameMods: [],
        allGameMods: [],
    }),
    actions: {
        async fetchGames() {
            this.loading = true
            try {
                const response = await axios.get('/api/games/')
                this.games = response.data;
            } catch (error) {
                throw error
            } finally {
                this.loading = false
            }
        },
        async fetchGameMods(gameId) {
            this.loading = true
            try {
                const response = await axios.get('/api/games/' + gameId + '/mods')
                this.gameMods = response.data;
            } catch (error) {
                throw error
            } finally {
                this.loading = false
            }
        },
        async fetchAllGameMods() {
            this.loading = true
            try {
                const response = await axios.get('/api/game_mods')
                this.allGameMods = response.data;
            } catch (error) {
                throw error
            } finally {
                this.loading = false
            }
        },
        async createGame(game) {
            this.loading = true
            try {
                const response = await axios.post('/api/games', game)
                return response.data
            } catch (error) {
                throw error
            } finally {
                this.loading = false
            }
        },
        async createGameMod(mod) {
            this.loading = true
            try {
                const response = await axios.post('/api/game_mods', mod)
                return response.data
            } catch (error) {
                throw error
            } finally {
                this.loading = false
            }
        },
        async deleteGameByCode(code) {
            this.loading = true
            try {
                await axios.delete('/api/games/' + code)
            } catch (error) {
                throw error
            } finally {
                this.loading = false
            }
        },
        async deleteModById(id) {
            this.loading = true
            try {
                await axios.delete('/api/game_mods/' + id)
            } catch (error) {
                throw error
            } finally {
                this.loading = false
            }
        }
    },
})