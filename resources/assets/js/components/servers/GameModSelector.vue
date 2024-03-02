<template>
    <div>
        <div class="mb-3">
            <label for="game_id" class="control-label">{{ trans('labels.game_id') }}</label>
            <select id="game_id" name="game_id" class="form-select" v-model="selectedGameCode">
                <option v-for="(gameName, gameCode) in games" v-bind:value="gameCode">{{ gameName }}</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="game_mod_id" class="control-label">{{ trans('labels.game_mod_id') }}</label>
            <select id="game_mod_id" name="game_mod_id" class="form-select" v-model="selectedMod">
                <option v-for="gameMod in gameModsList" v-bind:value="gameMod.id">{{ gameMod.name }}</option>
            </select>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex';

    export default {
        name: "GameModSelector",
        props: {
            games: Object,
            initialGame: String,
            initialMod: String,
        },
        mounted() {
            this.selectedGameCode = this.initialGame;
            this.selectedMod = this.initialMod;
        },
        computed: {
            ...mapState({
                gameModsList: state => state.gameMods.gameModsList,
            }),
            selectedGameCode: {
                get() { return this.$store.state.games.gameCode; },
                set(gameCode) { this.$store.dispatch('games/setGameCode', gameCode) },
            },
            selectedMod: {
                get() { return this.$store.state.gameMods.gameMod; },
                set(gameMod) { this.$store.dispatch('gameMods/setGameMod', gameMod) },
            }
        },
        watch: {
            selectedGameCode(gameCode) {
                this.$store.dispatch('gameMods/fetchGameModsList', gameCode);
            },
            gameModsList(val) {
                if (this.initialGame !== this.selectedGameCode) {
                    this.selectedMod = val.length > 0 ? val[0].id : '';
                } else {
                    this.selectedMod = this.initialMod;
                }
            },
        }
    }
</script>
