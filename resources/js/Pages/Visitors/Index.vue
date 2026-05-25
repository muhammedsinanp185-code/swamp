<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { PlusIcon, MagnifyingGlassIcon } from '@heroicons/vue/24/outline';
import { ref, computed } from 'vue';

const props = defineProps<{
    visitors: any[];
}>();

const searchQuery = ref('');
const statusFilter = ref('all');

const filteredVisitors = computed(() => {
    const query = searchQuery.value.trim().toLowerCase();
    return props.visitors.filter(visitor => {
        const matchesSearch = !query ||
            visitor.name.toLowerCase().includes(query) ||
            visitor.phone.toLowerCase().includes(query) ||
            visitor.email?.toLowerCase().includes(query) ||
            visitor.host_name?.toLowerCase().includes(query);

        const matchesStatus = statusFilter.value === 'all'
            || visitor.status?.toLowerCase() === statusFilter.value;

        return matchesSearch && matchesStatus;
    });
});
</script>

<template>
    <Head title="Visitors" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <span>Visitor Management</span>
            </div>
        </template>

        <div class="bg-white dark:bg-zinc-900 shadow-sm ring-1 ring-black/5 dark:ring-white/5 rounded-2xl overflow-hidden">
            <div class="p-4 border-b border-gray-200 dark:border-zinc-800 flex flex-col sm:flex-row gap-4 justify-between items-center bg-gray-50 dark:bg-zinc-900/50">
                <div class="relative w-full sm:w-96">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <MagnifyingGlassIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                    </div>
                    <input v-model="searchQuery" type="text" class="block w-full rounded-xl border-0 py-2.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-indigo-500" placeholder="Search visitors by name, phone, or QR..." />
                </div>
                <div class="flex gap-2">
                    <select v-model="statusFilter" class="rounded-xl border-0 py-2.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700">
                        <option value="all">All Status</option>
                        <option value="active">Active</option>
                        <option value="pending">Pending</option>
                        <option value="expired">Expired</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-800">
                    <thead class="bg-white dark:bg-zinc-900">
                        <tr>
                            <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Visitor Details</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Host</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Valid Until</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-white">Status</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-6 sm:pr-6">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-zinc-800 bg-white dark:bg-zinc-900">
                        <tr v-if="filteredVisitors.length === 0">
                            <td colspan="5" class="py-12 text-center text-gray-500 dark:text-zinc-400">
                                {{ searchQuery ? 'No visitors found matching your search.' : 'No visitors found. Create a new pass to get started.' }}
                            </td>
                        </tr>
                        <tr v-for="visitor in filteredVisitors" :key="visitor.id" class="hover:bg-gray-50 dark:hover:bg-zinc-800/50">
                            <td class="whitespace-nowrap py-4 pl-6 pr-3">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full object-cover" :src="visitor.photo_url || `https://ui-avatars.com/api/?name=${visitor.name}&background=random`" alt="" />
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900 dark:text-white">{{ visitor.name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-zinc-400">{{ visitor.phone }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-zinc-400">
                                {{ visitor.host_name }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-zinc-400">
                                {{ visitor.valid_until }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm">
                                <span :class="[
                                    visitor.status === 'active' ? 'bg-green-50 text-green-700 ring-green-600/20 dark:bg-green-500/10 dark:text-green-400 dark:ring-green-500/20' : 
                                    visitor.status === 'pending' ? 'bg-yellow-50 text-yellow-800 ring-yellow-600/20 dark:bg-yellow-500/10 dark:text-yellow-400 dark:ring-yellow-500/20' : 
                                    'bg-red-50 text-red-700 ring-red-600/20 dark:bg-red-500/10 dark:text-red-400 dark:ring-red-500/20',
                                    'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset'
                                ]">
                                    {{ visitor.status.charAt(0).toUpperCase() + visitor.status.slice(1) }}
                                </span>
                            </td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-6 text-right text-sm font-medium">
                                <Link :href="route('visitors.show', visitor.id)" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">View<span class="sr-only">, {{ visitor.name }}</span></Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="p-6 flex justify-center border-t border-gray-200 dark:border-zinc-800">
                <Link :href="route('visitors.create')" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors">
                    <PlusIcon class="h-5 w-5" />
                    New Visitor Pass
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
