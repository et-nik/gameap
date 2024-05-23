<template>
  <GBreadcrumbs :items="breadcrumbs"></GBreadcrumbs>
</template>

<script setup>
import {computed, defineAsyncComponent} from "vue"
import GBreadcrumbs from "../components/GBreadcrumbs.vue"
import {trans} from "../i18n/i18n"

const breadcrumbs = computed(() => {
  return [
    {'route':'/', 'text':'GameAP', 'icon': 'fas fa-home'},
    {'route':{name: 'profile'}, 'text':trans('profile.profile')},
  ]
})
</script>