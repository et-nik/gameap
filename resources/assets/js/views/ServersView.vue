<template>
  <ServerMainList />
</template>

<script setup>
import {defineAsyncComponent} from "vue";

const ServerMainList = defineAsyncComponent(() =>
    import('./servertabs/ServerMainList.vue' /* webpackChunkName: "components/server" */)
)
</script>