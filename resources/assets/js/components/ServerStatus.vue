<template>
    <div class="container">
        <div class="row" v-for="(value, key) in items">
            <div class="col-md-2 offset-md-2">
                {{ key }} :
            </div>
            <div class="col-md-8">
                {{ value }}
            </div>
        </div>
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
