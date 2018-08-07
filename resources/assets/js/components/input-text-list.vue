<template>
    <div>
        <div class="form-group">
            <a class="btn btn-sm btn-success" v-on:click="addItem">+</a>
        </div>

        <div class="form-group" v-for="(item, index) in items">
            <div class="row">
                <div class="col-md-10">
                    <input type="text" v-model="items[index]" v-bind:name="name + '[]'" v-bind:id="name + '_' + index" class="form-control">
                </div>
                <div class="col-md-2">
                    <a class="btn btn-sm btn-danger" v-on:click.prevent="removeItem(index)">X</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            initialItems: Array,
            label: String,
            name: String
        },
        data: function () {
            return { items: this.initialItems }
        },
        methods: {
            removeItem: function(index) {
                this.items.splice(index, 1);
            },
            addItem: function() {
                this.items.push('');
            }
        }
    }
</script>