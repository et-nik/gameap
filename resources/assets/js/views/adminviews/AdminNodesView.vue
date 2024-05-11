<template>
  <GBreadcrumbs :items="breadcrumbs"></GBreadcrumbs>

  <GButton color="green" size="middle" class="mb-5 mr-1">
    <i class="fa fa-plus-square mr-0.5"></i>
    <span>{{ trans('dedicated_servers.create')}}</span>
  </GButton>

  <GButton color="orange" size="middle" class="mb-5">
    <i class="fa-solid fa-certificate mr-0.5"></i>
    <span>{{ trans('client_certificates.client_certificates')}}</span>
  </GButton>

  <n-data-table
      ref="tableRef"
      :bordered="false"
      :single-line="true"
      :columns="columns"
      :data="nodesData"
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
import {computed, h, ref, onMounted} from "vue"
import {trans} from "../../i18n/i18n"
import GButton from "../../components/GButton.vue"
import {useNodeListStore} from "../../store/nodeList"
import {errorNotification} from "../../parts/dialogs"
import Loading from "../../components/Loading.vue"
import {storeToRefs} from "pinia"

const nodeListStore = useNodeListStore()

const breadcrumbs = computed(() => {
  return [
    {'route':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
    {'route':{name: 'admin.nodes.index'}, 'text':trans('sidebar.dedicated_servers')},
  ]
})

const createColumns = () => {
  return [
    {
      title: trans('dedicated_servers.name'),
      key: "name"
    },
    {
      title: trans('dedicated_servers.location'),
      key: "location"
    },
    {
      title: trans('dedicated_servers.provider'),
      key: "provider"
    },
    {
      title: trans('dedicated_servers.ip'),
      key: "ip"
    },
    {
      title: trans('dedicated_servers.os'),
      key: "os"
    },
    {
      title: trans('main.actions'),
      render(row) {
        return [
          h(GButton, {
            color: 'blue',
            size: 'small',
            class: 'mr-0.5',
            route: {name: 'admin.nodes.edit', params: {id: row.id}},
          }, [
            h("i", {class: 'fa-solid fa-pen-to-square'}),
            h("span", {class: 'hidden xl:inline'}, trans('main.edit')),
          ]),
          h(GButton, {
            color: 'red',
            size: 'small',
            text: trans('main.delete'),
            onClick: () => {onClickDelete(row.id)},
          }, [
            h("i", {class: 'fa-solid fa-trash'}),
            h("span", {class: 'hidden xl:inline'}, trans('main.delete')),
          ]),
        ]
      },
    }
  ]
}

const {loading, nodes} = storeToRefs(nodeListStore)

const columns = ref(createColumns())
const pagination = {
  pageSize: 20,
};

onMounted(() => {
  fetchNodes()
})

const fetchNodes = () => {
  nodeListStore.fetchNodesByFilter([]).
  catch((error) => {
    errorNotification(error)
  })
}

const nodesData = computed(() => {
  return nodes.value.map((node) => {
    return {
      id: node.id,
      name: node.name,
      location: node.location,
      provider: node.provider,
      ip: node.ip,
      os: node.os,
    }
  })
})

</script>