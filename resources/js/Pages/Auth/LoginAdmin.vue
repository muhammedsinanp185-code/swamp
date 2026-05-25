<script setup lang="ts">
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ShieldCheckIcon, LockClosedIcon } from '@heroicons/vue/24/outline';

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>

<template>
    <div class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 flex items-center justify-center px-4">
        <Head title="Admin Login" />
        
        <div class="max-w-md w-full bg-slate-800 rounded-xl shadow-2xl p-8 border border-slate-700">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="flex items-center justify-center gap-2 mb-4">
                    <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center">
                        <LockClosedIcon class="w-6 h-6 text-white" />
                    </div>
                    <span class="text-2xl font-bold text-white">SWAMP</span>
                </div>
                <h1 class="text-2xl font-bold text-white">Admin Portal</h1>
                <p class="text-slate-400 text-sm mt-2">Restricted access - Admin credentials required</p>
            </div>

            <!-- Status Message -->
            <div v-if="status" class="mb-4 p-3 bg-green-50/10 border border-green-500/30 rounded-lg text-sm font-medium text-green-400">
                {{ status }}
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="space-y-6">
                <!-- Email -->
                <div>
                    <InputLabel for="email" value="Admin Email" class="text-slate-300" />
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-2 block w-full rounded-lg border border-slate-600 bg-slate-700 px-3 py-2 text-white placeholder-slate-500 focus:border-red-500 focus:ring-red-500"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="admin@example.com"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <!-- Password -->
                <div>
                    <InputLabel for="password" value="Password" class="text-slate-300" />
                    <TextInput
                        id="password"
                        type="password"
                        class="mt-2 block w-full rounded-lg border border-slate-600 bg-slate-700 px-3 py-2 text-white placeholder-slate-500 focus:border-red-500 focus:ring-red-500"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" class="border-slate-600 text-red-600 focus:ring-red-500" />
                    <span class="ms-2 text-sm text-slate-400">Remember me</span>
                </div>

                <!-- Submit Button -->
                <PrimaryButton
                    class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded-lg transition-colors font-semibold"
                    :class="{ 'opacity-50': form.processing }"
                    :disabled="form.processing"
                >
                    {{ form.processing ? 'Authenticating...' : 'Admin Login' }}
                </PrimaryButton>
            </form>

            <!-- Links -->
            <div class="mt-6 space-y-3 text-center text-sm">
                <div v-if="canResetPassword">
                    <Link
                        :href="route('password.request')"
                        class="text-red-400 hover:text-red-300 font-medium"
                    >
                        Forgot your password?
                    </Link>
                </div>
                <div class="border-t border-slate-700 pt-4">
                    <p class="text-slate-400">
                        Regular user?
                        <Link href="/login/user" class="text-red-400 hover:text-red-300 font-semibold">
                            User Login
                        </Link>
                    </p>
                </div>
                <div>
                    <Link href="/" class="text-slate-400 hover:text-slate-300">
                        ← Back to Home
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
