<script setup lang="ts">
import APIDatatabe from "@/Components/APIDatatabe.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import axios from "axios";
import { ref } from "vue";

const taskColumns = ref([
    { key: "id", label: "ID" },
    { key: "title", label: "Task Title" },
    { key: "assigned_user", label: "Assigned User" }, // Supports nested relationships automatically
    { key: "date_started", label: "Start Date" },
    { key: "date_completed", label: "Completion Date" },
    { key: "date_deadline", label: "Target Date" },
    { key: "task_status", label: "Status" },
]);

const deleteTask = (id: number) => {
    if (confirm("Are you sure you want to delete this task?")) {
        axios.delete(route("api.task.destroy", { task: id })).then(() => {
            window.location.reload(); // or re-trigger table fetch if handled via event emission
        });
    }
};
</script>

<template>
    <AdminLayout>
        <Head title="Tasks" />
        <template #header>Tasks Overview</template>
        <div class="d-flex flex-wrap justify-content-md-end gap-2 mb-2">
            <Link class="btn btn-primary" :href="route('task.create')"
                >Create Task
            </Link>
        </div>

        <div>
            <APIDatatabe :api-url="'/api/tasks'" :columns="taskColumns">
                <template #title="{ item }">
                    <span :class="{ 'text-danger fw-bold': item.is_delayed }">
                        {{ item.title }}
                    </span>
                    <span v-if="item.is_delayed" class="badge bg-danger ms-2"
                        >Delayed</span
                    >
                </template>
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
                <template #task_status="{ item }">
                    <span
                        v-if="item.task_status"
                        :class="['badge', item.task_status.class]"
                    >
                        {{ item.task_status.label }}
                    </span>
                    <span v-else class="badge bg-secondary">N/A</span>
                </template>

                <!-- Custom actions column -->
                <template #actions="{ item }">
                    <a
                        :href="route('task.edit', { task: item.id })"
                        class="btn btn-sm btn-outline-primary me-1"
                    >
                        <i class="bi bi-pencil"></i>
                    </a>
                    <button
                        @click="deleteTask(item.id)"
                        class="btn btn-sm btn-outline-danger"
                    >
                        <i class="bi bi-trash"></i>
                    </button>
                </template>
            </APIDatatabe>
        </div>
    </AdminLayout>
</template>
