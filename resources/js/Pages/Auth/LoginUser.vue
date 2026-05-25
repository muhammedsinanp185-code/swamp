<script setup lang="ts">
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ShieldCheckIcon } from '@heroicons/vue/24/outline';

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
    <div class="min-h-screen bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center px-4">
        <Head title="User Login" />
        
        <div class="max-w-md w-full bg-white rounded-xl shadow-2xl p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="flex items-center justify-center gap-2 mb-4">
                    <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center">
                        <ShieldCheckIcon class="w-6 h-6 text-white" />
                    </div>
                    <span class="text-2xl font-bold text-gray-900">SWAMP</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">User Login</h1>
                <p class="text-gray-600 text-sm mt-2">Sign in to your account</p>
            </div>

            <!-- Status Message -->
            <div v-if="status" class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm font-medium text-green-700">
                {{ status }}
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="space-y-6">
                <!-- Email -->
                <div>
                    <InputLabel for="email" value="Email Address" />
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-2 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                        placeholder="your@email.com"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <!-- Password -->
                <div>
                    <InputLabel for="password" value="Password" />
                    <TextInput
                        id="password"
                        type="password"
                        class="mt-2 block w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                        placeholder="••••••••"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600">Remember me</span>
                </div>

                <!-- Submit Button -->
                <PrimaryButton
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg transition-colors"
                    :class="{ 'opacity-50': form.processing }"
                    :disabled="form.processing"
                >
                    {{ form.processing ? 'Signing in...' : 'Sign In' }}
                </PrimaryButton>
            </form>

            <!-- Links -->
            <div class="mt-6 space-y-3 text-center text-sm">
                <div v-if="canResetPassword">
                    <Link
                        :href="route('password.request')"
                        class="text-indigo-600 hover:text-indigo-700 font-medium"
                    >
                        Forgot your password?
                    </Link>
                </div>
                <div class="border-t border-gray-200 pt-4">
                    <p class="text-gray-600">
                        Are you an admin?
                        <Link href="/login/admin" class="text-indigo-600 hover:text-indigo-700 font-semibold">
                            Admin Login
                        </Link>
                    </p>
                </div>
                <div>
                    <Link href="/" class="text-gray-600 hover:text-gray-900">
                        ← Back to Home
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
