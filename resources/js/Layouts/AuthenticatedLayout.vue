<script setup lang="ts">
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import { Link, usePage } from '@inertiajs/vue3';
import {
  HomeIcon,
  UsersIcon,
  QrCodeIcon,
  TruckIcon,
  ShieldCheckIcon,
  Cog6ToothIcon,
  Bars3Icon,
  XMarkIcon,
  BellIcon,
  MoonIcon,
  SunIcon
} from '@heroicons/vue/24/outline';

const showingSidebar = ref(false);
const isDarkMode = ref(false);
const showNotifications = ref(false);

const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value;
    if (isDarkMode.value) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
};

const navigation = [
  { name: 'Dashboard', href: route('dashboard'), icon: HomeIcon, current: route().current('dashboard') },
  { name: 'Visitors', href: route('visitors.index'), icon: UsersIcon, current: route().current('visitors.*') },
  { name: 'QR Scanner', href: route('scanner.index'), icon: QrCodeIcon, current: route().current('scanner.*') },
  { name: 'Parcels', href: route('parcels.index'), icon: TruckIcon, current: route().current('parcels.*') },
  { name: 'Guards/Entry', href: route('scanner.index'), icon: ShieldCheckIcon, current: false },
  { name: 'Settings', href: route('settings.index'), icon: Cog6ToothIcon, current: route().current('settings.*') },
];
</script>

<template>
  <div :class="{'dark': isDarkMode}" class="min-h-screen bg-gray-50 dark:bg-zinc-900 transition-colors duration-200 flex">
    
    <!-- Mobile Sidebar Backdrop -->
    <div v-if="showingSidebar" @click="showingSidebar = false" class="fixed inset-0 z-40 bg-gray-900/80 backdrop-blur-sm lg:hidden"></div>

    <!-- Sidebar -->
    <aside :class="[showingSidebar ? 'translate-x-0' : '-translate-x-full', 'fixed inset-y-0 left-0 z-50 w-72 bg-white dark:bg-zinc-950 border-r border-gray-200 dark:border-zinc-800 transition-transform duration-300 lg:static lg:translate-x-0 flex flex-col']">
      <div class="flex items-center justify-between h-16 px-6 border-b border-gray-200 dark:border-zinc-800">
        <Link :href="route('dashboard')" class="flex items-center gap-3">
          <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
            <ShieldCheckIcon class="w-5 h-5 text-white" />
          </div>
          <span class="text-xl font-bold text-gray-900 dark:text-white tracking-tight">SWAMP</span>
        </Link>
        <button @click="showingSidebar = false" class="lg:hidden text-gray-500 hover:text-gray-900 dark:text-zinc-400 dark:hover:text-white">
          <XMarkIcon class="w-6 h-6" />
        </button>
      </div>

      <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        <Link v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400' : 'text-gray-700 hover:bg-gray-100 dark:text-zinc-400 dark:hover:bg-zinc-800/50 dark:hover:text-white', 'group flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200']">
          <component :is="item.icon" :class="[item.current ? 'text-indigo-700 dark:text-indigo-400' : 'text-gray-400 group-hover:text-gray-600 dark:text-zinc-500 dark:group-hover:text-zinc-300', 'flex-shrink-0 -ml-1 mr-3 h-5 w-5']" aria-hidden="true" />
          {{ item.name }}
        </Link>
      </nav>

      <div class="p-4 border-t border-gray-200 dark:border-zinc-800">
        <div class="flex items-center gap-3 px-3 py-2 rounded-xl bg-gray-50 dark:bg-zinc-900/50">
          <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-700 dark:text-indigo-400 font-bold">
            {{ $page.props.auth.user.name.charAt(0) }}
          </div>
          <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $page.props.auth.user.name }}</p>
            <p class="text-xs text-gray-500 dark:text-zinc-500 truncate">{{ $page.props.auth.user.email }}</p>
          </div>
        </div>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
      <!-- Topbar -->
      <header class="h-16 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-md border-b border-gray-200 dark:border-zinc-800 flex items-center justify-between px-4 sm:px-6 lg:px-8 sticky top-0 z-30">
        <div class="flex items-center gap-4">
          <button @click="showingSidebar = true" class="lg:hidden text-gray-500 hover:text-gray-900 dark:text-zinc-400 dark:hover:text-white">
            <Bars3Icon class="w-6 h-6" />
          </button>
          
          <h1 v-if="$slots.header" class="text-xl font-semibold text-gray-900 dark:text-white hidden sm:block tracking-tight">
            <slot name="header" />
          </h1>
        </div>

        <div class="flex items-center gap-4">
          <!-- Dark Mode Toggle -->
          <button @click="toggleDarkMode" class="p-2 text-gray-500 hover:bg-gray-100 rounded-full dark:text-zinc-400 dark:hover:bg-zinc-800 transition-colors">
            <MoonIcon v-if="!isDarkMode" class="w-5 h-5" />
            <SunIcon v-else class="w-5 h-5" />
          </button>

          <!-- Notifications -->
          <div class="relative">
            <button @click="showNotifications = !showNotifications" class="p-2 text-gray-500 hover:bg-gray-100 rounded-full dark:text-zinc-400 dark:hover:bg-zinc-800 transition-colors">
              <BellIcon class="w-5 h-5" />
              <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border border-white dark:border-zinc-900"></span>
            </button>

            <div v-if="showNotifications" class="absolute right-0 mt-2 w-80 bg-white dark:bg-zinc-900 shadow-lg rounded-xl z-50 ring-1 ring-black/5 dark:ring-white/5">
              <div class="p-4">
                <p class="text-sm text-gray-700 dark:text-zinc-300">No notifications</p>
              </div>
            </div>
          </div>

          <!-- Settings Dropdown -->
          <Dropdown align="right" width="48">
            <template #trigger>
              <button type="button" class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-zinc-300 hover:text-gray-900 dark:hover:text-white focus:outline-none transition-colors">
                <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-700 dark:text-indigo-400 font-bold border border-indigo-200 dark:border-indigo-800/50">
                  {{ $page.props.auth.user.name.charAt(0) }}
                </div>
              </button>
            </template>
            <template #content>
              <DropdownLink :href="route('profile.edit')">Profile</DropdownLink>
              <DropdownLink :href="route('logout')" method="post" as="button">Log Out</DropdownLink>
            </template>
          </Dropdown>
        </div>
      </header>

      <!-- Page Content -->
      <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
        <slot />
      </main>
    </div>
  </div>
</template>

<style>
/* Smooth transition for theme toggle */
.dark {
    color-scheme: dark;
}
</style>
