<template>
    <div>
        <div class="form-group">
            <label for="game_id" class="control-label">{{ trans('labels.game_id') }}</label>
            <select id="game_id" name="game_id" class="form-control" v-model="selectedGameCode">
                <option v-for="(gameName, gameCode) in games" v-bind:value="gameCode">{{ gameName }}</option>
            </select>
        </div>

        <div class="form-group">
            <label for="game_mod_id" class="control-label">{{ trans('labels.game_mod_id') }}</label>
            <select id="game_mod_id" name="game_mod_id" class="form-control" v-model="selectedMod">
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
        data: function() {
            return {
                selectedMod: this.initialMod,
            };
        },
        mounted() {
            this.selectedGameCode = this.initialGame;
        },
        computed: {
            ...mapState({
                gameModsList: state => state.gameMods.gameModsList,
            }),
            selectedGameCode: {
                get() { return this.$store.state.games.gameCode; },
                set(gameCode) { this.$store.dispatch('games/setGameCode', gameCode) },
            },
        },
        watch: {
            selectedGameCode(gameCode) {
                this.$store.dispatch('gameMods/fetchGameModsList', gameCode);
            },
            gameModsList(val) {
                this.selectedMod = val.length > 1 ? val[0].id : '';
            },
        }
    }
</script>