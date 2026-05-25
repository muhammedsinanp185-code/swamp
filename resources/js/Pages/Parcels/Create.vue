<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    courier_name: '',
    tracking_number: '',
    recipient_name: '',
    status: 'received',
    arrived_at: '',
    photo_url: '',
});

const submit = () => {
    form.post(route('parcels.store'));
};
</script>

<template>
    <Head title="Log New Parcel" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <Link :href="route('parcels.index')" class="text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-zinc-400 dark:hover:text-zinc-300">
                    &larr; Back
                </Link>
                <span>Log New Parcel</span>
            </div>
        </template>

        <div class="max-w-3xl mx-auto">
            <div class="bg-white dark:bg-zinc-900 shadow-sm ring-1 ring-black/5 dark:ring-white/5 rounded-2xl overflow-hidden">
                <form @submit.prevent="submit" class="p-6 sm:p-8 space-y-8">
                    <div>
                        <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Parcel Details</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-zinc-400">Enter the courier, tracking, and recipient information for this parcel.</p>

                        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="courier_name" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Courier</label>
                                <div class="mt-2">
                                    <input v-model="form.courier_name" type="text" id="courier_name" required class="block w-full rounded-xl border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-indigo-500" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="tracking_number" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Tracking number</label>
                                <div class="mt-2">
                                    <input v-model="form.tracking_number" type="text" id="tracking_number" required class="block w-full rounded-xl border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-indigo-500" />
                                </div>
                            </div>

                            <div class="sm:col-span-6">
                                <label for="recipient_name" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Recipient name</label>
                                <div class="mt-2">
                                    <input v-model="form.recipient_name" type="text" id="recipient_name" required class="block w-full rounded-xl border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-indigo-500" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="status" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Status</label>
                                <div class="mt-2">
                                    <select v-model="form.status" id="status" class="block w-full rounded-xl border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-indigo-500">
                                        <option value="received">Received</option>
                                        <option value="collected">Collected</option>
                                    </select>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="arrived_at" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Arrived at</label>
                                <div class="mt-2">
                                    <input v-model="form.arrived_at" type="datetime-local" id="arrived_at" required class="block w-full rounded-xl border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-indigo-500" />
                                </div>
                            </div>

                            <div class="sm:col-span-6">
                                <label for="photo_url" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Photo URL (optional)</label>
                                <div class="mt-2">
                                    <input v-model="form.photo_url" type="url" id="photo_url" class="block w-full rounded-xl border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-indigo-500" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-zinc-800 pt-6 flex items-center justify-end gap-x-6">
                        <Link :href="route('parcels.index')" class="text-sm font-semibold leading-6 text-gray-900 dark:text-white hover:text-gray-700 dark:hover:text-zinc-300">Cancel</Link>
                        <button type="submit" :disabled="form.processing" class="rounded-xl bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors disabled:opacity-50">
                            Save Parcel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
