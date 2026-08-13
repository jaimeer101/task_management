<script setup>
defineProps({
    variant: { type: String, default: "info" }, // 'primary', 'success', 'warning', 'danger', 'info'
    icon: { type: String, default: "" }, // e.g., 'bi-info-circle', 'bi-check-circle'
    dismissible: { type: Boolean, default: true },
});
</script>

<template>
    <div
        class="alert fade show"
        :class="[`alert-${variant}`, { 'alert-dismissible': dismissible }]"
        role="alert"
    >
        <i v-if="icon" class="bi me-2" :class="icon"></i>
        <slot />

        <button
            v-if="dismissible"
            type="button"
            class="btn-close"
            data-bs-dismiss="alert"
            aria-label="Close"
        ></button>
    </div>
</template>
