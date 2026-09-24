<script setup lang="ts">
import APIDatatabe from "@/Components/APIDatatabe.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import axios from "axios";
import { ref } from "vue";

const userColumns = ref([
    { key: "id", label: "ID" },
    { key: "name", label: "Name" },
    { key: "email", label: "Email" },
    { key: "roles", label: "Roles" },
    { key: "tasks_count", label: "Task Count" },
]);

const deleteUser = (id: number) => {
    if (confirm("Are you sure you want to delete this user?")) {
        axios.delete(route("api.users.destroy", { userId: id })).then(() => {
            window.location.reload(); // or re-trigger table fetch if handled via event emission
        });
    }
};
</script>

<template>
    <AdminLayout>
        <Head title="Users" />
        <template #header>Users Overview</template>
        <div class="d-flex flex-wrap justify-content-md-end gap-2 mb-2">
            <Link class="btn btn-primary" :href="route('admin.users.create')"
                >Create User
            </Link>
        </div>
        <div>
            <APIDatatabe :api-url="'/api/users'" :columns="userColumns">
                <template #id="{ index, pagination }">
                    <span class="text-body-md font-body-md text-text-secondary">
                        <!-- <pre>{{ pagination }}</pre> -->
                        {{
                            (Number(pagination.current_page) - 1) *
                                Number(pagination.per_page) +
                            Number(index) +
                            1
                        }}
                    </span>
                </template>
                <template #roles="{ item }">
                    <span
                        v-for="role in item.roles"
                        :key="role.id"
                        class="badge bg-secondary me-1"
                    >
                        {{ role.name }}
                    </span>
                    <span
                        v-if="!item.roles || item.roles.length === 0"
                        class="text-muted small"
                    >
                        No Role
                    </span>
                </template>
                <template #actions="{ item }">
                    <a
                        :href="route('admin.users.edit', { userId: item.id })"
                        class="btn btn-sm btn-outline-primary me-1"
                    >
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button
                        @click="deleteUser(item.id)"
                        class="btn btn-sm btn-outline-danger"
                    >
                        <i class="bi bi-trash"></i>
                    </button>
                </template>
            </APIDatatabe>
        </div>
    </AdminLayout>
</template>
