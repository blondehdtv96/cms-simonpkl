<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { UserIcon, KeyIcon, ShieldCheckIcon, BookOpenIcon } from "@heroicons/vue/24/solid";

defineProps({
    users: Number,
    roles: Number,
    permissions: Number,
    jurusan: Number,
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Users Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-indigo-100 dark:bg-indigo-900">
                                    <UserIcon class="h-8 w-8 text-indigo-600 dark:text-indigo-300" />
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                        Total Users
                                    </p>
                                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                                        {{ users }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Roles Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                                    <KeyIcon class="h-8 w-8 text-green-600 dark:text-green-300" />
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                        Total Roles
                                    </p>
                                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                                        {{ roles }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Permissions Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-red-100 dark:bg-red-900">
                                    <ShieldCheckIcon class="h-8 w-8 text-red-600 dark:text-red-300" />
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                        Total Permissions
                                    </p>
                                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                                        {{ permissions }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jurusan Card -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                                    <BookOpenIcon class="h-8 w-8 text-blue-600 dark:text-blue-300" />
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                        Total Jurusan
                                    </p>
                                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                                        {{ jurusan }}
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
