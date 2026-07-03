import { useState, useEffect, useCallback } from 'react';

export default function DataTable({ ajaxUrl, columns, perPage: initialPerPage = 10, perPageSelect = [10, 25, 50, 100], onEdit, onDelete }) {
    const [data, setData] = useState([]);
    const [total, setTotal] = useState(0);
    const [currentPage, setCurrentPage] = useState(1);
    const [perPage, setPerPage] = useState(initialPerPage);
    const [searchQuery, setSearchQuery] = useState('');
    const [sortColumn, setSortColumn] = useState('');
    const [sortDirection, setSortDirection] = useState('asc');
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState('');

    const totalPages = Math.ceil(total / perPage);

    const fetchData = useCallback(async () => {
        setLoading(true);
        setError('');
        try {
            const params = new URLSearchParams();
            params.set('draw', '1');
            params.set('start', String((currentPage - 1) * perPage));
            params.set('length', String(perPage));
            columns.forEach((col, i) => {
                params.set(`columns[${i}][data]`, col.data);
                params.set(`columns[${i}][name]`, col.name);
                params.set(`columns[${i}][searchable]`, String(col.searchable));
                params.set(`columns[${i}][orderable]`, String(col.orderable));
            });
            if (sortColumn) {
                params.set('order[0][column]', String(columns.findIndex(c => c.data === sortColumn)));
                params.set('order[0][dir]', sortDirection);
            }
            params.set('search[value]', searchQuery);
            params.set('search[regex]', 'false');

            const response = await fetch(`${ajaxUrl}?${params.toString()}`, {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Accept': 'application/json',
                },
            });
            const json = await response.json();
            setData(json.data);
            setTotal(json.recordsTotal);
        } catch (err) {
            setError(err?.response?.data?.message || err.message || 'Veri yüklenirken bir hata oluştu.');
        } finally {
            setLoading(false);
        }
    }, [ajaxUrl, columns, currentPage, perPage, searchQuery, sortColumn, sortDirection]);

    useEffect(() => {
        fetchData();
    }, [fetchData]);

    // Listen for datatable-reload custom event (dispatched by parent after CRUD operations)
    useEffect(() => {
        function handleReload() {
            fetchData();
        }
        window.addEventListener('datatable-reload', handleReload);
        return () => window.removeEventListener('datatable-reload', handleReload);
    }, [fetchData]);

    function handleSort(colName) {
        if (sortColumn === colName) {
            setSortDirection(prev => prev === 'asc' ? 'desc' : 'asc');
        } else {
            setSortColumn(colName);
            setSortDirection('asc');
        }
    }

    function handlePerPageChange(e) {
        const val = parseInt(e.target.value, 10);
        setPerPage(val);
        setCurrentPage(1);
    }

    return (
        <div className="space-y-4">
            {/* Search */}
            <div className="flex justify-between items-center">
                <div className="flex items-center gap-2">
                    <label className="text-sm text-gray-600">Show</label>
                    <select
                        value={perPage}
                        onChange={handlePerPageChange}
                        className="border rounded px-2 py-1 text-sm"
                    >
                        {perPageSelect.map(opt => (
                            <option key={opt} value={opt}>{opt}</option>
                        ))}
                        <option value="-1">All</option>
                    </select>
                    <label className="text-sm text-gray-600">entries</label>
                </div>
                <div className="flex items-center gap-2">
                    <label className="text-sm text-gray-600">Search:</label>
                    <input
                        value={searchQuery}
                        onChange={e => setSearchQuery(e.target.value)}
                        type="text"
                        className="border rounded px-2 py-1 text-sm"
                        placeholder="Search..."
                    />
                </div>
            </div>

            {/* Error */}
            {error && (
                <div className="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {error}
                </div>
            )}

            {/* Table */}
            <div className="overflow-x-auto border rounded">
                <table className="min-w-full divide-y divide-gray-200">
                    <thead className="bg-gray-50">
                        <tr>
                            {columns.map(col => (
                                <th
                                    key={col.name}
                                    className={`px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer ${col.className || ''}`}
                                    onClick={() => col.orderable && handleSort(col.name)}
                                >
                                    <span className="flex items-center gap-1">
                                        <span dangerouslySetInnerHTML={{ __html: col.title }} />
                                        {sortColumn === col.name && (
                                            <span className="text-xs">{sortDirection === 'asc' ? '↑' : '↓'}</span>
                                        )}
                                    </span>
                                </th>
                            ))}
                        </tr>
                    </thead>
                    <tbody className="bg-white divide-y divide-gray-200">
                        {loading ? (
                            <tr>
                                <td colSpan={columns.length} className="px-4 py-8 text-center text-gray-500">
                                    <span className="inline-block animate-pulse">Loading...</span>
                                </td>
                            </tr>
                        ) : data.length === 0 ? (
                            <tr>
                                <td colSpan={columns.length} className="px-4 py-8 text-center text-gray-500">
                                    No data available in table
                                </td>
                            </tr>
                        ) : (
                            data.map((row, idx) => (
                                <tr key={row.id || idx} className="hover:bg-gray-50">
                                    {columns.map(col => {
                                        let content = null;

                                        if (col.name === 'select_checkbox') {
                                            content = (
                                                <input type="checkbox" className="rounded border-gray-300" />
                                            );
                                        } else if (col.name === 'id') {
                                            content = row.id;
                                        } else if (col.name === 'published_at') {
                                            content = row.published_at ? new Date(row.published_at).toLocaleString() : '-';
                                        } else if (col.name === 'is_published' || col.name === 'status') {
                                            content = (
                                                <span
                                                    className={`px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${
                                                        row.is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'
                                                    }`}
                                                >
                                                    {row.is_published ? 'Published' : 'Draft'}
                                                </span>
                                            );
                                        } else if (col.name === 'actions') {
                                            content = (
                                                <div className="flex gap-2">
                                                    <button
                                                        onClick={() => onEdit && onEdit(row)}
                                                        className="px-3 py-1.5 text-sm font-medium rounded shadow-sm text-white bg-blue-600 hover:bg-blue-700"
                                                    >
                                                        Edit
                                                    </button>
                                                    <button
                                                        onClick={() => onDelete && onDelete(row.id)}
                                                        className="px-3 py-1.5 text-sm font-medium rounded shadow-sm text-white bg-red-600 hover:bg-red-700"
                                                    >
                                                        Delete
                                                    </button>
                                                </div>
                                            );
                                        } else {
                                            content = row[col.name];
                                        }

                                        return (
                                            <td key={col.name} className="px-4 py-2 text-sm text-gray-900">
                                                {content}
                                            </td>
                                        );
                                    })}
                                </tr>
                            ))
                        )}
                    </tbody>
                </table>
            </div>

            {/* Pagination */}
            <div className="flex justify-between items-center text-sm text-gray-600">
                <div>
                    Showing {((currentPage - 1) * perPage) + 1} to{' '}
                    {Math.min(currentPage * perPage, total)} of {total} entries
                </div>
                <div className="flex gap-2">
                    <button
                        disabled={currentPage <= 1}
                        onClick={() => setCurrentPage(prev => prev - 1)}
                        className="px-3 py-1 border rounded disabled:opacity-50 hover:bg-gray-100"
                    >
                        Previous
                    </button>
                    <span className="px-3 py-1">Page {currentPage} of {totalPages}</span>
                    <button
                        disabled={currentPage >= totalPages}
                        onClick={() => setCurrentPage(prev => prev + 1)}
                        className="px-3 py-1 border rounded disabled:opacity-50 hover:bg-gray-100"
                    >
                        Next
                    </button>
                </div>
            </div>
        </div>
    );
}
