<!-- resources/js/Layouts/Admin/ContentHeader.vue -->
<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    title: { type: String, default: "Dashboard" },
});
</script>

<template>
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">
                        <slot>{{ title }}</slot>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item">
                            <Link href="/dashboard">Home</Link>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <slot>{{ title }}</slot>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</template>
