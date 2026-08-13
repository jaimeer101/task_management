<script setup>
defineProps({
    title: { type: String, default: "" },
    variant: { type: String, default: "" }, // e.g., 'card-primary', 'card-outline card-secondary'
    collapsible: { type: Boolean, default: false },
    removable: { type: Boolean, default: false },
});
</script>

<template>
    <div class="card mb-4" :class="variant">
        <!-- Card Header -->
        <div
            v-if="title || $slots.header || collapsible || removable"
            class="card-header"
        >
            <h3 class="card-title">
                <slot name="header">{{ title }}</slot>
            </h3>

            <div class="card-tools">
                <slot name="tools" />

                <button
                    v-if="collapsible"
                    type="button"
                    class="btn btn-tool"
                    data-lte-toggle="card-collapse"
                >
                    <i class="bi bi-dash-lg"></i>
                </button>

                <button
                    v-if="removable"
                    type="button"
                    class="btn btn-tool"
                    data-lte-toggle="card-remove"
                >
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <slot />
        </div>

        <!-- Card Footer -->
        <div v-if="$slots.footer" class="card-footer">
            <slot name="footer" />
        </div>
    </div>
</template>
