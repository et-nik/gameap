import { defineStore } from 'pinia'

export const useGamesStore = defineStore('games', {
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
        }
    },
})