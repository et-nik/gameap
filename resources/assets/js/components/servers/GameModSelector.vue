<template>
    <div>
        <div class="mb-3">
            <input type="hidden" name="game_id" v-model="selectedGameCode">

            <n-form-item :label="trans('labels.game_id')" :path="gamePath">
              <n-select
                  filterable
                  :disabled="gameSelectDisabled"
                  v-model:value="selectedGameCode"
                  :options="gamesOptions"
              />
            </n-form-item>

        </div>

        <div class="mb-3">
            <input type="hidden" name="game_mod_id" v-model="selectedMod">

            <n-form-item :label="trans('labels.game_mod_id')" :path="gameModPath">
              <n-select
                  filterable
                  v-model:value="selectedMod"
                  :disabled="!selectedGameCode"
                  :options="gameModOptions"
              />
            </n-form-item>
        </div>
    </div>
</template>

<script setup>
  import { computed, watch, onMounted, defineModel } from 'vue';
  import { useStore } from 'vuex';
  import {trans} from "../../i18n/i18n";
  import {NFormItem} from "naive-ui";

  const props = defineProps({
    games: Object,
    gamePath: "game",
    gameModPath: "gameMod",
    gameSelectDisabled: false,
  });

  const gameModel = defineModel('game')
  const gameModModel = defineModel('gameMod')

  const store = useStore();

  const gameModsList = computed(() => store.state.gameMods.gameModsList);

  const gamesOptions = computed(() => {
    return Object.entries(props.games).map(([gameCode, gameName]) => ({ value: gameCode, label: gameName }));
  });

  const gameModOptions = computed(() => {
    return gameModsList.value.map((gameMod) => ({ value: Number(gameMod.id), label: gameMod.name }));
  });

  const selectedGameCode = computed({
    get: () => {
      if (
          !store.state.games.gameCode ||
          store.state.games.gameCode === ""
      ) {
        return null;
      }

      return store.state.games.gameCode
    },
    set: (gameCode) => {
      gameModel.value = gameCode;
      store.dispatch('games/setGameCode', gameCode)
    }
  });

  const selectedMod = computed({
    get: () => {
      if (
          !store.state.gameMods.gameMod ||
          store.state.gameMods.gameMod === ""
      ) {
        return null;
      }

      return store.state.gameMods.gameMod
    },
    set: (gameMod) => {
      gameModModel.value = gameMod;
      store.dispatch('gameMods/setGameMod', gameMod)
    }
  });

  watch(selectedGameCode, (gameCode) => {
    store.dispatch('gameMods/fetchGameModsList', gameCode);
  });

  watch(gameModsList, (val) => {
    let mod = 0
    if (val.length > 0) {
      mod = val[0].id
    }
    const found = val.find((element) => element.id === gameModModel.value);
    if (found) {
      mod = gameModModel.value;
    }

    selectedMod.value = mod;
  });

  watch(gameModel, (val) => {
    if (val !== 0) {
      selectedGameCode.value = val;
    }
  });

  watch(gameModModel, (val) => {
    if (val !== 0) {
      selectedMod.value = val;
    }
  });
</script>

