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
            <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
                Dashboard Siswa
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-slate-900 dark:text-slate-100">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <!-- PKL Status Card -->
                            <div class="bg-slate-100 dark:bg-slate-700 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold mb-4">Status PKL</h3>
                                <div class="space-y-2">
                                    <p>Status: <span class="font-medium">Belum Mengajukan</span></p>
                                    <p>Tanggal Pengajuan: -</p>
                                    <p>Tanggal Mulai: -</p>
                                    <p>Tanggal Selesai: -</p>
                                </div>
                            </div>

                            <!-- Quick Actions Card -->
                            <div class="bg-slate-100 dark:bg-slate-700 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold mb-4">Aksi Cepat</h3>
                                <div class="space-y-2">
                                    <Link
                                        href="#"
                                        class="block w-full text-center px-4 py-2 bg-primary text-white rounded hover:bg-primary-dark transition-colors"
                                    >
                                        Ajukan PKL
                                    </Link>
                                    <Link
                                        href="#"
                                        class="block w-full text-center px-4 py-2 bg-slate-200 dark:bg-slate-600 text-slate-800 dark:text-slate-200 rounded hover:bg-slate-300 dark:hover:bg-slate-500 transition-colors"
                                    >
                                        Lihat Riwayat PKL
                                    </Link>
                                </div>
                            </div>

                            <!-- Notifications Card -->
                            <div class="bg-slate-100 dark:bg-slate-700 p-6 rounded-lg">
                                <h3 class="text-lg font-semibold mb-4">Notifikasi</h3>
                                <div class="space-y-2">
                                    <p class="text-sm text-slate-600 dark:text-slate-400">
                                        Belum ada notifikasi baru
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template> 