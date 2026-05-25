<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    phone: '',
    role: 'subuser',
    is_active: true,
});

const submit = () => {
    form.post('/subusers', {
        onFinish: () => {
            form.reset();
        },
    });
};

const roles = [
    { value: 'subuser', label: 'Subuser' },
    { value: 'manager', label: 'Manager' },
    { value: 'viewer', label: 'Viewer' },
];
</script>

<template>
    <Head title="Create Subuser" />

    <AuthenticatedLayout>
        <template #header>
            Create New Subuser
        </template>

        <div class="max-w-2xl mx-auto">
            <div class="bg-white dark:bg-zinc-900 shadow-sm ring-1 ring-black/5 dark:ring-white/5 rounded-2xl p-6">
                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            required
                            class="mt-2 block w-full rounded-lg border border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-zinc-500 focus:border-indigo-500 focus:ring-indigo-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400"
                            placeholder="John Doe"
                        />
                        <p v-if="form.errors.name" class="mt-1 text-sm text-red-600 dark:text-red-400">{{ form.errors.name }}</p>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            required
                            class="mt-2 block w-full rounded-lg border border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-zinc-500 focus:border-indigo-500 focus:ring-indigo-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400"
                            placeholder="john@example.com"
                        />
                        <p v-if="form.errors.email" class="mt-1 text-sm text-red-600 dark:text-red-400">{{ form.errors.email }}</p>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            required
                            class="mt-2 block w-full rounded-lg border border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-zinc-500 focus:border-indigo-500 focus:ring-indigo-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400"
                            placeholder="••••••••"
                        />
                        <p v-if="form.errors.password" class="mt-1 text-sm text-red-600 dark:text-red-400">{{ form.errors.password }}</p>
                        <p class="mt-1 text-xs text-gray-500 dark:text-zinc-400">Minimum 8 characters</p>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-900 dark:text-white">Phone (Optional)</label>
                        <input
                            id="phone"
                            v-model="form.phone"
                            type="tel"
                            class="mt-2 block w-full rounded-lg border border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-zinc-500 focus:border-indigo-500 focus:ring-indigo-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400"
                            placeholder="+1 (555) 000-0000"
                        />
                        <p v-if="form.errors.phone" class="mt-1 text-sm text-red-600 dark:text-red-400">{{ form.errors.phone }}</p>
                    </div>

                    <!-- Role -->
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-900 dark:text-white">Role</label>
                        <select
                            id="role"
                            v-model="form.role"
                            class="mt-2 block w-full rounded-lg border border-gray-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-gray-900 dark:text-white focus:border-indigo-500 focus:ring-indigo-500 dark:focus:border-indigo-400 dark:focus:ring-indigo-400"
                        >
                            <option v-for="r in roles" :key="r.value" :value="r.value">
                                {{ r.label }}
                            </option>
                        </select>
                        <p v-if="form.errors.role" class="mt-1 text-sm text-red-600 dark:text-red-400">{{ form.errors.role }}</p>
                    </div>

                    <!-- Active Status -->
                    <div class="flex items-center">
                        <input
                            id="is_active"
                            v-model="form.is_active"
                            type="checkbox"
                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:border-zinc-700 dark:bg-zinc-800 dark:focus:ring-indigo-400"
                        />
                        <label for="is_active" class="ml-2 block text-sm text-gray-900 dark:text-white">
                            Active
                        </label>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-4">
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 disabled:bg-indigo-400 text-white px-6 py-2 rounded-lg transition-colors"
                        >
                            {{ form.processing ? 'Creating...' : 'Create Subuser' }}
                        </button>
                        <Link
                            href="/subusers"
                            class="inline-flex items-center gap-2 bg-gray-200 hover:bg-gray-300 dark:bg-zinc-700 dark:hover:bg-zinc-600 text-gray-900 dark:text-white px-6 py-2 rounded-lg transition-colors"
                        >
                            Cancel
                        </Link>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
