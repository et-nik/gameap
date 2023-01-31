<template>
    <div>
        <div class="card mb-2">
            <div class="card-body">
                <div v-for="(item, itemIndex) in items">
                    <div class="form-group">
                        <label v-bind:for="inputName + '[' + itemIndex + ']' + '[name]'" class="control-label">{{ trans('labels.name') }}</label>
                        <input
                                v-bind:name="inputName + '[' + itemIndex + ']' + '[name]'"
                                v-bind:id="inputName + '[' + itemIndex + ']' + '[name]'"
                                v-model="item.name"
                                type="text"
                                class="form-control">
                    </div>

                    <div class="form-group">
                        <label v-bind:for="inputName + '[' + itemIndex + ']' + '[value]'" class="control-label">{{ trans('labels.the_value') }}</label>
                        <textarea
                                v-bind:name="inputName + '[' + itemIndex + ']' + '[value]'"
                                v-bind:id="inputName + '[' + itemIndex + ']' + '[value]'"
                                v-model="item.value"
                                class="form-control"
                                v-bind:rows='(item.value.match(new RegExp("\n", "g")) || []).length + 2'>
                        </textarea>
                    </div>

                    <button class="btn btn-sm btn-danger" v-on:click.prevent="removeItem(itemIndex)">
                        <i class="fa fa-times"></i> {{ trans('main.delete') }}
                    </button>

                    <hr>
                </div>
                <div class="mt-2 text-center">
                  <button class="btn btn-sm btn-success" v-on:click.prevent="addItem"><i class="fa fa-plus"></i>&nbsp;{{ trans('main.add') }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SettingsParameters",
        props: {
            initialItems: Array,
            inputName: String,
        },
        data: function () {
            return {
                items: this.initialItems || [],
            }
        },
        methods: {
            addItem: function() {
                this.items.push({
                    name: '',
                    value: ''
                });
            },
            removeItem: function(index) {
                this.items.splice(index, 1);
            }
        }
    }
</script>
