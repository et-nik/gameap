<template>
    <div>
        <div class="mb-3">
            <input type="hidden" name="game_id" v-model="selectedGameCode">

            <n-form-item :label="trans('labels.game_id')" :path="gamePath">
              <n-select filterable v-model:value="selectedGameCode" :options="gamesOptions" />
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
    initialGame: String,
    initialMod: Number,
    gamePath: "game",
    gameModPath: "gameMod",
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
    get: () => store.state.games.gameCode,
    set: (gameCode) => {
      gameModel.value = gameCode;
      store.dispatch('games/setGameCode', gameCode)
    }
  });

  const selectedMod = computed({
    get: () => store.state.gameMods.gameMod,
    set: (gameMod) => {
      gameModModel.value = gameMod;
      store.dispatch('gameMods/setGameMod', gameMod)
    }
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

