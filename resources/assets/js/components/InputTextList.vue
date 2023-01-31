<template>
    <div>
        <div class="form-group deletable" v-for="(item, index) in items">
            <div class="row">
                <div class="col-md-12">
                    <input type="text" v-model="items[index]" v-bind:name="name + '[]'" v-bind:id="name + '_' + index" class="form-control">
                    <button class="btn btn-danger" v-on:click.prevent="removeItem(index)">
                      <span class="fa fa-times"></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="form-group">
            <button class="btn btn-success" v-on:click.prevent="addItem"><span class="fa fa-plus"></span></button>
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