<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { UsersIcon, QrCodeIcon, ShieldCheckIcon, ChartBarIcon } from '@heroicons/vue/24/outline';

const stats = [
    { name: 'Total Visitors Today', value: '142', change: '+12%', changeType: 'positive', icon: UsersIcon },
    { name: 'Active QR Passes', value: '85', change: '+5%', changeType: 'positive', icon: QrCodeIcon },
    { name: 'Entries Logged', value: '312', change: '+18%', changeType: 'positive', icon: ShieldCheckIcon },
    { name: 'Peak Time', value: '10:00 AM', change: 'Stable', changeType: 'neutral', icon: ChartBarIcon },
];

const recentVisitors = [
    { id: 1, name: 'John Doe', purpose: 'Meeting', time: '10:15 AM', status: 'Checked In' },
    { id: 2, name: 'Sarah Smith', purpose: 'Delivery', time: '09:45 AM', status: 'Checked Out' },
    { id: 3, name: 'Mike Johnson', purpose: 'Interview', time: '09:30 AM', status: 'Checked In' },
    { id: 4, name: 'Emily Davis', purpose: 'Maintenance', time: '08:15 AM', status: 'Checked Out' },
];
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            Dashboard Overview
        </template>

        <div class="space-y-6">
            <!-- Stats -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div v-for="stat in stats" :key="stat.name" class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm ring-1 ring-black/5 dark:ring-white/5 rounded-2xl p-6 transition-all duration-200 hover:shadow-md">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 rounded-xl">
                            <component :is="stat.icon" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-zinc-400 truncate">{{ stat.name }}</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white mt-1">{{ stat.value }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Visitors Table -->
            <div class="bg-white dark:bg-zinc-900 shadow-sm ring-1 ring-black/5 dark:ring-white/5 rounded-2xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-zinc-800 flex items-center justify-between">
                    <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">Recent Visitors</h3>
                    <button class="text-sm font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">View all</button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-800">
                        <thead class="bg-gray-50 dark:bg-zinc-900/50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-xs font-semibold text-gray-900 dark:text-white sm:pl-6">Name</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 dark:text-white">Purpose</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 dark:text-white">Time</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 dark:text-white">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-zinc-800 bg-white dark:bg-zinc-900">
                            <tr v-for="visitor in recentVisitors" :key="visitor.id" class="hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm font-medium text-gray-900 dark:text-white sm:pl-6">{{ visitor.name }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-zinc-400">{{ visitor.purpose }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-zinc-400">{{ visitor.time }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-zinc-400">
                                    <span :class="[visitor.status === 'Checked In' ? 'bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-400 ring-green-600/20 dark:ring-green-500/20' : 'bg-gray-50 text-gray-600 dark:bg-zinc-800 dark:text-zinc-400 ring-gray-500/10 dark:ring-zinc-500/20', 'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset']">
                                        {{ visitor.status }}
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
