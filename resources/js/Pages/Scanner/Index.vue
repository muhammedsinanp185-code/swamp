<script setup lang="ts">
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { 
    QrCodeIcon, 
    ClipboardDocumentListIcon, 
    BellAlertIcon, 
    UserGroupIcon
} from '@heroicons/vue/24/outline';
import { QrCodeIcon as QrCodeIconSolid } from '@heroicons/vue/24/solid';

const activeTab = ref('scanner');

// Mock data for recent scans
const recentScans = [
    { id: 1, name: 'Alice Cooper', time: 'Just now', status: 'Approved', type: 'Visitor' },
    { id: 2, name: 'FedEx Delivery', time: '5m ago', status: 'Logged', type: 'Parcel' },
    { id: 3, name: 'Bob Marley', time: '12m ago', status: 'Rejected', type: 'Visitor' },
];
</script>

<template>
    <Head title="Guard Scanner" />

    <div class="min-h-screen bg-black text-white flex flex-col font-sans">
        
        <!-- Header -->
        <header class="pt-12 pb-4 px-6 bg-zinc-900 border-b border-zinc-800 flex items-center justify-between sticky top-0 z-10">
            <div>
                <h1 class="text-xl font-bold tracking-tight">Gate 1 Entry</h1>
                <p class="text-zinc-400 text-sm">Security Duty: Active</p>
            </div>
            <button class="bg-red-500/20 text-red-500 p-2.5 rounded-full hover:bg-red-500/30 transition-colors">
                <BellAlertIcon class="w-6 h-6" />
            </button>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto pb-24">
            
            <div v-if="activeTab === 'scanner'" class="h-full flex flex-col">
                <!-- Camera Viewfinder Mockup -->
                <div class="relative w-full aspect-[3/4] bg-zinc-800 overflow-hidden">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-64 h-64 border-2 border-indigo-500 rounded-3xl relative">
                            <!-- Scanning Animation Line -->
                            <div class="absolute top-0 left-0 w-full h-0.5 bg-indigo-500 shadow-[0_0_10px_#6366f1] animate-[scan_2s_ease-in-out_infinite]"></div>
                            
                            <!-- Corner Accents -->
                            <div class="absolute -top-1 -left-1 w-6 h-6 border-t-4 border-l-4 border-white rounded-tl-xl"></div>
                            <div class="absolute -top-1 -right-1 w-6 h-6 border-t-4 border-r-4 border-white rounded-tr-xl"></div>
                            <div class="absolute -bottom-1 -left-1 w-6 h-6 border-b-4 border-l-4 border-white rounded-bl-xl"></div>
                            <div class="absolute -bottom-1 -right-1 w-6 h-6 border-b-4 border-r-4 border-white rounded-br-xl"></div>
                        </div>
                    </div>
                    <div class="absolute bottom-6 left-0 right-0 flex justify-center gap-4">
                        <button class="bg-white/10 backdrop-blur-md px-6 py-2.5 rounded-full font-medium text-sm border border-white/20">
                            Switch Camera
                        </button>
                        <button class="bg-indigo-600 px-6 py-2.5 rounded-full font-medium text-sm shadow-[0_0_15px_rgba(79,70,229,0.5)]">
                            Manual Entry
                        </button>
                    </div>
                </div>

                <!-- Recent Scans below camera -->
                <div class="px-6 py-6 flex-1 bg-zinc-950">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-sm font-semibold text-zinc-400 uppercase tracking-wider">Recent Scans</h2>
                        <button class="text-indigo-400 text-sm">View All</button>
                    </div>
                    
                    <div class="space-y-3">
                        <div v-for="scan in recentScans" :key="scan.id" class="bg-zinc-900 p-4 rounded-2xl flex items-center justify-between border border-zinc-800">
                            <div class="flex items-center gap-4">
                                <div :class="[
                                    scan.status === 'Approved' ? 'bg-green-500/20 text-green-400' :
                                    scan.status === 'Rejected' ? 'bg-red-500/20 text-red-400' :
                                    'bg-blue-500/20 text-blue-400',
                                    'w-10 h-10 rounded-full flex items-center justify-center'
                                ]">
                                    <QrCodeIconSolid class="w-5 h-5" />
                                </div>
                                <div>
                                    <p class="font-medium text-white">{{ scan.name }}</p>
                                    <p class="text-xs text-zinc-400">{{ scan.type }} &bull; {{ scan.time }}</p>
                                </div>
                            </div>
                            <span :class="[
                                scan.status === 'Approved' ? 'text-green-400' :
                                scan.status === 'Rejected' ? 'text-red-400' :
                                'text-blue-400',
                                'text-sm font-medium'
                            ]">{{ scan.status }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Other tabs placeholder -->
            <div v-else class="p-6 flex items-center justify-center h-full text-zinc-500">
                Feature coming soon
            </div>
            
        </main>

        <!-- Bottom Navigation -->
        <nav class="fixed bottom-0 left-0 right-0 bg-zinc-900/90 backdrop-blur-xl border-t border-zinc-800 pb-safe">
            <div class="flex justify-around items-center h-20 px-4">
                <button @click="activeTab = 'scanner'" :class="[activeTab === 'scanner' ? 'text-indigo-400' : 'text-zinc-500', 'flex flex-col items-center gap-1.5 p-2 transition-colors']">
                    <QrCodeIcon class="w-7 h-7" />
                    <span class="text-[10px] font-medium tracking-wide">Scan</span>
                </button>
                <button @click="activeTab = 'logs'" :class="[activeTab === 'logs' ? 'text-indigo-400' : 'text-zinc-500', 'flex flex-col items-center gap-1.5 p-2 transition-colors']">
                    <ClipboardDocumentListIcon class="w-7 h-7" />
                    <span class="text-[10px] font-medium tracking-wide">Logs</span>
                </button>
                <button @click="activeTab = 'visitors'" :class="[activeTab === 'visitors' ? 'text-indigo-400' : 'text-zinc-500', 'flex flex-col items-center gap-1.5 p-2 transition-colors']">
                    <UserGroupIcon class="w-7 h-7" />
                    <span class="text-[10px] font-medium tracking-wide">Visitors</span>
                </button>
                <Link :href="route('dashboard')" class="text-zinc-500 flex flex-col items-center gap-1.5 p-2 hover:text-white transition-colors">
                    <div class="w-7 h-7 rounded-full bg-zinc-800 border border-zinc-700 flex items-center justify-center text-xs font-bold">
                        A
                    </div>
                    <span class="text-[10px] font-medium tracking-wide">Exit</span>
                </Link>
            </div>
        </nav>
    </div>
</template>

<style scoped>
@keyframes scan {
    0% { top: 0%; opacity: 0; }
    10% { opacity: 1; }
    90% { opacity: 1; }
    100% { top: 100%; opacity: 0; }
}

.pb-safe {
    padding-bottom: env(safe-area-inset-bottom);
}
</style>
