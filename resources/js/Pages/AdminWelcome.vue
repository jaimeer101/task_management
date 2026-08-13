<!-- resources/js/Pages/Welcome.vue -->
<script setup>
import TopNavLayout from "@/Layouts/TopNavLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />

    <TopNavLayout>
        <!-- Hero Section -->
        <div class="p-5 mb-4 bg-body-tertiary rounded-3 shadow-sm border">
            <div class="container-fluid py-3">
                <h1 class="display-5 fw-bold">Welcome to Our Platform</h1>
                <p class="col-md-8 fs-4 text-secondary">
                    Built with Laravel, Vue 3, Inertia.js, and AdminLTE 4
                    Top-Nav Layout.
                </p>
                <Link href="/register" class="btn btn-primary btn-lg mt-2">
                    Get Started Now
                </Link>
            </div>
        </div>

        <!-- Feature Cards Row -->
        <div class="row g-4 py-2" id="features">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i
                            class="bi bi-lightning-charge fs-1 text-primary mb-3"
                        ></i>
                        <h5 class="card-title">Lightning Fast</h5>
                        <p class="card-text text-secondary">
                            Powered by Vite and Inertia.js for single-page app
                            responsiveness.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i
                            class="bi bi-shield-check fs-1 text-success mb-3"
                        ></i>
                        <h5 class="card-title">Secure Auth</h5>
                        <p class="card-text text-secondary">
                            Pre-configured Laravel Breeze authentication for
                            secure login and registration.
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body text-center p-4">
                        <i class="bi bi-palette fs-1 text-warning mb-3"></i>
                        <h5 class="card-title">AdminLTE 4 UI</h5>
                        <p class="card-text text-secondary">
                            Modern Bootstrap 5 design components and responsive
                            top-navigation layout.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </TopNavLayout>
</template>
