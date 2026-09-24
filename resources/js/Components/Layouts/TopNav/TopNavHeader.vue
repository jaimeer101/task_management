<!-- resources/js/Components/Layout/TopNav/TopNavHeader.vue -->
<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const page = usePage();
const user = computed(() => page.props.auth?.user);
console.log(user.value);
</script>

<template>
    <nav class="app-header navbar navbar-expand-lg bg-body shadow-sm">
        <div class="container">
            <!-- Brand Logo -->
            <Link href="/" class="navbar-brand me-4">
                <i class="bi bi-speedometer2 me-2 text-primary"></i>
                <span class="brand-text fw-bold">Task Manager</span>
            </Link>

            <!-- Mobile Toggler -->
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#topNavbarCollapse"
                aria-controls="topNavbarCollapse"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Nav Links -->
            <div class="navbar-collapse" id="topNavbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <Link
                            href="/"
                            class="nav-link"
                            :class="{ active: $page.url === '/' }"
                            >Home</Link
                        >
                    </li>
                    <li class="nav-item">
                        <a href="#features" class="nav-link">Docs</a>
                    </li>
                    <li class="nav-item">
                        <a href="#about" class="nav-link">About</a>
                    </li>
                </ul>

                <!-- Right Side Auth Links / User Profile -->
                <div class="d-flex align-items-center gap-2">
                    <template v-if="user">
                        <Link
                            href="/dashboard"
                            class="btn btn-outline-primary btn-sm"
                        >
                            Dashboard
                        </Link>
                    </template>
                    <template v-else>
                        <Link
                            href="/login"
                            class="btn btn-outline-secondary btn-sm"
                        >
                            Log in
                        </Link>
                        <!-- <Link href="/register" class="btn btn-primary btn-sm">
                            Register
                        </Link> -->
                    </template>
                </div>
            </div>
        </div>
    </nav>
</template>
