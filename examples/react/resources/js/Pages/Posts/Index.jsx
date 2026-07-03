import { useEffect, useRef } from 'react';
import { Head } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';

export default function Index({ columns }) {
    const dataTableRef = useRef(null);
    const dataTableInstance = useRef(null);

    const datatableConfig = {
        datatableId: 'posts-table',
        ajaxUrl: route('posts.data'),
        columns: columns,
        perPage: 10,
        perPageSelect: [10, 25, 50, 100, -1],
        addNewButtonText: 'Add New Post',
        addEditUrl: route('posts.create'),
        updateUrlPrefix: route('posts.update', ''),
        deleteUrlPrefix: route('posts.destroy', ''),
        initialFormState: {},
        responsive: true,
    };

    useEffect(() => {
        const $ = window.$;

        if (typeof $ === 'undefined' || typeof $.fn.DataTable === 'undefined') {
            console.error('jQuery or DataTables is not available globally.');
            return;
        }

        if (typeof window.GorlabsDatatables === 'undefined') {
            console.error('GorlabsDatatables is not available globally.');
            return;
        }

        dataTableInstance.current = $(`#${datatableConfig.datatableId}`).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: datatableConfig.ajaxUrl,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                },
                dataSrc: function (json) {
                    return json.data || json;
                },
                error: function (xhr, error, thrown) {
                    console.error('Ajax Error:', xhr.responseText, error, thrown);
                    if (typeof window.Swal !== 'undefined') {
                        window.Swal.fire('Hata!', 'Veri yüklenirken bir sorun oluştu.', 'error');
                    } else {
                        alert('Hata! Veri yüklenirken bir sorun oluştu.');
                    }
                },
            },
            columns: datatableConfig.columns.map((col) => {
                const dtCol = {
                    data: col.data,
                    name: col.name,
                    title: col.title,
                    orderable: col.orderable,
                    searchable: col.searchable,
                    className: col.className || '',
                };

                if (col.name === 'select_checkbox') {
                    dtCol.render = function (data, type, row) {
                        return `<input type="checkbox" class="form-checkbox" value="${row.id || ''}">`;
                    };
                    dtCol.className = 'select-checkbox';
                    dtCol.orderable = false;
                    dtCol.searchable = false;
                    dtCol.data = null;
                } else if (col.name === 'published_at') {
                    dtCol.render = window.GorlabsDatatables.date('YYYY-MM-DD HH:mm');
                } else if (col.name === 'is_published') {
                    dtCol.render = window.GorlabsDatatables.statusBadge('Yayınlandı', 'Taslak');
                } else if (col.name === 'status') {
                    dtCol.render = window.GorlabsDatatables.statusBadge('Yayınlandı', 'Taslak');
                } else if (col.name === 'actions') {
                    dtCol.data = null;
                    dtCol.defaultContent = '';
                    dtCol.orderable = false;
                    dtCol.searchable = false;
                    dtCol.render = window.GorlabsDatatables.actions(
                        datatableConfig.updateUrlPrefix,
                        datatableConfig.deleteUrlPrefix
                    );
                }

                return dtCol;
            }),
            order: [[1, 'desc']],
            pageLength: datatableConfig.perPage,
            lengthMenu: datatableConfig.perPageSelect,
            responsive: datatableConfig.responsive,
            dom: '<"flex flex-col sm:flex-row justify-between items-center mb-4"lfB><"overflow-x-auto"rt><"flex flex-col sm:flex-row justify-between items-center mt-4"ip>',
            buttons: [
                'copy',
                'excel',
                'csv',
                'pdf',
                'print',
                {
                    text: datatableConfig.addNewButtonText,
                    className: 'bg-blue-500 text-white px-5 py-2 rounded shadow hover:bg-blue-600 transition',
                    attr: {
                        'data-dusk': 'add-new-post-button',
                    },
                    action: () => {
                        window.openFormModal(datatableConfig.addNewButtonText, datatableConfig.addEditUrl, null);
                    },
                },
            ],
            initComplete: function (_settings, _json) {
                $(this.api().table().node()).css('visibility', 'visible');
            },
        });

        // DataTables yeniden yükleme olayını dinle
        function handleDataTableReload() {
            if (dataTableInstance.current) {
                dataTableInstance.current.ajax.reload(null, false);
            }
        }
        window.addEventListener('datatable-reload', handleDataTableReload);

        // Alpine.js global modal olaylarını dinle
        function handleEditItem(event) {
            const item = event.detail;
            const url = route('posts.edit', { post: item.id });
            const title = `Edit Post: ${item.title || item.id}`;
            window.openFormModal(title, url, item);
        }
        document.addEventListener('edit-item', handleEditItem);

        function handleDeleteItem(event) {
            const itemId = event.detail.id;
            if (typeof window.Swal !== 'undefined') {
                window.Swal.fire({
                    title: 'Emin misiniz?',
                    text: 'Bu öğeyi silmek istediğinize emin misiniz? Bu işlem geri alınamaz!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, Delete!',
                    cancelButtonText: 'Exit',
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        try {
                            const url = route('posts.destroy', { post: itemId });
                            const response = await fetch(url, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                                    Accept: 'application/json',
                                    'Content-Type': 'application/json',
                                },
                            });

                            if (!response.ok) {
                                const errorData = await response.json();
                                throw new Error(errorData.message || `Silme işlemi başarısız oldu. HTTP Status: ${response.status}`);
                            }

                            const data = await response.json();
                            window.Swal.fire('Silindi!', data.success, 'success');

                            if (dataTableInstance.current) {
                                dataTableInstance.current.ajax.reload(null, false);
                            }
                        } catch (error) {
                            console.error('Silme işlemi sırasında hata:', error);
                            window.Swal.fire('Hata!', error.message || 'Silme işlemi sırasında bilinmeyen bir hata oluştu.', 'error');
                        }
                    }
                });
            } else {
                console.warn('SweetAlert2 (Swal) tanımlı değil. Silme onayı işlevi eksik.');
            }
        }
        document.addEventListener('delete-item', handleDeleteItem);

        return () => {
            window.removeEventListener('datatable-reload', handleDataTableReload);
            document.removeEventListener('edit-item', handleEditItem);
            document.removeEventListener('delete-item', handleDeleteItem);
            if (dataTableInstance.current) {
                dataTableInstance.current.destroy(true);
                dataTableInstance.current = null;
            }
        };
    }, []);

    return (
        <AuthenticatedLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Posts</h2>}
        >
            <Head title="Posts" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-1 lg:px-1">
                    <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div className="p-3 text-gray-900">
                            <div className="test-red-background">Bu bir test.</div>
                            <h2 className="mb-4 text-2xl text-xl font-semibold leading-tight text-gray-800">Posts Listesi</h2>
                            <div ref={dataTableRef}>
                                <table id="posts-table" className="min-w-full divide-y divide-gray-200" style={{ width: '100%' }}>
                                    <thead className="bg-gray-50">
                                    <tr>
                                        {datatableConfig.columns.map((column) => (
                                            <th
                                                key={column.name}
                                                scope="col"
                                                className="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                                                dangerouslySetInnerHTML={{ __html: column.title }}
                                            />
                                        ))}
                                    </tr>
                                    </thead>
                                    <tbody className="divide-y divide-gray-200 bg-white">
                                    {/* DataTables ajax ile doldurulacak */}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {/* Paketten gelen modal şablonu — Alpine.js x-data="globalModal()" — spread syntax ile */}
                <div
                    {...{
                        'x-data': 'globalModal()',
                        'x-show': 'open',
                        'x-transition:enter': 'transition ease-out duration-300',
                        'x-transition:enter-start': 'opacity-0',
                        'x-transition:enter-end': 'opacity-100',
                        'x-transition:leave': 'transition ease-in duration-200',
                        'x-transition:leave-start': 'opacity-100',
                        'x-transition:leave-end': 'opacity-0',
                        '@keydown.escape.window': 'closeModal',
                    }}
                    className="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                >
                    <div
                        {...{
                            '@click.away': 'closeModal',
                        }}
                        className="relative max-h-full w-full max-w-4xl overflow-auto rounded-lg bg-white p-6 shadow-lg"
                    >
                        <h2 className="mb-4 text-xl font-semibold" {...{ 'x-text': 'title' }}></h2>

                        <div id="modal-content"></div>

                        <button
                            {...{
                                '@click': 'closeModal',
                            }}
                            className="absolute right-4 top-4 text-gray-500 hover:text-gray-700"
                            aria-label="Close modal"
                        >
                            {/* &times; */}
                        </button>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
