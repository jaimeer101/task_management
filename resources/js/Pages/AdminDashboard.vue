<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import SmallBox from "@/Components/AdminLTE/SmallBox.vue";
import Card from "@/Components/AdminLTE/Card.vue";
import Alert from "@/Components/AdminLTE/Alert.vue";
import { Head } from "@inertiajs/vue3";
defineProps({
    stats: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <AdminLayout>
        <Head title="Dashboard" />
        <template #header>Dashboard Overview</template>

        <!-- Alert Component -->
        <!-- <Alert variant="success" icon="bi-check-circle-fill">
            Data synced successfully!
        </Alert> -->

        <!-- Stat Boxes Row -->
        <div class="row">
            <div class="col-lg-3 col-6" v-if="stats.total_users !== undefined">
                <SmallBox
                    title="Users"
                    :value="stats.total_users"
                    icon="bi-person"
                    bg-class="text-bg-primary"
                    :link-url="route('admin.users.index')"
                />
            </div>
            <div class="col-lg-3 col-6">
                <SmallBox
                    :title="
                        stats.total_users !== undefined
                            ? 'Tasks'
                            : 'My Assigned Tasks'
                    "
                    :value="stats.total_tasks"
                    icon="bi-list-task"
                    bg-class="text-bg-success"
                    :link-url="route('task.index')"
                />
            </div>
        </div>
    </AdminLayout>
</template>
