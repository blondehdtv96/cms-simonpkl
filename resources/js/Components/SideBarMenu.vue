<script setup>
import {
    HomeIcon,
    UserIcon,
    CheckBadgeIcon,
    KeyIcon,
    ShieldCheckIcon,
    UserGroupIcon,
    AcademicCapIcon,
    BuildingOfficeIcon,
    BookOpenIcon,
    UsersIcon,
    RectangleStackIcon,
} from "@heroicons/vue/24/solid";
import { Link } from "@inertiajs/vue3";
</script>
<template>
    <div class="text-slate-300 pt-5 pb-20">
        <div class="flex justify-center">
            <div
                class="rounded-full flex items-center justify-center bg-primary text-slate-300 w-24 h-24 text-4xl uppercase"
            >
                {{
                    $page.props.auth?.user?.name
                        ?.match(/(^\S\S?|\b\S)?/g)
                        ?.join("")
                        ?.match(/(^\S|\S$)?/g)
                        ?.join("") || ""
                }}
            </div>
        </div>
        <div
            class="text-center py-3 px-4 border-b border-slate-700 dark:border-slate-800"
        >
            <span class="flex items-center justify-center">
                <p class="truncate text-md">{{ $page.props.auth?.user?.name || 'Guest' }}</p>
                <div>
                    <CheckBadgeIcon
                        class="ml-[2px] w-4 h-4"
                        v-show="$page.props.auth?.user?.email_verified_at"
                    />
                </div>
            </span>
            <span class="block text-sm font-medium truncate">{{
                $page.props.auth?.user?.roles?.[0]?.name || 'No Role'
            }}</span>
        </div>
        <ul class="space-y-2 my-4">
            <li
                class="text-white rounded-lg hover:bg-primary dark:hover:bg-primary"
                v-bind:class="
                    route().current($page.props.auth?.user?.roles?.[0]?.name === 'siswa' ? 'student.dashboard' : 'dashboard')
                        ? 'bg-primary'
                        : 'bg-slate-700/40 dark:bg-slate-800/40'
                "
            >
                <Link
                    :href="route($page.props.auth?.user?.roles?.[0]?.name === 'siswa' ? 'student.dashboard' : 'dashboard')"
                    class="flex items-center py-2 px-4"
                >
                    <HomeIcon class="w-6 h-5" />
                    <span class="ml-3">Dashboard</span>
                </Link>
            </li>

            <!-- Admin Sections - Only visible to admin and superadmin -->
            <template v-if="$page.props.auth?.user?.roles?.[0]?.name === 'admin' || $page.props.auth?.user?.roles?.[0]?.name === 'superadmin'">
                <!-- Data Management Section -->
                <li v-show="can(['read user'])" class="py-2">
                    <p>Data Management</p>
                </li>

                <!-- Wali Kelas -->
                <li
                    v-show="can(['read user'])"
                    class="text-white rounded-lg hover:bg-primary dark:hover:bg-primary"
                    v-bind:class="
                        route().current('walikelas.index')
                            ? 'bg-primary'
                            : 'bg-slate-700/40 dark:bg-slate-800/40'
                    "
                >
                    <Link
                        :href="route('walikelas.index')"
                        class="flex items-center py-2 px-4"
                    >
                        <UserGroupIcon class="w-6 h-5" />
                        <span class="ml-3">Wali Kelas</span>
                    </Link>
                </li>

                <!-- Kaprog -->
                <li
                    v-show="can(['read user'])"
                    class="text-white rounded-lg hover:bg-primary dark:hover:bg-primary"
                    v-bind:class="
                        route().current('kaprog.index')
                            ? 'bg-primary'
                            : 'bg-slate-700/40 dark:bg-slate-800/40'
                    "
                >
                    <Link
                        :href="route('kaprog.index')"
                        class="flex items-center py-2 px-4"
                    >
                        <AcademicCapIcon class="w-6 h-5" />
                        <span class="ml-3">Kepala Program</span>
                    </Link>
                </li>

                <!-- Hubin -->
                <li
                    v-show="can(['read user'])"
                    class="text-white rounded-lg hover:bg-primary dark:hover:bg-primary"
                    v-bind:class="
                        route().current('hubin.index')
                            ? 'bg-primary'
                            : 'bg-slate-700/40 dark:bg-slate-800/40'
                    "
                >
                    <Link
                        :href="route('hubin.index')"
                        class="flex items-center py-2 px-4"
                    >
                        <BuildingOfficeIcon class="w-6 h-5" />
                        <span class="ml-3">Hubin</span>
                    </Link>
                </li>

                <!-- Siswa -->
                <li
                    v-show="can(['read user'])"
                    class="text-white rounded-lg hover:bg-primary dark:hover:bg-primary"
                    v-bind:class="
                        route().current('siswa.index')
                            ? 'bg-primary'
                            : 'bg-slate-700/40 dark:bg-slate-800/40'
                    "
                >
                    <Link
                        :href="route('siswa.index')"
                        class="flex items-center py-2 px-4"
                    >
                        <UsersIcon class="w-6 h-5" />
                        <span class="ml-3">Siswa</span>
                    </Link>
                </li>

                <!-- Jurusan -->
                <li
                    v-show="can(['read user'])"
                    class="text-white rounded-lg hover:bg-primary dark:hover:bg-primary"
                    v-bind:class="
                        route().current('jurusan.index')
                            ? 'bg-primary'
                            : 'bg-slate-700/40 dark:bg-slate-800/40'
                    "
                >
                    <Link
                        :href="route('jurusan.index')"
                        class="flex items-center py-2 px-4"
                    >
                        <BookOpenIcon class="w-6 h-5" />
                        <span class="ml-3">Jurusan</span>
                    </Link>
                </li>
            </template>

            <!-- Student Section - Only visible to students -->
            <template v-if="$page.props.auth?.user?.roles?.[0]?.name === 'siswa'">
                <!-- Student Menu Items Here -->
                <li class="py-2">
                    <p>Menu Siswa</p>
                </li>
                <!-- Add student-specific menu items here -->
            </template>

            <!-- Original User Management Section -->
            <li v-show="can(['read user'])" class="py-2">
                <p>{{ lang().label.data }}</p>
            </li>
            <li
                v-show="can(['read user'])"
                class="text-white rounded-lg hover:bg-primary dark:hover:bg-primary"
                v-bind:class="
                    route().current('user.index')
                        ? 'bg-primary'
                        : 'bg-slate-700/40 dark:bg-slate-800/40'
                "
            >
                <Link
                    :href="route('user.index')"
                    class="flex items-center py-2 px-4"
                >
                    <UserIcon class="w-6 h-5" />
                    <span class="ml-3">{{ lang().label.user }}</span>
                </Link>
            </li>

            <!-- Access Management Section -->
            <li v-show="can(['read role', 'read permission'])" class="py-2">
                <p>{{ lang().label.access }}</p>
            </li>
            <li
                v-show="can(['read role'])"
                class="text-white rounded-lg hover:bg-primary dark:hover:bg-primary"
                v-bind:class="
                    route().current('role.index')
                        ? 'bg-primary'
                        : 'bg-slate-700/40 dark:bg-slate-800/40'
                "
            >
                <Link
                    :href="route('role.index')"
                    class="flex items-center py-2 px-4"
                >
                    <KeyIcon class="w-6 h-5" />
                    <span class="ml-3">{{ lang().label.role }}</span>
                </Link>
            </li>
            <li
                v-show="can(['read permission'])"
                class="text-white rounded-lg hover:bg-primary dark:hover:bg-primary"
                v-bind:class="
                    route().current('permission.index')
                        ? 'bg-primary'
                        : 'bg-slate-700/40 dark:bg-slate-800/40'
                "
            >
                <Link
                    :href="route('permission.index')"
                    class="flex items-center py-2 px-4"
                >
                    <ShieldCheckIcon class="w-6 h-5" />
                    <span class="ml-3">{{ lang().label.permission }}</span>
                </Link>
            </li>
        </ul>
    </div>
</template>
