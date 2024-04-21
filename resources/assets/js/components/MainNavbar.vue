<template>
  <nav class="fixed z-50 top-0 w-full bg-stone-900">
    <div class="w-full px-2 sm:px-6 lg:px-8">
      <div class="relative flex h-16 items-center justify-between">
        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
          <!-- Mobile menu button-->
          <button type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-stone-400 hover:bg-stone-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
            <span class="absolute -inset-0.5"></span>
            <span class="sr-only">Open main menu</span>
            <!--
              Icon when menu is closed.

              Menu open: "hidden", Menu closed: "block"
            -->
            <svg class="block h-6 w-6" fill="none" viewBox="0 0  24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <!--
              Icon when menu is open.

              Menu open: "block", Menu closed: "hidden"
            -->
            <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
          <div class="flex flex-shrink-0 items-center">
            <a id="brand-link" class="navbar-brand" href="/">
              <img id="brand-logo" src="/images/gap_logo_white.png" class="logo" alt="GameAP">
            </a>
          </div>
          <div class="hidden sm:ml-6 sm:block">
            <div class="flex space-x-4">
              <!-- Current: "bg-stone-900 text-white", Default: "text-stone-300 hover:bg-stone-700 hover:text-white" -->
              <a href="#" class="bg-stone-900 text-white rounded-md px-3 py-2 text-sm font-medium" aria-current="page">{{ trans('navbar.main') }}</a>
              <a href="#" class="text-stone-300 hover:bg-stone-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">{{ trans('navbar.admin') }}</a>
              <a href="#" class="text-stone-300 hover:bg-stone-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">{{ trans('navbar.users') }}</a>
            </div>
          </div>
        </div>
        <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
          <GButton color="black" size="small" class="mr-1">
            <i class="fa-solid fa-user"></i>
            {{ user.name }}
          </GButton>
          <GButton color="red" size="small">
            <i class="fa-solid fa-sign-out-alt"></i>
            {{ trans('navbar.sign_out') }}
          </GButton>
        </div>
      </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="sm:hidden" id="mobile-menu">
      <div class="space-y-1 px-2 pb-3 pt-2">
        <!-- Current: "bg-stone-900 text-white", Default: "text-stone-300 hover:bg-stone-700 hover:text-white" -->
        <a href="#" class="bg-stone-900 text-white block rounded-md px-3 py-2 font-medium" aria-current="page">{{ trans('navbar.main') }}</a>
        <a href="#" class="text-stone-300 hover:bg-stone-700 hover:text-white block rounded-md px-3 py-2 font-medium">{{ trans('navbar.admin') }}</a>
        <a href="#" class="text-stone-300 hover:bg-stone-700 hover:text-white block rounded-md px-3 py-2 font-medium">{{ trans('navbar.users') }}</a>
      </div>
    </div>
  </nav>
</template>

<script setup>
import {trans} from "../i18n/i18n";
import {computed} from 'vue'
import GButton from "./GButton.vue";

const user = computed(() => {
    return window.user
})
</script>