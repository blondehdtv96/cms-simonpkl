<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref } from "vue";
import { router } from "@inertiajs/vue3";
import { PencilIcon, TrashIcon } from "@heroicons/vue/24/solid";

const props = defineProps({
    jurusan: Object,
    filters: Object,
    perPage: Number,
});

const search = ref(props.filters.search);
const field = ref(props.filters.field);
const order = ref(props.filters.order);

const handleSearch = () => {
    router.get(
        route("jurusan.index"),
        { search: search.value, field: field.value, order: order.value },
        {
            preserveState: true,
            preserveScroll: true,
        }
    );
};

const handleSort = (newField) => {
    if (field.value === newField) {
        order.value = order.value === "asc" ? "desc" : "asc";
    } else {
        field.value = newField;
        order.value = "asc";
    }
    handleSearch();
};

const handleDelete = (id) => {
    if (confirm("Apakah Anda yakin ingin menghapus data ini?")) {
        router.delete(route("jurusan.destroy", id));
    }
};

const handleBulkDelete = () => {
    const selectedIds = props.jurusan.data
        .filter((item) => item.selected)
        .map((item) => item.id);

    if (selectedIds.length === 0) {
        alert("Pilih data yang akan dihapus");
        return;
    }

    if (confirm("Apakah Anda yakin ingin menghapus data yang dipilih?")) {
        router.post(route("jurusan.destroy-bulk"), {
            ids: selectedIds,
        });
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
                        <!-- Search and Filter -->
                        <div class="mb-4 flex gap-4">
                            <div class="flex-1">
                                <input
                                    type="text"
                                    v-model="search"
                                    placeholder="Cari jurusan..."
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm"
                                    @keyup.enter="handleSearch"
                                />
                            </div>
                            <button
                                @click="handleSearch"
                                class="px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                            >
                                Cari
                            </button>
                            <Link
                                :href="route('jurusan.create')"
                                class="px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Tambah Jurusan
                            </Link>
                        </div>

                        <!-- Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left">
                                            <input
                                                type="checkbox"
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                @change="
                                                    jurusan.data.forEach(
                                                        (item) => (item.selected = $event.target.checked)
                                                    )
                                                "
                                            />
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                                            @click="handleSort('kode_jurusan')"
                                        >
                                            Kode Jurusan
                                            <span v-if="field === 'kode_jurusan'">
                                                {{ order === "asc" ? "↑" : "↓" }}
                                            </span>
                                        </th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                                            @click="handleSort('nama_jurusan')"
                                        >
                                            Nama Jurusan
                                            <span v-if="field === 'nama_jurusan'">
                                                {{ order === "asc" ? "↑" : "↓" }}
                                            </span>
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr v-for="item in jurusan.data" :key="item.id">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input
                                                type="checkbox"
                                                v-model="item.selected"
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            />
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ item.kode_jurusan }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ item.nama_jurusan }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <Link
                                                :href="route('jurusan.edit', item.id)"
                                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3"
                                            >
                                                <PencilIcon class="w-5 h-5 inline" />
                                            </Link>
                                            <button
                                                @click="handleDelete(item.id)"
                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300"
                                            >
                                                <TrashIcon class="w-5 h-5 inline" />
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Bulk Actions -->
                        <div class="mt-4 flex justify-between items-center">
                            <button
                                @click="handleBulkDelete"
                                class="px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Hapus yang Dipilih
                            </button>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-4">
                            <div class="flex justify-between items-center">
                                <div class="text-sm text-gray-700 dark:text-gray-300">
                                    Menampilkan {{ jurusan.from }} sampai {{ jurusan.to }} dari
                                    {{ jurusan.total }} data
                                </div>
                                <div class="flex space-x-2">
                                    <Link
                                        v-for="link in jurusan.links"
                                        :key="link.url"
                                        :href="link.url"
                                        class="px-3 py-1 rounded-md text-sm"
                                        :class="{
                                            'bg-indigo-600 text-white': link.active,
                                            'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300': !link.active,
                                            'opacity-50 cursor-not-allowed': !link.url,
                                        }"
                                        v-html="link.label"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template> 