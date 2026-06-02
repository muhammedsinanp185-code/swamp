<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { CheckCircleIcon, CalendarIcon, UserIcon } from '@heroicons/vue/24/outline';

defineProps<{
    preapprovedVisitors: any[]
}>();
</script>

<template>
    <Head title="Pre-approved Visitors" />

    <AuthenticatedLayout>
        <template #header>
            Pre-approved Visitors
        </template>

        <div class="space-y-6">
            <!-- Header -->
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Upcoming Visitor Passes</h2>
                <p class="text-sm text-gray-500 dark:text-zinc-400">{{ preapprovedVisitors.length }} passes pending</p>
            </div>

            <!-- Pre-approved Visitors Table -->
            <div class="bg-white dark:bg-zinc-900 shadow-sm ring-1 ring-black/5 dark:ring-white/5 rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-800">
                        <thead class="bg-gray-50 dark:bg-zinc-900/50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-xs font-semibold text-gray-900 dark:text-white">Visitor Name</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 dark:text-white">Email</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 dark:text-white">Phone</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 dark:text-white">Purpose</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 dark:text-white">Host</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 dark:text-white">Valid From</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 dark:text-white">Valid Until</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 dark:text-white">Type</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-zinc-800 bg-white dark:bg-zinc-900">
                            <tr v-if="preapprovedVisitors.length === 0" class="hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td colspan="8" class="py-8 text-center text-sm text-gray-500 dark:text-zinc-400">No pre-approved visitors pending.</td>
                            </tr>
                            <tr v-for="visitor in preapprovedVisitors" :key="visitor.id" class="hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm font-medium text-gray-900 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        <CheckCircleIcon class="w-5 h-5 text-green-500" />
                                        {{ visitor.visitor_name }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-zinc-400">{{ visitor.visitor_email || '-' }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-zinc-400">{{ visitor.visitor_phone || '-' }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-zinc-400">{{ visitor.purpose }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-zinc-400">
                                    <div class="flex items-center gap-2">
                                        <UserIcon class="w-4 h-4" />
                                        {{ visitor.host_name }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-zinc-400">
                                    <div class="flex items-center gap-2">
                                        <CalendarIcon class="w-4 h-4" />
                                        {{ visitor.valid_from }}
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-zinc-400">{{ visitor.valid_until }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm">
                                    <span :class="[
                                        visitor.pass_type === 'reusable' ? 'bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400 ring-blue-600/20 dark:ring-blue-500/20' :
                                        'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400 ring-indigo-600/20 dark:ring-indigo-500/20',
                                        'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset'
                                    ]">
                                        {{ visitor.pass_type }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
