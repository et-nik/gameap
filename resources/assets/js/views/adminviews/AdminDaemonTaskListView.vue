<template>
  <GBreadcrumbs :items="breadcrumbs"></GBreadcrumbs>
</template>

<script setup>
import GBreadcrumbs from "../../components/GBreadcrumbs.vue"
import {computed, h, ref, onMounted} from "vue"
import {
  NModal,
  NTable,
  NDataTable,
} from "naive-ui"
import {trans} from "../../i18n/i18n"

const breadcrumbs = computed(() => {
  return [
    {'route':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
    {'route':{name: 'admin.nodes.index'}, 'text':trans('gdaemon_tasks.gdaemon_tasks')},
  ]
})
</script>