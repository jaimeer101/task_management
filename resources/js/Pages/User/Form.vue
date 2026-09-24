<script setup lang="ts">
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";
const props = defineProps({
    user: {
        type: Object,
        default: null,
    },
    roles: {
        type: Array,
        default: null,
    },
});
const page = usePage();
const flashSuccess = computed(() => page.props.flash.success);

const showPassword = ref(false);

const form = useForm({
    name: props.user?.name ?? "",
    email: props.user?.email ?? "",
    password: null,
    confirm_password: null,
    role_id: props.user?.role_id ?? 2,
});

const submit = () => {
    if (props.user) {
        form.put(route("admin.users.update", props.user.id));
    } else {
        form.post(route("admin.users.store"), {
            onSuccess: () => {
                form.reset(); // Clears all form fields back to initial state
            },
        });
    }
};
</script>

<template>
    <AdminLayout>
        <Head :title="user ? 'Edit User' : 'Create User'" />
        <template #header>{{ user ? "Edit User" : "Create User" }}</template>
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
                            <div class="card-title">User Form</div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label" for="name"
                                    >Name</label
                                >
                                <input
                                    type="text"
                                    name="name"
                                    v-model="form.name"
                                    class="form-control"
                                />
                                <div
                                    v-if="form.errors.name"
                                    class="text-danger small mt-1"
                                >
                                    {{ form.errors.name }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="email"
                                    >Email</label
                                >
                                <input
                                    type="email"
                                    name="email"
                                    v-model="form.email"
                                    class="form-control"
                                />
                                <div
                                    v-if="form.errors.email"
                                    class="text-danger small mt-1"
                                >
                                    {{ form.errors.email }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password"
                                    >Password</label
                                >
                                <div class="input-group">
                                    <input
                                        :type="
                                            showPassword ? 'text' : 'password'
                                        "
                                        name="password"
                                        v-model="form.password"
                                        class="form-control"
                                    />
                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary"
                                        @click="showPassword = !showPassword"
                                    >
                                        <i
                                            :class="
                                                showPassword
                                                    ? 'bi bi-eye-slash'
                                                    : 'bi bi-eye'
                                            "
                                        ></i>
                                    </button>
                                </div>

                                <div
                                    v-if="form.errors.password"
                                    class="text-danger small mt-1"
                                >
                                    {{ form.errors.password }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="confirm_password"
                                    >Confirm Password</label
                                >
                                <div class="input-group">
                                    <input
                                        :type="
                                            showPassword ? 'text' : 'password'
                                        "
                                        name="confirm_password"
                                        v-model="form.confirm_password"
                                        class="form-control"
                                    />
                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary"
                                        @click="showPassword = !showPassword"
                                    >
                                        <i
                                            :class="
                                                showPassword
                                                    ? 'bi bi-eye-slash'
                                                    : 'bi bi-eye'
                                            "
                                        ></i>
                                    </button>
                                </div>

                                <div
                                    v-if="form.errors.confirm_password"
                                    class="text-danger small mt-1"
                                >
                                    {{ form.errors.confirm_password }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="role_id"
                                    >Role</label
                                >
                                <select
                                    id="role_id"
                                    v-model="form.role_id"
                                    class="form-control"
                                >
                                    <option value="" disabled>
                                        Select a role
                                    </option>
                                    <option
                                        v-for="role in roles"
                                        :key="role.id"
                                        :value="role.id"
                                    >
                                        {{ role.name }}
                                    </option>
                                </select>
                                <div
                                    v-if="form.errors.role_id"
                                    class="text-danger small mt-1"
                                >
                                    {{ form.errors.role_id }}
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
                                    {{ user ? "Update" : "Create" }}
                                </button>

                                <Link
                                    :href="route('admin.users.index')"
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
