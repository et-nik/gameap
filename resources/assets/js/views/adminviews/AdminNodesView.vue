<template>
  <GBreadcrumbs :items="breadcrumbs"></GBreadcrumbs>
</template>

<script setup>
import GBreadcrumbs from "../../components/GBreadcrumbs.vue";
import {computed} from "vue";
import {trans} from "../../i18n/i18n";

const breadcrumbs = computed(() => {
  return [
    {'route':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
    {'route':{name: 'admin.nodes.index'}, 'text':trans('sidebar.dedicated_servers')},
  ]
})
</script>