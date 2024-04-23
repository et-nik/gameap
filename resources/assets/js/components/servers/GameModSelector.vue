<template>
    <div>
        <div class="mb-3">
            <input type="hidden" name="game_id" v-model="selectedGameCode">

            <label for="game_mod_id" class="control-label">{{ trans('labels.game_id') }}</label>
            <n-select filterable v-model:value="selectedGameCode" :options="gamesOptions" />
        </div>

        <div class="mb-3">
            <input type="hidden" name="game_mod_id" v-model="selectedMod">

            <label for="game_mod_id" class="control-label">{{ trans('labels.game_mod_id') }}</label>
            <n-select
                filterable
                v-model:value="selectedMod"
                :disabled="!selectedGameCode"
                :options="gameModOptions"
            />
        </div>
    </div>
</template>

<script setup>
  import { computed, watch, onMounted } from 'vue';
  import { useStore } from 'vuex';

  const props = defineProps({
    games: Object,
    initialGame: String,
    initialMod: Number,
  });

  const store = useStore();

  const gameModsList = computed(() => store.state.gameMods.gameModsList);

  const gamesOptions = computed(() => {
    return Object.entries(props.games).map(([gameCode, gameName]) => ({ value: gameCode, label: gameName }));
  });

  const gameModOptions = computed(() => {
    return gameModsList.value.map((gameMod) => ({ value: Number(gameMod.id), label: gameMod.name }));
  });

  const selectedGameCode = computed({
    get: () => store.state.games.gameCode,
    set: (gameCode) => store.dispatch('games/setGameCode', gameCode)
  });

  const selectedMod = computed({
    get: () => store.state.gameMods.gameMod,
    set: (gameMod) => store.dispatch('gameMods/setGameMod', gameMod)
  });

  watch(selectedGameCode, (gameCode) => {
    store.dispatch('gameMods/fetchGameModsList', gameCode);
  });

  watch(gameModsList, (val) => {
    if (props.initialGame !== selectedGameCode.value) {
      selectedMod.value = val.length > 0 ? val[0].id : '';
    } else {
      selectedMod.value = Number(props.initialMod);
    }
  });

  onMounted(() => {
    selectedGameCode.value = props.initialGame;
    selectedMod.value = props.initialMod;
  });
</script>

