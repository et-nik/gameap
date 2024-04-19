<template>
  <!-- Breadcrumb -->
  <nav class="flex pt-3 pb-3 py-4 px-4 mb-4 text-gray-700 border border-stone-200 rounded-lg bg-stone-100 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
      <li v-for="item in items.slice(0, 1)" class="inline-flex items-center">
        <a v-if="item.link" :href="item.link" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
          <i v-if="item.icon" :class="item.icon" class="mr-0.5"></i>
          {{ item.text }}
        </a>
        <span v-else class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">{{ item.text }}</span>
      </li>

      <li v-for="item in items.slice(1)">
        <div class="flex items-center">
          <svg class="rtl:rotate-180 block w-3 h-3 mx-1 text-gray-400 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
          </svg>
          <i v-if="item.icon !== ''" :class="item.icon" class="mr-0.5"></i>
          <a v-if="item.link" :href="item.link" class="ms-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ms-2 dark:text-gray-400 dark:hover:text-white">
            {{ item.text }}
          </a>
          <span v-else class="ms-1 text-sm font-medium text-gray-500 md:ms-2 dark:text-gray-400">
            {{ item.text }}
          </span>
        </div>
      </li>
    </ol>
  </nav>
</template>

<script setup>
const props = defineProps({
  items: null,
});

</script>

<style scoped>

</style>