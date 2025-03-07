<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Link } from "@inertiajs/vue3";

defineProps({
    auth: Object,
});
</script>

<template>
    <Head title="Dashboard Siswa" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard Siswa
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-semibold mb-4">Selamat Datang, {{ $page.props.auth.user.name }}!</h3>
                        
                        <!-- Student Information -->
                        <div class="mb-6">
                            <h4 class="text-md font-medium mb-2">Informasi Siswa</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Nama:</p>
                                    <p>{{ $page.props.auth.user.name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Email:</p>
                                    <p>{{ $page.props.auth.user.email }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- PKL Information -->
                        <div class="mb-6">
                            <h4 class="text-md font-medium mb-2">Informasi PKL</h4>
                            <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                <p class="text-sm mb-2">Status PKL: <span class="font-medium">Belum Memulai</span></p>
                                <p class="text-sm mb-2">Periode PKL: <span class="font-medium">-</span></p>
                                <p class="text-sm">Tempat PKL: <span class="font-medium">-</span></p>
                            </div>
                        </div>

                        <!-- Quick Links -->
                        <div>
                            <h4 class="text-md font-medium mb-2">Menu Cepat</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <Link href="/pkl" class="bg-blue-500 hover:bg-blue-600 text-white p-4 rounded-lg text-center">
                                    <h5 class="font-medium mb-2">Halaman PKL</h5>
                                    <p class="text-sm">Kelola informasi dan laporan PKL Anda</p>
                                </Link>
                                <!-- Add more quick access buttons/cards here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template> 