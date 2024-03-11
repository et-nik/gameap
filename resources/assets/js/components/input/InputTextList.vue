<template>
    <div>
        <div class="mb-3 deletable" v-for="(item, index) in items" :key="index">
            <div class="flex flex-wrap ">
                <div class="md:w-full pr-4 pl-4 relative flex items-stretch w-full">
                    <input type="text" v-model="items[index]" :name="name + '[]'" :id="name + '_' + index" class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded">
                    <button class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-red-600 text-white hover:bg-red-700" @click.prevent="removeItem(index)">
                        <span class="fa fa-times"></span>
                    </button>
                </div>
            </div>
        </div>
        <div class="mb-3">
            <button class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-green-500 text-white hover:bg-green-600" @click.prevent="addItem"><span class="fa fa-plus"></span></button>
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
