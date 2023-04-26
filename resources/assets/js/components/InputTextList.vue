<template>
    <div>
        <div class="mb-3 deletable" v-for="(item, index) in items" :key="index">
            <div class="row">
                <div class="col-md-12">
                    <input type="text" v-model="items[index]" :name="name + '[]'" :id="name + '_' + index" class="form-control">
                    <button class="btn btn-danger" @click.prevent="removeItem(index)">
                        <span class="fa fa-times"></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <button class="btn btn-success" @click.prevent="addItem"><span class="fa fa-plus"></span></button>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';
export default {
    props: {
        initialItems: Array,
        label: String,
        name: String
    },
    setup(props) {
        const items = ref(props.initialItems);

        const removeItem = (index) => {
            items.value.splice(index, 1);
        };

        const addItem = () => {
            if (items.value === undefined) {
                items.value = []
            }
            items.value.push('');
        };

        return {
            items,
            removeItem,
            addItem
        };
    }
}
</script>
