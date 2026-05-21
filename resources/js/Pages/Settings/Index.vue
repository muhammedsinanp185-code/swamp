<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Cog6ToothIcon, ShieldCheckIcon, BuildingOfficeIcon, CreditCardIcon } from '@heroicons/vue/24/outline';

const tabs = [
    { name: 'Organization', icon: BuildingOfficeIcon, current: true },
    { name: 'Roles & Security', icon: ShieldCheckIcon, current: false },
    { name: 'Billing', icon: CreditCardIcon, current: false },
    { name: 'General Preferences', icon: Cog6ToothIcon, current: false },
];
</script>

<template>
    <Head title="Settings" />

    <AuthenticatedLayout>
        <template #header>
            Organization Settings
        </template>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Navigation for Settings -->
            <aside class="w-full lg:w-64 flex-shrink-0">
                <nav class="space-y-1">
                    <button v-for="tab in tabs" :key="tab.name" :class="[tab.current ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400' : 'text-gray-700 hover:bg-gray-100 dark:text-zinc-400 dark:hover:bg-zinc-800/50 dark:hover:text-white', 'group flex items-center w-full px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200']">
                        <component :is="tab.icon" :class="[tab.current ? 'text-indigo-700 dark:text-indigo-400' : 'text-gray-400 group-hover:text-gray-600 dark:text-zinc-500 dark:group-hover:text-zinc-300', 'flex-shrink-0 -ml-1 mr-3 h-5 w-5']" aria-hidden="true" />
                        {{ tab.name }}
                    </button>
                </nav>
            </aside>

            <!-- Main Settings Content Area -->
            <div class="flex-1 max-w-3xl">
                <div class="bg-white dark:bg-zinc-900 shadow-sm ring-1 ring-black/5 dark:ring-white/5 rounded-2xl p-6 sm:p-8">
                    <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Organization Profile</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-zinc-400">Update your company details and branding settings used across the platform.</p>

                    <div class="mt-8 space-y-6">
                        <div>
                            <label class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Company Name</label>
                            <div class="mt-2">
                                <input type="text" value="Acme Corporation" class="block w-full rounded-xl border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-indigo-500" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Primary Brand Color</label>
                            <div class="mt-2 flex items-center gap-4">
                                <input type="color" value="#4f46e5" class="h-10 w-10 p-0 border-0 rounded-lg cursor-pointer bg-transparent" />
                                <span class="text-sm text-gray-500 dark:text-zinc-400">Used for QR passes and email notifications</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Organization Type</label>
                            <div class="mt-2">
                                <select class="block w-full rounded-xl border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-indigo-500">
                                    <option>Office Building</option>
                                    <option>Apartment / Residential</option>
                                    <option>School / University</option>
                                    <option>Warehouse / Factory</option>
                                </select>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 dark:border-zinc-800 pt-6 flex justify-end">
                            <button class="rounded-xl bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
