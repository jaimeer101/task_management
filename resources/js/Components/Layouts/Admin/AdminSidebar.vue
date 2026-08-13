<!-- resources/js/Layouts/Admin/Sidebar.vue -->
<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!-- Sidebar Brand -->
        <div class="sidebar-brand">
            <Link href="/dashboard" class="brand-link">
                <i class="bi bi-speedometer2 me-2"></i>
                <span class="brand-text fw-light">AdminLTE 4</span>
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
                    <li class="nav-item">
                        <Link
                            href="/dashboard"
                            class="nav-link"
                            :class="{ active: $page.url === '/dashboard' }"
                        >
                            <i class="nav-icon bi bi-speedometer"></i>
                            <p>Dashboard</p>
                        </Link>
                    </li>

                    <li class="nav-header">MANAGEMENT</li>

                    <li class="nav-item">
                        <Link
                            href="/profile"
                            class="nav-link"
                            :class="{
                                active: $page.url.startsWith('/profile'),
                            }"
                        >
                            <i class="nav-icon bi bi-person"></i>
                            <p>Profile Settings</p>
                        </Link>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
</template>
