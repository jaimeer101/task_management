<script setup>
defineProps({
    title: { type: String, required: true },
    value: { type: [String, Number], required: true },
    icon: { type: String, default: "bi-bag" }, // Bootstrap Icon class
    bgClass: { type: String, default: "text-bg-primary" }, // e.g. text-bg-success, text-bg-warning
    linkUrl: { type: String, default: "#" },
    linkText: { type: String, default: "More info" },
    unit: { type: String, default: "" },
});
</script>

<template>
    <div class="small-box" :class="bgClass">
        <div class="inner">
            <h3>
                {{ value }}<sup v-if="unit" class="fs-5">{{ unit }}</sup>
            </h3>
            <p>{{ title }}</p>
        </div>
        <i class="small-box-icon bi" :class="icon"></i>
        <a
            :href="linkUrl"
            class="small-box-footer link-underline-opacity-0 link-underline-opacity-50-hover"
            :class="bgClass.includes('warning') ? 'link-dark' : 'link-light'"
        >
            {{ linkText }} <i class="bi bi-link-45deg"></i>
        </a>
    </div>
</template>
