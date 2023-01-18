<template>
    <div class="table-responsive">
        <div class="form-group">
            <button class="btn btn-sm btn-success" v-on:click.prevent="addItem"><span class="fa fa-plus"></span></button>
        </div>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <td v-for="label in labels">
                        {{ label }}
                    </td>
                    <td>{{ trans('main.actions')}}</td>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, itemIndex) in items">
                    <td v-for="(keyName, keyIndex) in keys">
                        <div class="form-group">
                            <input
                                    v-bind:type="inputTypes[keyIndex]"
                                    v-model="item[keyName]"
                                    v-bind:name="name + '[' + itemIndex + ']' + '[' + keyName + ']'"
                                    v-bind:id="name + '_' + itemIndex + '_' + keyName"
                                    v-bind:class="classes[inputTypes[keyIndex]]"
                            >
                        </div>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-danger" v-on:click.prevent="removeItem(itemIndex)">
                            <span class="fa fa-times"></span>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="form-group col-md-1 offset-md-6 centered">
            <button class="btn btn-sm btn-success" v-on:click.prevent="addItem"><span class="fa fa-plus"></span>&nbsp;{{ trans('main.add') }}</button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            initialItems: Array,
            labels: Array,
            keys: Array,
            inputTypes: Array,
            //classes: Array,
            name: String,
        },
        data: function () {
            return {
                items: this.initialItems,
                classes: {
                    'text': 'form-control',
                    'checkbox': '',
                }
            }
        },
        methods: {
            removeItem: function(index) {
                this.items.splice(index, 1);
            },
            addItem: function() {
                let emptyItem = {};
                this.keys.forEach(function(item) {
                    emptyItem[item] = '';
                });

                this.items.push(emptyItem);
            }
        }
    }
</script>
