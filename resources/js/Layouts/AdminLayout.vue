<!-- resources/js/Layouts/AdminLayout.vue -->
<script setup>
import AdminContentHeader from "@/Components/Layouts/Admin/AdminContentHeader.vue";
import AdminFooter from "@/Components/Layouts/Admin/AdminFooter.vue";
import AdminNavbar from "@/Components/Layouts/Admin/AdminNavbar.vue";
import AdminSidebar from "@/Components/Layouts/Admin/AdminSidebar.vue";

defineProps({
    title: { type: String, default: "Dashboard" },
});
</script>

<template>
    <div class="app-wrapper">
        <!-- Navbar Component -->
        <AdminNavbar />

        <!-- Sidebar Component -->
        <AdminSidebar />

        <!-- Main Content Wrapper -->
        <main class="app-main">
            <AdminContentHeader :title="title">
                <slot name="header" />
            </AdminContentHeader>

            <div class="app-content">
                <div class="container-fluid">
                    <slot />
                </div>
            </div>
        </main>

        <!-- Footer Component -->
        <AdminFooter />
    </div>
</template>
