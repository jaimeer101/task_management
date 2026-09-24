<!-- resources/js/Layouts/Admin/Sidebar.vue -->
<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();
const menuItems = computed(() => page.props.menu || []);
const isActive = (href) => {
    // Convert absolute URL (http://127.0.0.1:8000/dashboard) into just the pathname (/dashboard)
    const path = new URL(href).pathname;

    // Use an exact match for the dashboard to prevent false positives
    if (path === "/dashboard") {
        return page.url === path;
    }

    // Use startsWith for other resource pages (e.g., /users, /tasks)
    // so nested routes like /users/create still highlight the "Users" menu
    return page.url.startsWith(path);
};
</script>

<template>
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!-- Sidebar Brand -->
        <div class="sidebar-brand">
            <Link href="/dashboard" class="brand-link">
                <i class="bi bi-speedometer2 me-2"></i>
                <span class="brand-text fw-light">Task Manager</span>
            </Link>
        </div>

        <!-- Sidebar Navigation -->
        <div class="sidebar-wrapper">
            <nav class="mt-2">
                <ul
                    class="nav sidebar-menu flex-column"
                    data-lte-toggle="treeview"
                    role="menu"
                >
                    <template v-for="(item, index) in menuItems" :key="index">
                        <!-- Render Header -->
                        <li v-if="item.type === 'header'" class="nav-header">
                            {{ item.name }}
                        </li>

                        <!-- Render Link -->
                        <li v-else-if="item.type === 'link'" class="nav-item">
                            <Link
                                :href="item.href"
                                class="nav-link"
                                :class="{
                                    active: isActive(item.href),
                                }"
                            >
                                <i :class="['nav-icon', item.icon]"></i>
                                <p>{{ item.name }}</p>
                            </Link>
                        </li>
                    </template>
                </ul>
            </nav>
        </div>
    </aside>
</template>
