<template>
    <div class="block w-full overflow-auto scrolling-touch">
        <div class="mb-3">
            <button class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded  no-underline py-1 px-2 leading-tight text-xs  bg-green-500 text-white hover:bg-green-600" v-on:click.prevent="addItem"><span class="fa fa-plus"></span></button>
        </div>

        <table class="w-full max-w-full mb-4 bg-transparent table-striped table-bordered">
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
                        <div class="mb-3">
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
                        <button class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded  no-underline py-1 px-2 leading-tight text-xs  bg-red-600 text-white hover:bg-red-700" v-on:click.prevent="removeItem(itemIndex)">
                            <span class="fa fa-times"></span>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mb-3 md:w-1/6 pr-4 pl-4 md:mx-1/2 centered">
            <button class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded  no-underline py-1 px-2 leading-tight text-xs  bg-green-500 text-white hover:bg-green-600" v-on:click.prevent="addItem"><span class="fa fa-plus"></span>&nbsp;{{ trans('main.add') }}</button>
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
