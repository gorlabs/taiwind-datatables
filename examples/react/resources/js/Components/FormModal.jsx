import { useState, useEffect, useCallback } from 'react';
import PropTypes from 'prop-types';

export default function FormModal({ show, post, onClose, onSaved }) {
    const [title, setTitle] = useState('');
    const [content, setContent] = useState('');
    const [isPublished, setIsPublished] = useState(false);
    const [publishedAt, setPublishedAt] = useState('');
    const [isEdit, setIsEdit] = useState(false);
    const [isLoading, setIsLoading] = useState(false);
    const [errors, setErrors] = useState({});

    useEffect(() => {
        if (!show) return;

        if (post) {
            setTitle(post.title || '');
            setContent(post.content || '');
            setIsPublished(!!post.is_published);
            setPublishedAt(
                post.published_at
                    ? new Date(post.published_at).toISOString().slice(0, 16)
                    : ''
            );
            setIsEdit(true);
        } else {
            setTitle('');
            setContent('');
            setIsPublished(false);
            setPublishedAt('');
            setIsEdit(false);
        }
        setErrors({});
    }, [show, post]);

    const handleSubmit = useCallback(async (e) => {
        e.preventDefault();
        setIsLoading(true);
        setErrors({});
        try {
            const url = isEdit ? `/posts/${post.id}` : '/posts';
            const method = isEdit ? 'PUT' : 'POST';

            const payload = {
                title,
                content,
                is_published: isPublished ? 1 : 0,
                published_at: publishedAt || null,
            };

            const response = await fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                body: JSON.stringify(payload),
            });

            const data = await response.json();

            if (response.ok) {
                onSaved();
                onClose();
            } else {
                if (data.errors && typeof data.errors === 'object') {
                    const fieldErrors = {};
                    for (const field in data.errors) {
                        fieldErrors[field] = Array.isArray(data.errors[field])
                            ? data.errors[field][0]
                            : data.errors[field];
                    }
                    setErrors(fieldErrors);
                } else {
                    setErrors({ _general: data.message || 'Bir hata oluştu.' });
                }
            }
        } catch (err) {
            setErrors({ _general: err.message || 'Bir ağ hatası oluştu.' });
        } finally {
            setIsLoading(false);
        }
    }, [isEdit, post, title, content, isPublished, publishedAt, onSaved, onClose]);

    if (!show) return null;

    return (
        <div
            className="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            onKeyDown={(e) => { if (e.key === 'Escape') onClose(); }}
        >
            <div className="bg-white rounded-lg shadow-xl max-w-lg w-full mx-4 p-6" onClick={(e) => e.stopPropagation()}>
                <div className="flex justify-between items-center mb-4">
                    <h2 className="text-xl font-semibold">
                        {isEdit ? 'Edit Post' : 'Create New Post'}
                    </h2>
                    <button
                        onClick={onClose}
                        className="text-gray-400 hover:text-gray-600 text-2xl leading-none"
                    >
                        &times;
                    </button>
                </div>

                {errors._general && (
                    <div className="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                        {errors._general}
                    </div>
                )}

                <form onSubmit={handleSubmit} className="space-y-4">
                    <div>
                        <label className="block text-sm font-medium text-gray-700">Title</label>
                        <input
                            type="text"
                            value={title}
                            onChange={(e) => setTitle(e.target.value)}
                            required
                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200"
                        />
                        {errors.title && (
                            <p className="text-red-500 text-xs mt-1">{errors.title}</p>
                        )}
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-gray-700">Content</label>
                        <textarea
                            value={content}
                            onChange={(e) => setContent(e.target.value)}
                            rows="4"
                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200"
                        />
                        {errors.content && (
                            <p className="text-red-500 text-xs mt-1">{errors.content}</p>
                        )}
                    </div>

                    <div className="flex items-center gap-2">
                        <input
                            type="checkbox"
                            id="is_published"
                            checked={isPublished}
                            onChange={(e) => setIsPublished(e.target.checked)}
                            className="rounded border-gray-300 text-indigo-600 shadow-sm"
                        />
                        <label htmlFor="is_published" className="text-sm text-gray-900">
                            Published?
                        </label>
                    </div>

                    <div>
                        <label className="block text-sm font-medium text-gray-700">
                            Published Date (Optional)
                        </label>
                        <input
                            type="datetime-local"
                            value={publishedAt}
                            onChange={(e) => setPublishedAt(e.target.value)}
                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200"
                        />
                        {errors.published_at && (
                            <p className="text-red-500 text-xs mt-1">{errors.published_at}</p>
                        )}
                    </div>

                    <div className="flex justify-end gap-3">
                        <button
                            type="button"
                            onClick={onClose}
                            className="px-4 py-2 text-sm font-medium rounded-md text-gray-700 bg-gray-200 hover:bg-gray-300"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            disabled={isLoading}
                            className="px-4 py-2 text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50"
                        >
                            {isLoading ? 'Saving...' : 'Save'}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
}

FormModal.propTypes = {
    show: PropTypes.bool.isRequired,
    post: PropTypes.object,
    onClose: PropTypes.func.isRequired,
    onSaved: PropTypes.func.isRequired,
};
