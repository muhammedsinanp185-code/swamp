<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { TruckIcon, PlusIcon, MagnifyingGlassIcon } from '@heroicons/vue/24/outline';

const props = defineProps<{
    parcels: any[];
}>();
</script>

<template>
    <Head title="Parcels" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <span>Parcel Management</span>
                <button class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 transition-colors">
                    <PlusIcon class="h-5 w-5" />
                    Log New Parcel
                </button>
            </div>
        </template>

        <div class="bg-white dark:bg-zinc-900 shadow-sm ring-1 ring-black/5 dark:ring-white/5 rounded-2xl overflow-hidden">
            <div class="p-4 border-b border-gray-200 dark:border-zinc-800 flex items-center bg-gray-50 dark:bg-zinc-900/50">
                <div class="relative w-full max-w-md">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                    </div>
                    <input type="text" class="block w-full rounded-xl border-0 py-2.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-indigo-500" placeholder="Search by tracking number or recipient..." />
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-800">
                    <thead class="bg-white dark:bg-zinc-900">
                        <tr>
                            <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Courier</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Tracking Number</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Recipient</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Status</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Arrived At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-zinc-800 bg-white dark:bg-zinc-900">
                        <tr v-if="parcels.length === 0">
                            <td colspan="5" class="py-12 text-center text-gray-500 dark:text-zinc-400">
                                No parcels logged today.
                            </td>
                        </tr>
                        <tr v-for="parcel in parcels" :key="parcel.id" class="hover:bg-gray-50 dark:hover:bg-zinc-800/50">
                            <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm font-medium text-gray-900 dark:text-white">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg text-indigo-600 dark:text-indigo-400">
                                        <TruckIcon class="w-5 h-5" />
                                    </div>
                                    {{ parcel.courier_name }}
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-zinc-400">{{ parcel.tracking_number }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-zinc-400">{{ parcel.recipient_name }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm">
                                <span :class="[
                                    parcel.status === 'received' ? 'bg-yellow-50 text-yellow-800 ring-yellow-600/20 dark:bg-yellow-500/10 dark:text-yellow-400 dark:ring-yellow-500/20' : 
                                    'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-500/10 dark:text-green-400 dark:ring-green-500/20',
                                    'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset'
                                ]">
                                    {{ parcel.status.charAt(0).toUpperCase() + parcel.status.slice(1) }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-zinc-400">{{ parcel.arrived_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
