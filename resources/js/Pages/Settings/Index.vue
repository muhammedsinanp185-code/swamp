<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Cog6ToothIcon, ShieldCheckIcon, BuildingOfficeIcon, CreditCardIcon } from '@heroicons/vue/24/outline';
import { ref, computed } from 'vue';

const props = defineProps<{
    preferences: {
        language: string;
        time_format: string;
        notifications_sms: boolean;
        notifications_email: boolean;
    };
}>();

const tabs = [
    { name: 'Organization', icon: BuildingOfficeIcon },
    { name: 'Roles & Security', icon: ShieldCheckIcon },
    { name: 'Billing', icon: CreditCardIcon },
    { name: 'General Preferences', icon: Cog6ToothIcon },
];

const currentTab = ref('General Preferences');

const form = useForm({
    language: props.preferences.language ?? 'en',
    time_format: props.preferences.time_format ?? '24h',
    notifications_sms: props.preferences.notifications_sms ?? false,
    notifications_email: props.preferences.notifications_email ?? true,
});

const activeTab = computed(() => currentTab.value);

const submit = () => {
    form.patch(route('settings.update'));
};
</script>

<template>
    <Head title="Settings" />

    <AuthenticatedLayout>
        <template #header>
            Settings
        </template>

        <div class="flex flex-col lg:flex-row gap-8">
            <aside class="w-full lg:w-64 flex-shrink-0">
                <nav class="space-y-1">
                    <button
                        v-for="tab in tabs"
                        :key="tab.name"
                        @click="currentTab = tab.name"
                        :class="[tab.name === currentTab ? 'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-400' : 'text-gray-700 hover:bg-gray-100 dark:text-zinc-400 dark:hover:bg-zinc-800/50 dark:hover:text-white', 'group flex items-center w-full px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200']"
                    >
                        <component
                            :is="tab.icon"
                            :class="[tab.name === currentTab ? 'text-indigo-700 dark:text-indigo-400' : 'text-gray-400 group-hover:text-gray-600 dark:text-zinc-500 dark:group-hover:text-zinc-300', 'flex-shrink-0 -ml-1 mr-3 h-5 w-5']"
                            aria-hidden="true"
                        />
                        {{ tab.name }}
                    </button>
                </nav>
            </aside>

            <div class="flex-1 max-w-3xl">
                <div class="bg-white dark:bg-zinc-900 shadow-sm ring-1 ring-black/5 dark:ring-white/5 rounded-2xl p-6 sm:p-8">
                    <template v-if="currentTab === 'Organization'">
                        <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Organization Profile</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-zinc-400">Update your company details and branding settings used across the platform.</p>

                        <form @submit.prevent="submit" class="mt-8 space-y-6">
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
                        </form>
                    </template>

                    <template v-else-if="currentTab === 'Roles & Security'">
                        <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Roles & Security</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-zinc-400">Manage permissions and access controls for your organization.</p>
                        <div class="mt-8 text-sm text-gray-500 dark:text-zinc-400">This section is under construction.</div>
                    </template>

                    <template v-else-if="currentTab === 'Billing'">
                        <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">Billing</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-zinc-400">Manage your billing details and subscription preferences.</p>
                        <div class="mt-8 text-sm text-gray-500 dark:text-zinc-400">This section is under construction.</div>
                    </template>

                    <template v-else>
                        <h2 class="text-base font-semibold leading-7 text-gray-900 dark:text-white">General Preferences</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-500 dark:text-zinc-400">Set your preferred language, time format, and notification channels.</p>

                        <form @submit.prevent="submit" class="mt-8 space-y-6">
                            <div>
                                <label for="language" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Language</label>
                                <div class="mt-2">
                                    <select
                                        id="language"
                                        v-model="form.language"
                                        class="block w-full rounded-xl border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-indigo-500"
                                    >
                                        <option value="en">English</option>
                                        <option value="es">Spanish</option>
                                        <option value="fr">French</option>
                                        <option value="de">German</option>
                                        <option value="ar">Arabic</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label for="time_format" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Time Format</label>
                                <div class="mt-2">
                                    <select
                                        id="time_format"
                                        v-model="form.time_format"
                                        class="block w-full rounded-xl border-0 py-2.5 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-zinc-800 dark:text-white dark:ring-zinc-700 dark:focus:ring-indigo-500"
                                    >
                                        <option value="12h">12-hour</option>
                                        <option value="24h">24-hour</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid gap-6 sm:grid-cols-2">
                                <div class="rounded-2xl border border-gray-200 dark:border-zinc-800 p-4">
                                    <div class="flex items-start gap-3">
                                        <input
                                            id="notifications_sms"
                                            type="checkbox"
                                            v-model="form.notifications_sms"
                                            class="mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:bg-zinc-800 dark:border-zinc-700"
                                        />
                                        <div>
                                            <label for="notifications_sms" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">SMS Notifications</label>
                                            <p class="mt-1 text-sm text-gray-500 dark:text-zinc-400">Receive alerts and updates via SMS.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="rounded-2xl border border-gray-200 dark:border-zinc-800 p-4">
                                    <div class="flex items-start gap-3">
                                        <input
                                            id="notifications_email"
                                            type="checkbox"
                                            v-model="form.notifications_email"
                                            class="mt-1 h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:bg-zinc-800 dark:border-zinc-700"
                                        />
                                        <div>
                                            <label for="notifications_email" class="block text-sm font-medium leading-6 text-gray-900 dark:text-white">Email Notifications</label>
                                            <p class="mt-1 text-sm text-gray-500 dark:text-zinc-400">Receive notifications and summaries by email.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 dark:border-zinc-800 pt-6 flex justify-end">
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="rounded-xl bg-indigo-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors disabled:opacity-50"
                                >
                                    Save Preferences
                                </button>
                            </div>
                        </form>
                    </template>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
