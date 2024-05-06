<template>
  <RouterView :key="$route.path"/>
</template>

<script setup>
import { useMessage, useDialog } from "naive-ui"
import { useRouter, useRoute } from "vue-router"
import {onMounted} from "vue";

const router = useRouter()
const route = useRoute()

window.$message = useMessage();
window.$dialog = useDialog();

onMounted(() => {
  const resolved = router.resolve(window.location.pathname)
  if (resolved.name) {
    router.replace(resolved)
  }
});
</script>