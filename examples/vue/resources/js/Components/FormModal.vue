<script setup lang="ts">
import { ref, watch } from 'vue';

const props = defineProps<{
    open: boolean;
    item: any | null;
    createUrl: string;
    updateUrlPrefix: string;
}>();

const emit = defineEmits<{
    (e: 'close'): void;
    (e: 'saved'): void;
}>();

const formData = ref({
    id: null as number | null,
    title: '',
    content: '',
    is_published: false,
    published_at: '',
});
const isEdit = ref(false);
const isLoading = ref(false);
const error = ref('');

watch(() => props.open, (val) => {
    if (val) {
        if (props.item) {
            formData.value = {
                id: props.item.id,
                title: props.item.title || '',
                content: props.item.content || '',
                is_published: !!props.item.is_published,
                published_at: props.item.published_at
                    ? new Date(props.item.published_at).toISOString().slice(0, 16)
                    : '',
            };
            isEdit.value = true;
        } else {
            formData.value = { id: null, title: '', content: '', is_published: false, published_at: '' };
            isEdit.value = false;
        }
        error.value = '';
    }
});

async function submitForm() {
    isLoading.value = true;
    error.value = '';
    try {
        const url = isEdit.value ? `${props.updateUrlPrefix}/${formData.value.id}` : props.createUrl;
        const method = isEdit.value ? 'PUT' : 'POST';

        const payload = {
            ...formData.value,
            is_published: formData.value.is_published ? 1 : 0,
            published_at: formData.value.published_at || null,
        };

        const response = await fetch(url, {
            method,
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement)?.content || '',
            },
            body: JSON.stringify(payload),
        });

        const data = await response.json();

        if (response.ok) {
            emit('saved');
            emit('close');
        } else {
            error.value = data.message || 'Bir hata oluştu.';
        }
    } catch (err: any) {
        error.value = err.message || 'Bir ağ hatası oluştu.';
    } finally {
        isLoading.value = false;
    }
}
</script>

<template>
    <div v-if="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
         @keydown.escape="emit('close')">
        <div class="bg-white rounded-lg shadow-xl max-w-lg w-full mx-4 p-6" @click.stop>
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">{{ isEdit ? 'Edit Post' : 'Create New Post' }}</h2>
                <button @click="emit('close')" class="text-gray-400 hover:text-gray-600">&times;</button>
            </div>

            <div v-if="error" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ error }}
            </div>

            <form @submit.prevent="submitForm" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <input v-model="formData.title" type="text" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Content</label>
                    <textarea v-model="formData.content" rows="4"
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200"></textarea>
                </div>

                <div class="flex items-center gap-2">
                    <input v-model="formData.is_published" type="checkbox" id="is_published"
                           class="rounded border-gray-300 text-indigo-600 shadow-sm">
                    <label for="is_published" class="text-sm text-gray-900">Published?</label>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Published Date (Optional)</label>
                    <input v-model="formData.published_at" type="datetime-local"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200">
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" @click="emit('close')"
                            class="px-4 py-2 text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit" :disabled="isLoading"
                            class="px-4 py-2 text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50">
                        <span v-if="isLoading">Saving...</span>
                        <span v-else>Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
