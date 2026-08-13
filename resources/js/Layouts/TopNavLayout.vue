<!-- resources/js/Layouts/TopNavLayout.vue -->
<script setup>
import TopNavContent from "@/Components/Layouts/TopNav/TopNavContent.vue";
import TopNavFooter from "@/Components/Layouts/TopNav/TopNavFooter.vue";
import TopNavHeader from "@/Components/Layouts/TopNav/TopNavHeader.vue";
</script>

<template>
    <div class="app-wrapper layout-top-nav">
        <!-- Header -->
        <TopNavHeader />

        <!-- Main Content -->
        <TopNavContent>
            <slot />
        </TopNavContent>

        <!-- Footer -->
        <TopNavFooter />
    </div>
</template>
