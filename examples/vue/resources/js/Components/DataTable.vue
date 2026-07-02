<script setup lang="ts">
import { ref, computed, onMounted, watch } from 'vue';

const props = defineProps<{
    ajaxUrl: string;
    columns: Array<{
        data: string;
        name: string;
        title: string;
        orderable: boolean;
        searchable: boolean;
        className?: string;
    }>;
    perPage?: number;
    perPageSelect?: number[];
}>();

const emit = defineEmits<{
    (e: 'edit', item: any): void;
    (e: 'delete', id: number): void;
}>();

const data = ref<any[]>([]);
const total = ref(0);
const currentPage = ref(1);
const perPage = ref(props.perPage || 10);
const searchQuery = ref('');
const sortColumn = ref('');
const sortDirection = ref('asc');
const loading = ref(false);
const error = ref('');

const totalPages = computed(() => Math.ceil(total.value / perPage.value));

async function fetchData() {
    loading.value = true;
    error.value = '';
    try {
        const params = new URLSearchParams();
        params.set('draw', '1');
        params.set('start', String((currentPage.value - 1) * perPage.value));
        params.set('length', String(perPage.value));
        props.columns.forEach((col, i) => {
            params.set(`columns[${i}][data]`, col.data);
            params.set(`columns[${i}][name]`, col.name);
            params.set(`columns[${i}][searchable]`, String(col.searchable));
            params.set(`columns[${i}][orderable]`, String(col.orderable));
        });
        if (sortColumn.value) {
            params.set('order[0][column]', String(props.columns.findIndex(c => c.data === sortColumn.value)));
            params.set('order[0][dir]', sortDirection.value);
        }
        params.set('search[value]', searchQuery.value);
        params.set('search[regex]', 'false');

        const response = await fetch(props.ajaxUrl, {
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content || '',
                'Accept': 'application/json',
            },
        });
        const json = await response.json();
        data.value = json.data;
        total.value = json.recordsTotal;
    } catch (err: any) {
        error.value = err?.response?.data?.message || err.message || 'Veri yüklenirken bir hata oluştu.';
    } finally {
        loading.value = false;
    }
}

onMounted(() => {
    fetchData();
});

watch([currentPage, perPage, searchQuery, sortColumn, sortDirection], () => {
    fetchData();
});

function sort(col: string) {
    if (sortColumn.value === col) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortColumn.value = col;
        sortDirection.value = 'asc';
    }
}

function editItem(item: any) {
    emit('edit', item);
}

function deleteItem(id: number) {
    emit('delete', id);
}
</script>

<template>
    <div class="space-y-4">
        <!-- Search -->
        <div class="flex justify-between items-center">
            <div class="flex items-center gap-2">
                <label class="text-sm text-gray-600">Show</label>
                <select v-model="perPage" class="border rounded px-2 py-1 text-sm">
                    <option v-for="opt in (perPageSelect || [10, 25, 50, 100])" :key="opt" :value="opt">{{ opt }}</option>
                    <option value="-1">All</option>
                </select>
                <label class="text-sm text-gray-600">entries</label>
            </div>
            <div class="flex items-center gap-2">
                <label class="text-sm text-gray-600">Search:</label>
                <input v-model="searchQuery" type="text" class="border rounded px-2 py-1 text-sm" placeholder="Search...">
            </div>
        </div>

        <!-- Error -->
        <div v-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ error }}
        </div>

        <!-- Table -->
        <div class="overflow-x-auto border rounded">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th v-for="col in columns" :key="col.name"
                            :class="['px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer', col.className]"
                            @click="col.orderable && sort(col.name)">
                            <span class="flex items-center gap-1">
                                {{ col.title }}
                                <span v-if="sortColumn === col.name" class="text-xs">
                                    {{ sortDirection === 'asc' ? '↑' : '↓' }}
                                </span>
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-if="loading">
                        <td :colspan="columns.length" class="px-4 py-8 text-center text-gray-500">
                            <span class="inline-block animate-pulse">Loading...</span>
                        </td>
                    </tr>
                    <tr v-else-if="data.length === 0">
                        <td :colspan="columns.length" class="px-4 py-8 text-center text-gray-500">
                            No data available in table
                        </td>
                    </tr>
                    <tr v-for="(row, idx) in data" :key="row.id || idx" class="hover:bg-gray-50">
                        <td v-for="col in columns" :key="col.name" class="px-4 py-2 text-sm text-gray-900">
                            <!-- Checkbox -->
                            <template v-if="col.name === 'select_checkbox'">
                                <input type="checkbox" class="rounded border-gray-300">
                            </template>
                            <!-- ID -->
                            <template v-else-if="col.name === 'id'">
                                {{ row.id }}
                            </template>
                            <!-- Published At -->
                            <template v-else-if="col.name === 'published_at'">
                                {{ row.published_at ? new Date(row.published_at).toLocaleString() : '-' }}
                            </template>
                            <!-- Is Published / Status badge -->
                            <template v-else-if="col.name === 'is_published' || col.name === 'status'">
                                <span :class="row.is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'"
                                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full">
                                    {{ row.is_published ? 'Published' : 'Draft' }}
                                </span>
                            </template>
                            <!-- Actions -->
                            <template v-else-if="col.name === 'actions'">
                                <div class="flex gap-2">
                                    <button @click="editItem(row)"
                                            class="px-3 py-1.5 text-sm font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                                        Edit
                                    </button>
                                    <button @click="deleteItem(row.id)"
                                            class="px-3 py-1.5 text-sm font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700">
                                        Delete
                                    </button>
                                </div>
                            </template>
                            <!-- Default -->
                            <template v-else>
                                {{ row[col.name] }}
                            </template>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-between items-center text-sm text-gray-600">
            <div>
                Showing {{ ((currentPage - 1) * perPage) + 1 }} to
                {{ Math.min(currentPage * perPage, total) }} of {{ total }} entries
            </div>
            <div class="flex gap-2">
                <button :disabled="currentPage <= 1" @click="currentPage--"
                        class="px-3 py-1 border rounded disabled:opacity-50 hover:bg-gray-100">
                    Previous
                </button>
                <span class="px-3 py-1">Page {{ currentPage }} of {{ totalPages }}</span>
                <button :disabled="currentPage >= totalPages" @click="currentPage++"
                        class="px-3 py-1 border rounded disabled:opacity-50 hover:bg-gray-100">
                    Next
                </button>
            </div>
        </div>
    </div>
</template>
