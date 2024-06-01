import { defineStore } from 'pinia'

export const useAuthSettingsStore = defineStore('authSettings', {
    state: () => ({
        settings: null,
    }),
    getters: {
        theme: (state) => {
            if (!state.settings || !state.settings.theme) {
                return 'light'
            }

            return state.settings.theme
        },
    },
    actions: {
        loadSettings() {
            this.settings = JSON.parse(localStorage.getItem('settings'))
        },
        saveSettings() {
            localStorage.setItem('settings', JSON.stringify(this.settings))
        },
        setTheme(theme) {
            if (!this.settings) {
                this.settings = {}
            }

            this.settings.theme = theme
            this.saveSettings()
        },
    },
})