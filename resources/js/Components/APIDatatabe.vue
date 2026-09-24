<script setup>
import { ref, onMounted, useSlots, computed } from "vue";
import axios from "axios";

const props = defineProps({
    apiUrl: { type: String, required: true },
    columns: { type: Array, required: true }, // e.g., [{key: 'id', label: 'ID'}, {key: 'title', label: 'Title'}]
});

const slots = useSlots();
const hasActions = !!slots.actions;

const tableData = ref({ data: [], links: [] });
const search = ref("");
const perPage = ref(10);
const sortBy = ref("id");
const sortDirection = ref("desc");
const loading = ref(false);
let searchTimeout = null;

// Helper to access nested keys like 'user.name'
const getNestedValue = (obj, path) => {
    return path.split(".").reduce((acc, part) => acc && acc[part], obj);
};

const fetchData = (url = props.apiUrl) => {
    loading.value = true;
    let requestUrl = url;

    if (url === props.apiUrl) {
        const params = new URLSearchParams({
            search: search.value,
            per_page: perPage.value,
            sort_by: sortBy.value,
            sort_direction: sortDirection.value,
        });
        requestUrl = `${url}?${params.toString()}`;
    }

    axios
        .get(requestUrl)
        .then((response) => {
            tableData.value = response.data;
        })
        .catch((error) => console.error("Error loading data:", error))
        .finally(() => (loading.value = false));
};

const debounceSearch = () => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => fetchData(), 300);
};

const sortByColumn = (column) => {
    if (sortBy.value === column) {
        sortDirection.value = sortDirection.value === "asc" ? "desc" : "asc";
    } else {
        sortBy.value = column;
        sortDirection.value = "asc";
    }
    fetchData();
};

const getSortIcon = (column) => {
    if (sortBy.value !== column)
        return "bi bi-arrow-down-up text-muted opacity-50 ms-1";
    return sortDirection.value === "asc"
        ? "bi bi-arrow-up text-primary ms-1"
        : "bi bi-arrow-down text-primary ms-1";
};

const changePage = (url) => {
    if (url) {
        const fullUrl = `${url}&per_page=${perPage.value}&search=${search.value}&sort_by=${sortBy.value}&sort_direction=${sortDirection.value}`;
        fetchData(fullUrl);
    }
};

const items = computed(() => {
    // If wrapped in API Resource, data is in tableData.data.data (or tableData.data)
    // If raw pagination, data is in tableData.data
    return tableData.value.data ?? [];
});

const paginationMeta = computed(() => {
    // If using API Resource, meta/links are under tableData.meta and tableData.links
    // If raw, they are directly on tableData
    return {
        from: tableData.value.meta?.from ?? tableData.value.from ?? 0,
        to: tableData.value.meta?.to ?? tableData.value.to ?? 0,
        total: tableData.value.meta?.total ?? tableData.value.total ?? 0,
        links: tableData.value.meta?.links ?? tableData.value.links ?? [],
        per_page:
            tableData.value.meta?.per_page ?? tableData.value.per_page ?? 0,
        current_page:
            tableData.value.meta?.current_page ??
            tableData.value.current_page ??
            0,
    };
});

onMounted(() => fetchData());
</script>
<template>
    <div class="card card-primary card-outline">
        <!-- Controls Header -->
        <div
            class="card-header d-flex justify-content-between align-items-center"
        >
            <div class="d-flex align-items-center">
                <span class="me-2 text-muted small">Show</span>
                <select
                    v-model="perPage"
                    @change="fetchData"
                    class="form-select form-select-sm"
                    style="width: 75px"
                >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                <span class="ms-2 text-muted small">entries</span>
            </div>

            <div class="ms-auto">
                <input
                    type="text"
                    v-model="search"
                    @input="debounceSearch"
                    placeholder="Search..."
                    class="form-control form-control-sm"
                    style="width: 220px"
                />
            </div>
        </div>

        <!-- Dynamic Table Body -->
        <div class="card-body p-0">
            <div class="table-responsive">
                <table
                    class="table table-striped table-hover align-middle mb-0"
                >
                    <thead>
                        <tr>
                            <th
                                v-for="col in columns"
                                :key="col.key"
                                @click="
                                    col.sortable !== false
                                        ? sortByColumn(col.key)
                                        : null
                                "
                                :style="
                                    col.sortable !== false
                                        ? 'cursor: pointer;'
                                        : ''
                                "
                            >
                                {{ col.label }}
                                <i
                                    v-if="col.sortable !== false"
                                    :class="getSortIcon(col.key)"
                                ></i>
                            </th>
                            <th v-if="hasActions" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="loading">
                            <td
                                :colspan="columns.length + (hasActions ? 1 : 0)"
                                class="text-center py-4"
                            >
                                <div
                                    class="spinner-border spinner-border-sm text-primary"
                                    role="status"
                                ></div>
                                Loading...
                            </td>
                        </tr>
                        <tr v-else-if="tableData.data.length === 0">
                            <td
                                :colspan="columns.length + (hasActions ? 1 : 0)"
                                class="text-center py-4 text-muted"
                            >
                                No matching records found.
                            </td>
                        </tr>
                        <tr
                            v-for="(item, index) in tableData.data"
                            :key="item.id"
                        >
                            <td v-for="col in columns" :key="col.key">
                                <!-- Check if a custom slot/formatter is needed, otherwise print nested value -->
                                <slot
                                    :name="col.key"
                                    :item="item"
                                    :index="index"
                                    :pagination="paginationMeta"
                                >
                                    {{ getNestedValue(item, col.key) }}
                                </slot>
                            </td>

                            <!-- Optional Actions Column -->
                            <td v-if="hasActions" class="text-end">
                                <slot name="actions" :item="item"></slot>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Footer Pagination -->
        <div
            class="card-footer clearfix d-flex justify-content-between align-items-center"
        >
            <div class="text-muted small">
                Showing {{ paginationMeta.from }} to {{ paginationMeta.to }} of
                {{ paginationMeta.total }} entries
            </div>
            <ul class="pagination pagination-sm ms-auto">
                <li
                    v-for="(link, index) in paginationMeta.links"
                    :key="index"
                    :class="[
                        'page-item',
                        { active: link.active, disabled: !link.url },
                    ]"
                >
                    <button
                        class="page-link"
                        @click="changePage(link.url)"
                        v-html="link.label ?? ''"
                    ></button>
                </li>
            </ul>
        </div>
    </div>
</template>
