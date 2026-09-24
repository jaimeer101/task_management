<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import SmallBox from "@/Components/AdminLTE/SmallBox.vue";
import Card from "@/Components/AdminLTE/Card.vue";
import Alert from "@/Components/AdminLTE/Alert.vue";
import { Head } from "@inertiajs/vue3";
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
            <div class="col-lg-3 col-6">
                <SmallBox
                    title="New Orders"
                    value="150"
                    icon="bi-bag"
                    bg-class="text-bg-primary"
                />
            </div>
            <div class="col-lg-3 col-6">
                <SmallBox
                    title="Bounce Rate"
                    value="53"
                    unit="%"
                    icon="bi-graph-up-arrow"
                    bg-class="text-bg-success"
                />
            </div>
            <div class="col-lg-3 col-6">
                <SmallBox
                    title="User Registrations"
                    value="44"
                    unit="%"
                    icon="bi-person-add"
                    bg-class="text-bg-warning"
                />
            </div>
            <div class="col-lg-3 col-6">
                <SmallBox
                    title="Unique Visitors"
                    value="65"
                    unit="%"
                    icon="bi-pie-chart"
                    bg-class="text-bg-danger"
                />
            </div>
        </div>

        <!-- Reusable Card -->
        <Card
            title="Sales Report"
            collapsible
            removable
            variant="card-outline card-primary"
        >
            <p>Your main card content goes here.</p>

            <template #footer> Updated 5 minutes ago </template>
        </Card>
    </AdminLayout>
</template>
