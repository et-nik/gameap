<script>
import { useMessage, useDialog } from "naive-ui";
import { defineComponent } from "vue";

export default defineComponent({
    setup() {
        window.$message = useMessage();
        window.$dialog = useDialog();
    }
})
</script>

<template>
</template>
