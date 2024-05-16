<template>
  <GBreadcrumbs :items="breadcrumbs"></GBreadcrumbs>

  <div class="mb-5">
    <GButton class="mr-1" color="green" link="#">
      <i class="fa-solid fa-plus-square"></i>&nbsp;{{ trans('games.add') }}
    </GButton>

    <GButton class="mr-1" color="orange" link="#">
      <i class="fa-solid fa-cat"></i>&nbsp;{{ trans('games.add_mod') }}
    </GButton>

    <GButton class="mr-1" color="black" link="#">
      <i class="fa-solid fa-sync"></i>&nbsp{{ trans('games.upgrade')}}
    </GButton>
  </div>

  <n-data-table
      ref="tableRef"
      :bordered="false"
      :single-line="true"
      :columns="columns"
      :data="gamesData"
      :loading="loading"
      :pagination="pagination"
  >
    <template #loading>
      <Loading />
    </template>
    <template #empty>
      <n-empty :description="trans('servers.empty_list')">
      </n-empty>
    </template>
  </n-data-table>
</template>

<script setup>
import GBreadcrumbs from "../../components/GBreadcrumbs.vue"
import {computed, ref, onMounted, h} from "vue"
import {trans} from "../../i18n/i18n"
import GButton from "../../components/GButton.vue"
import Loading from "../../components/Loading.vue"
import {useGamesStore} from "../../store/games"
import {NEmpty, NDataTable} from "naive-ui"
import {storeToRefs} from "pinia"
import GDeletableList from "../../components/GDeletableList.vue";

const gamesStore = useGamesStore()

const breadcrumbs = computed(() => {
  return [
    {'route':'/', 'text':'GameAP', 'icon': 'fa-solid fa-home'},
    {'route':{name: 'admin.games.index'}, 'text':trans('games.games')},
  ]
})

onMounted(() => {
  gamesStore.fetchGames()
  gamesStore.fetchAllGameMods()
})

const createColumns = () => {
  return [
    {
      title: trans('games.name'),
      key: 'name',
    },
    {
      title: trans('games.code'),
      key: 'code',
    },
    {
      title: trans('games.engine'),
      key: 'engine',
    },
    {
      title: trans('games.mods'),
      key: 'mods',
      render(row) {
        if (row.mods.length === 0) {
          return h(GButton, {
            color: 'orange',
            size: 'small',
            class: 'px-2 py-1',
            link: '#',
          }, [
            h("i", {class: 'fa-solid fa-cat mr-0.5'}),
            h("span", {class: ''}, trans('games.add_first_mod'))
          ])
        }

        return h(
            GDeletableList,
            {
              items: row.mods,
              deleteCallback: onClickModDelete,
              clickCallback: onClickMod,
            }
        )
      },
    },
    {
      title: trans('main.actions'),
      render(row) {
        return [
          h(GButton, {
            color: 'blue',
            size: 'small',
            class: 'mr-0.5',
            // route: {name: 'admin.servers.edit', params: {id: row.id}},
          }, [
            h("i", {class: 'fa-solid fa-pen-to-square'}),
            h("span", {class: 'hidden xl:inline'}, trans('main.edit')),
          ]),
          h(GButton, {
            color: 'red',
            size: 'small',
            text: trans('main.delete'),
            // onClick: () => {onClickDelete(row.id)},
          }, [
            h("i", {class: 'fa-solid fa-trash'}),
            h("span", {class: 'hidden xl:inline'}, trans('main.delete')),
          ]),
        ]
      },
    }
  ]
}

const {loading, games, allGameMods} = storeToRefs(gamesStore)

const columns = ref(createColumns())
const pagination = {
  pageSize: 50,
};

const gamesData = computed(() => {
  let result = []

  games.value.forEach((game) => {
    result.push({
      name: game.name,
      code: game.code,
      engine: game.engine,
      mods: getGameMods(game.code),
    })
  })

  return result
})

const getGameMods = (gameCode) => {
  let mods = []
  allGameMods.value.forEach((gameMod) => {
    if (gameMod.game_code === gameCode) {
      mods.push(gameMod)
    }
  })

  return mods
}

const onClickModDelete = (id) => {
  console.log('ID:', id)
}

const onClickMod = (id) => {
  console.log('ID:', id)
}
</script>