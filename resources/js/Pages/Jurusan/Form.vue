<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    title: String,
    jurusan: Object,
    mode: String,
});

const form = useForm({
    kode_jurusan: props.jurusan?.kode_jurusan || "",
    nama_jurusan: props.jurusan?.nama_jurusan || "",
});

const submit = () => {
    if (props.mode === "create") {
        form.post(route("jurusan.store"));
    } else {
        form.put(route("jurusan.update", props.jurusan.id));
    }
};
</script>

<template>
    <Head :title="title" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ title }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label
                                    for="kode_jurusan"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >
                                    Kode Jurusan
                                </label>
                                <input
                                    type="text"
                                    id="kode_jurusan"
                                    v-model="form.kode_jurusan"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"
                                    required
                                    maxlength="10"
                                />
                                <div
                                    v-if="form.errors.kode_jurusan"
                                    class="mt-1 text-sm text-red-600 dark:text-red-400"
                                >
                                    {{ form.errors.kode_jurusan }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <label
                                    for="nama_jurusan"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >
                                    Nama Jurusan
                                </label>
                                <input
                                    type="text"
                                    id="nama_jurusan"
                                    v-model="form.nama_jurusan"
                                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"
                                    required
                                    maxlength="100"
                                />
                                <div
                                    v-if="form.errors.nama_jurusan"
                                    class="mt-1 text-sm text-red-600 dark:text-red-400"
                                >
                                    {{ form.errors.nama_jurusan }}
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button
                                    type="submit"
                                    class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                    :disabled="form.processing"
                                >
                                    {{ mode === "create" ? "Simpan" : "Update" }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template> 