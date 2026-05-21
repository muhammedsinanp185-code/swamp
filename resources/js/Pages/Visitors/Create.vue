<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    phone: '',
    email: '',
    purpose: '',
    valid_from: '',
    valid_until: '',
    type: 'single',
});

const submit = () => {
    form.post(route('visitors.store'));
};
</script>

<template>
    <Head title="New Visitor Pass" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center gap-4">
                <Link :href="route('visitors.index')" class="text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-zinc-400 dark:hover:text-zinc-300">
                    &larr; Back
                </Link>
                <span>Create Visitor Pass</span>
            </div>
        </template>

        <div class="max-w-3xl mx-auto">
            <div class="bg-white dark:bg-zinc-900 shadow-sm ring-1 ring-black/5 dark:ring-white/5 rounded-2xl overflow-hidden">
                <form @submit.prevent="submit" class="p-6 sm:p-8 space-y-8">
                    
                    <div>
                        <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Visitor Information</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-zinc-400">Basic details about the person visiting the premises.</p>

                        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="name" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Full name</label>
                                <div class="mt-2">
                                    <input v-model="form.name" type="text" id="name" required class="block w-full rounded-xl border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-indigo-500" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="phone" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Phone number</label>
                                <div class="mt-2">
                                    <input v-model="form.phone" type="tel" id="phone" required class="block w-full rounded-xl border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-indigo-500" />
                                </div>
                            </div>

                            <div class="sm:col-span-6">
                                <label for="email" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Email address</label>
                                <div class="mt-2">
                                    <input v-model="form.email" type="email" id="email" class="block w-full rounded-xl border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-indigo-500" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-zinc-800 pt-8">
                        <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Visit Details</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-zinc-400">Specify the purpose and validity of the pass.</p>

                        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                            <div class="sm:col-span-6">
                                <label for="purpose" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Purpose of visit</label>
                                <div class="mt-2">
                                    <input v-model="form.purpose" type="text" id="purpose" required class="block w-full rounded-xl border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-indigo-500" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="valid_from" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Valid From</label>
                                <div class="mt-2">
                                    <input v-model="form.valid_from" type="datetime-local" id="valid_from" required class="block w-full rounded-xl border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-indigo-500" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="valid_until" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Valid Until</label>
                                <div class="mt-2">
                                    <input v-model="form.valid_until" type="datetime-local" id="valid_until" required class="block w-full rounded-xl border-0 py-2.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-indigo-500" />
                                </div>
                            </div>

                            <div class="sm:col-span-6">
                                <fieldset>
                                    <legend class="text-sm font-medium leading-6 text-gray-900 dark:text-white">Pass Type</legend>
                                    <div class="mt-4 space-y-4">
                                        <div class="flex items-center">
                                            <input v-model="form.type" id="type-single" name="type" type="radio" value="single" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-zinc-700 dark:bg-zinc-800 dark:ring-offset-zinc-900" />
                                            <label for="type-single" class="ml-3 block text-sm font-medium leading-6 text-gray-900 dark:text-white">Single Entry <span class="text-gray-500 dark:text-zinc-400">(Valid for one check-in only)</span></label>
                                        </div>
                                        <div class="flex items-center">
                                            <input v-model="form.type" id="type-reusable" name="type" type="radio" value="reusable" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-zinc-700 dark:bg-zinc-800 dark:ring-offset-zinc-900" />
                                            <label for="type-reusable" class="ml-3 block text-sm font-medium leading-6 text-gray-900 dark:text-white">Reusable <span class="text-gray-500 dark:text-zinc-400">(Valid for multiple check-ins within the timeframe)</span></label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 dark:border-zinc-800 pt-6 flex items-center justify-end gap-x-6">
                        <Link :href="route('visitors.index')" class="text-sm font-semibold leading-6 text-gray-900 dark:text-white hover:text-gray-700 dark:hover:text-zinc-300">Cancel</Link>
                        <button type="submit" :disabled="form.processing" class="rounded-xl bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors disabled:opacity-50">
                            Generate QR Pass
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
