<template>
    <div class="query">
        <ul class="list-group list-group-flush" v-for="(value, key) in items">
            <li class="list-group-item">{{ key }} : {{ value }}</li>
        </ul>
    </div>
</template>

<script>
    export default {
        props: {
            serverId: Number
        },
        data: function () {
            return { items: null };
        },
        mounted() {
            axios.get('/api/servers/query/' + this.serverId)
                .then(response => (this.items = response.data));
        }
    }
</script>
