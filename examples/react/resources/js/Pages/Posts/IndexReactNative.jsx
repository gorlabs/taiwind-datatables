import { useState } from 'react';
import { Head } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import DataTable from '@/Components/DataTable';
import FormModal from '@/Components/FormModal';

export default function IndexReactNative({ columns }) {
    const [showModal, setShowModal] = useState(false);
    const [editingPost, setEditingPost] = useState(null);

    function handleCreate() {
        setEditingPost(null);
        setShowModal(true);
    }

    function handleEdit(item) {
        setEditingPost(item);
        setShowModal(true);
    }

    function handleDelete(id) {
        if (confirm('Are you sure you want to delete this item? This action cannot be undone!')) {
            fetch(`/posts/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
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

    function handleClose() {
        setShowModal(false);
        setEditingPost(null);
    }

    return (
        <AuthenticatedLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Posts (React Native Demo)</h2>}
        >
            <Head title="Posts (React Native Demo)" />

            <div className="py-8">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div className="flex justify-between items-center mb-6">
                        <h1 className="text-3xl font-bold text-gray-900">Posts (React Native Demo)</h1>
                        <button
                            onClick={handleCreate}
                            className="bg-blue-500 text-white px-5 py-2 rounded shadow hover:bg-blue-600 transition"
                        >
                            Add New Post
                        </button>
                    </div>

                    <div className="bg-white rounded-lg shadow p-6">
                        <DataTable
                            columns={columns}
                            ajaxUrl="/posts-data"
                            perPage={10}
                            perPageSelect={[10, 25, 50, 100]}
                            onEdit={handleEdit}
                            onDelete={handleDelete}
                        />
                    </div>

                    <FormModal
                        show={showModal}
                        post={editingPost}
                        onClose={handleClose}
                        onSaved={handleSaved}
                    />

                    <div className="mt-4 text-sm text-gray-500">
                        <p>
                            This page uses native React (Inertia) components (DataTable + FormModal) instead of the Blade bridge.
                        </p>
                        <p>
                            See{' '}
                            <a href="/posts" className="text-blue-600 hover:underline">
                                Posts (Blade Bridge)
                            </a>{' '}
                            for the original version.
                        </p>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
