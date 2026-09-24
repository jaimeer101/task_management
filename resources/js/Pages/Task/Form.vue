<script setup lang="ts">
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
    task: {
        type: Object,
        default: null,
    },
    statuses: {
        type: Array,
        required: true,
    },
    users: {
        type: Array,
        default: () => [], // Will only be populated if the user is an admin
    },
    selectedUser: {
        type: Number,
        default: null, // Will only be populated if the user is an admin
    },
});
const page = usePage();
const flashSuccess = computed(() => page.props.flash.success);

// Initialize Inertia form with default values (fallback if creating)
const form = useForm({
    title: props.task?.title ?? "",
    description: props.task?.description ?? "",
    task_status: props.task?.task_status ?? "on-going", // Adjust field name to match your DB column
    user_id: props.task?.user_id ?? props.selectedUser,
});

// Submit handler: POST for create, PUT for update
const submit = () => {
    if (props.task) {
        form.put(route("task.update", props.task.id));
    } else {
        form.post(route("task.store"), {
            onSuccess: () => {
                form.reset(); // Clears all form fields back to initial state
            },
        });
    }
};
</script>

<template>
    <AdminLayout>
        <Head :title="task ? 'Edit Task' : 'Create Task'" />
        <template #header>{{ task ? "Edit Task" : "Create Task" }}</template>
        <div class="row g-4">
            <div class="col-6">
                <div
                    v-if="flashSuccess"
                    class="alert alert-success alert-dismissible fade show"
                    role="alert"
                >
                    {{ flashSuccess }}
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"
                    ></button>
                </div>
                <form @submit.prevent="submit">
                    <div class="card card-success card-outline mb-4">
                        <div class="card-header">
                            <div class="card-title">Task Form</div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3" v-if="users.length > 0">
                                <label class="form-label" for="user_id"
                                    >Assign To User</label
                                >
                                <select
                                    id="user_id"
                                    v-model="form.user_id"
                                    class="form-control"
                                >
                                    <option value="" disabled>
                                        Select a user
                                    </option>
                                    <option
                                        v-for="user in users"
                                        :key="user.id"
                                        :value="user.id"
                                    >
                                        {{ user.name }}
                                    </option>
                                </select>
                                <div
                                    v-if="form.errors.user_id"
                                    class="text-danger small mt-1"
                                >
                                    {{ form.errors.user_id }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="title"
                                    >Title</label
                                >
                                <input
                                    type="text"
                                    name="title"
                                    v-model="form.title"
                                    class="form-control"
                                />
                                <div
                                    v-if="form.errors.title"
                                    class="text-danger small mt-1"
                                >
                                    {{ form.errors.title }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="description"
                                    >Description</label
                                >
                                <textarea
                                    name="description"
                                    class="form-control"
                                    v-model="form.description"
                                    rows="4"
                                ></textarea>
                                <div
                                    v-if="form.errors.description"
                                    class="text-danger small mt-1"
                                >
                                    {{ form.errors.description }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="task_status"
                                    >Status</label
                                >
                                <select
                                    id="task_status"
                                    v-model="form.task_status"
                                    class="form-control"
                                >
                                    <option
                                        v-for="status in statuses"
                                        :key="status.value"
                                        :value="status.value"
                                    >
                                        {{ status.label }}
                                    </option>
                                </select>
                                <div
                                    v-if="form.errors.task_status"
                                    class="text-danger small mt-1"
                                >
                                    {{ form.errors.task_status }}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-inline-flex gap-1">
                                <button
                                    class="btn btn-info"
                                    type="submit"
                                    :disabled="form.processing"
                                >
                                    {{ task ? "Update" : "Save" }}
                                </button>

                                <Link
                                    :href="route('task.index')"
                                    class="btn btn-danger"
                                    >Back</Link
                                >
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
