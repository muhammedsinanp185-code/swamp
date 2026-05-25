<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { ShieldCheckIcon, UsersIcon, TruckIcon, QrCodeIcon, ChartBarIcon, LockClosedIcon } from '@heroicons/vue/24/outline';

defineProps<{
    canLogin?: boolean;
}>();

const features = [
  {
    name: 'Visitor Management',
    description: 'Track and manage visitor check-ins with QR codes and automated entry logging.',
    icon: UsersIcon,
  },
  {
    name: 'Parcel Tracking',
    description: 'Keep track of packages and deliveries with detailed tracking information.',
    icon: TruckIcon,
  },
  {
    name: 'QR Code Scanner',
    description: 'Fast and secure scanning for visitor pass verification and entry logging.',
    icon: QrCodeIcon,
  },
  {
    name: 'Dashboard Analytics',
    description: 'Real-time statistics and insights about visitor traffic and activity.',
    icon: ChartBarIcon,
  },
  {
    name: 'Subuser Management',
    description: 'Create and manage subusers with different roles and permissions.',
    icon: ShieldCheckIcon,
  },
  {
    name: 'Secure Access',
    description: 'Role-based access control with admin and user authentication levels.',
    icon: LockClosedIcon,
  },
];
</script>

<template>
    <Head title="SWAMP - Secure Workplace Access Management Platform" />
    <div class="min-h-screen bg-gradient-to-br from-indigo-600 via-indigo-500 to-purple-600 text-white">
        <!-- Navigation -->
        <nav class="flex justify-between items-center px-6 sm:px-8 lg:px-12 py-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                    <ShieldCheckIcon class="w-6 h-6 text-indigo-600" />
                </div>
                <span class="text-2xl font-bold">SWAMP</span>
            </div>
            <div v-if="canLogin" class="flex gap-4">
                <Link
                    href="/login/user"
                    class="px-6 py-2 rounded-lg bg-white/20 hover:bg-white/30 transition-colors border border-white/30"
                >
                    User Login
                </Link>
                <Link
                    href="/login/admin"
                    class="px-6 py-2 rounded-lg bg-white hover:bg-gray-100 text-indigo-600 font-semibold transition-colors"
                >
                    Admin Login
                </Link>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="px-6 sm:px-8 lg:px-12 py-20 text-center">
            <h1 class="text-5xl sm:text-6xl font-bold mb-6">
                Secure Workplace Access Management
            </h1>
            <p class="text-xl opacity-90 max-w-2xl mx-auto mb-10">
                Complete visitor management, parcel tracking, and access control system designed for modern organizations.
            </p>
            <div class="flex gap-4 justify-center">
                <Link
                    href="/login/user"
                    class="px-8 py-3 rounded-lg bg-white text-indigo-600 font-semibold hover:bg-gray-100 transition-colors"
                >
                    Get Started
                </Link>
                <a
                    href="#features"
                    class="px-8 py-3 rounded-lg bg-white/20 hover:bg-white/30 transition-colors border border-white/30"
                >
                    Learn More
                </a>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" class="px-6 sm:px-8 lg:px-12 py-20 bg-black/10">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-4xl font-bold text-center mb-16">Features</h2>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div v-for="feature in features" :key="feature.name" class="bg-white/10 backdrop-blur rounded-xl p-6 border border-white/20 hover:border-white/40 transition-colors">
                        <component :is="feature.icon" class="w-12 h-12 mb-4" />
                        <h3 class="text-xl font-semibold mb-2">{{ feature.name }}</h3>
                        <p class="opacity-80">{{ feature.description }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="px-6 sm:px-8 lg:px-12 py-20 text-center">
            <h2 class="text-4xl font-bold mb-6">Ready to get started?</h2>
            <p class="text-xl opacity-90 mb-10">Sign in to your account to access the platform.</p>
            <div class="flex gap-4 justify-center">
                <Link
                    href="/login/user"
                    class="px-8 py-3 rounded-lg bg-white text-indigo-600 font-semibold hover:bg-gray-100 transition-colors"
                >
                    User Login
                </Link>
                <Link
                    href="/login/admin"
                    class="px-8 py-3 rounded-lg bg-indigo-400 hover:bg-indigo-300 transition-colors"
                >
                    Admin Login
                </Link>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-white/20 px-6 sm:px-8 lg:px-12 py-8 text-center opacity-75">
            <p>&copy; 2026 SWAMP. Secure Workplace Access Management Platform.</p>
        </footer>
    </div>
</template>
