<script setup lang="ts">
import { ref } from 'vue';
import DataTable from '@/Components/DataTable.vue';
import FormModal from '@/Components/FormModal.vue';

const props = defineProps<{
    columns: Array<{
        data: string;
        name: string;
        title: string;
        orderable: boolean;
        searchable: boolean;
        className?: string;
    }>;
}>();

const modalOpen = ref(false);
const editItem = ref<any | null>(null);

function handleEdit(item: any) {
    editItem.value = item;
    modalOpen.value = true;
}

function handleCreate() {
    editItem.value = null;
    modalOpen.value = true;
}

function handleDelete(id: number) {
    if (confirm('Are you sure you want to delete this item? This action cannot be undone!')) {
        fetch(`/posts/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                'Accept': 'application/json',
            },
        })
        .then(() => {
            window.dispatchEvent(new CustomEvent('datatable-reload'));
        })
        .catch((err) => {
            alert('Error deleting item: ' + err.message);
        });
    }
}

function handleSaved() {
    window.dispatchEvent(new CustomEvent('datatable-reload'));
}
</script>

<template>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900">Posts (Vue Native Demo)</h1>
                <button @click="handleCreate"
                        class="bg-blue-500 text-white px-5 py-2 rounded shadow hover:bg-blue-600 transition">
                    Add New Post
                </button>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <DataTable
                    :columns="props.columns"
                    ajaxUrl="/posts-data"
                    :perPage="10"
                    :perPageSelect="[10, 25, 50, 100]"
                    @edit="handleEdit"
                    @delete="handleDelete"
                />
            </div>

            <FormModal
                :open="modalOpen"
                :item="editItem"
                createUrl="/posts"
                updateUrlPrefix="/posts"
                @close="modalOpen = false"
                @saved="handleSaved"
            />

            <div class="mt-4 text-sm text-gray-500">
                <p>This page uses native Vue 3 components (DataTable + FormModal) instead of the Blade bridge.</p>
                <p>See <a href="/posts" class="text-blue-600 hover:underline">Posts (Blade Bridge)</a> for the original version.</p>
            </div>
        </div>
    </div>
</template>
