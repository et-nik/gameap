<template>
    <div>
        <div v-for="(item, itemIndex) in items">
            <div class="form-group">
                <label v-bind:for="inputName + '[' + itemIndex + ']' + '[name]'" class="control-label">Name</label>
                <input
                        v-bind:name="inputName + '[' + itemIndex + ']' + '[name]'"
                        v-bind:id="inputName + '[' + itemIndex + ']' + '[name]'"
                        v-model="item.name"
                        type="text"
                        class="form-control">
            </div>

            <div class="form-group">
                <label v-bind:for="inputName + '[' + itemIndex + ']' + '[value]'" class="control-label">Value</label>
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

        <div class="col-2 offset-5 centered mt-2">
            <button class="btn btn-sm btn-success" v-on:click.prevent="addItem"><i class="fa fa-plus"></i>&nbsp;{{ trans('main.add') }}</button>
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