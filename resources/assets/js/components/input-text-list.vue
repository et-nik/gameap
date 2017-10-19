<template>
    <div>
        <a href="#" v-on:click="addItem">+</a>
        <a href="#" v-on:click="printItems">print</a>
        <div class="form-group" v-for="(item, index) in items">
            <input v-bind:name="name + '[]'" type="text" v-bind:value="item" v-bind:id="name + '_' + index" class="form-control">
            <a href="#" v-on:click="removeItem(index)">X</a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['initialItems', 'name', 'label'],
        data: function () {
            return { items: this.initialItems }
        },
        methods: {
            removeItem: function(index) {
                this.items.splice(index, 1);
            },
            addItem: function() {
                this.items.push('');
            },
            printItems: function() {
                console.log(this.items);
            }
        }
    }
</script>