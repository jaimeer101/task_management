<!-- resources/js/Layouts/Admin/Navbar.vue -->
<script setup>
import { Link, usePage } from "@inertiajs/vue3";

const page = usePage();
const user = page.props.auth
    ? page.props.auth.user
    : { name: "User", email: "" };
</script>

<template>
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a
                        class="nav-link"
                        data-lte-toggle="sidebar"
                        href="#"
                        role="button"
                    >
                        <i class="bi bi-list"></i>
                    </a>
                </li>
                <li class="nav-item d-none d-md-block">
                    <Link href="/dashboard" class="nav-link">Home</Link>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown user-menu">
                    <a
                        href="#"
                        class="nav-link dropdown-toggle"
                        data-bs-toggle="dropdown"
                    >
                        <i class="bi bi-person-circle me-1"></i>
                        <span class="d-none d-md-inline">{{ user.name }}</span>
                    </a>
                    <ul
                        class="dropdown-menu dropdown-menu-lg dropdown-menu-end"
                    >
                        <li class="user-header text-bg-primary text-center p-3">
                            <i class="bi bi-person-circle fs-1"></i>
                            <p class="mt-2 mb-0">
                                {{ user.name }}
                                <small class="d-block">{{ user.email }}</small>
                            </p>
                        </li>
                        <li
                            class="user-footer d-flex justify-content-between p-2"
                        >
                            <Link
                                href="/profile"
                                class="btn btn-default btn-flat"
                                >Profile</Link
                            >
                            <Link
                                href="/logout"
                                method="post"
                                as="button"
                                class="btn btn-danger btn-flat"
                            >
                                Sign out
                            </Link>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</template>
