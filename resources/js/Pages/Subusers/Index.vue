<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { PlusIcon, PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline';

defineProps<{
    subusers: any[]
}>();
</script>

<template>
    <Head title="Subusers" />

    <AuthenticatedLayout>
        <template #header>
            Subusers Management
        </template>

        <div class="space-y-6">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">Manage Subusers</h2>
                <Link
                    href="/subusers/create"
                    class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition-colors"
                >
                    <PlusIcon class="w-5 h-5" />
                    Add Subuser
                </Link>
            </div>

            <!-- Subusers Table -->
            <div class="bg-white dark:bg-zinc-900 shadow-sm ring-1 ring-black/5 dark:ring-white/5 rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-zinc-800">
                        <thead class="bg-gray-50 dark:bg-zinc-900/50">
                            <tr>
                                <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-xs font-semibold text-gray-900 dark:text-white">Name</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 dark:text-white">Email</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 dark:text-white">Phone</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 dark:text-white">Role</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 dark:text-white">Status</th>
                                <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-900 dark:text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-zinc-800 bg-white dark:bg-zinc-900">
                            <tr v-if="subusers.length === 0" class="hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td colspan="6" class="py-8 text-center text-sm text-gray-500 dark:text-zinc-400">No subusers found. Create one to get started.</td>
                            </tr>
                            <tr v-for="subuser in subusers" :key="subuser.id" class="hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm font-medium text-gray-900 dark:text-white">{{ subuser.name }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-zinc-400">{{ subuser.email }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-zinc-400">{{ subuser.phone || '-' }}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm">
                                    <span :class="[
                                        subuser.role === 'manager' ? 'bg-blue-50 text-blue-700 dark:bg-blue-500/10 dark:text-blue-400' :
                                        subuser.role === 'viewer' ? 'bg-gray-50 text-gray-700 dark:bg-gray-500/10 dark:text-gray-400' :
                                        'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400',
                                        'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset',
                                        subuser.role === 'manager' ? 'ring-blue-600/20 dark:ring-blue-500/20' :
                                        subuser.role === 'viewer' ? 'ring-gray-500/10 dark:ring-gray-500/20' :
                                        'ring-indigo-600/20 dark:ring-indigo-500/20'
                                    ]">
                                        {{ subuser.role }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm">
                                    <span :class="[
                                        subuser.is_active ? 'bg-green-50 text-green-700 dark:bg-green-500/10 dark:text-green-400 ring-green-600/20 dark:ring-green-500/20' :
                                        'bg-red-50 text-red-700 dark:bg-red-500/10 dark:text-red-400 ring-red-600/20 dark:ring-red-500/20',
                                        'inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset'
                                    ]">
                                        {{ subuser.is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm font-medium">
                                    <div class="flex gap-2">
                                        <Link
                                            :href="`/subusers/${subuser.id}/edit`"
                                            class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300"
                                        >
                                            <PencilSquareIcon class="w-5 h-5" />
                                        </Link>
                                        <Link
                                            :href="`/subusers/${subuser.id}`"
                                            method="delete"
                                            as="button"
                                            class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                        >
                                            <TrashIcon class="w-5 h-5" />
                                        </Link>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
