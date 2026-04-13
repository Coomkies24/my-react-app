import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, usePage, useForm, router } from '@inertiajs/react';
import { useState } from 'react';

export default function Index({ books, categories }) {
    // 1. Get auth user
    const { auth } = usePage().props;
    const isAdmin = auth.user.role === 'admin';

    // State to track which book is being edited
    const [editingId, setEditingId] = useState(null);

    // 2. Setup useForm for Creating a Book
    const { data: createData, setData: setCreateData, post, reset, errors: createErrors } = useForm({
        title: '',
        category_id: ''
    });

    // Setup useForm for Updating a Book
    const { data: editData, setData: setEditData, put, reset: resetEdit } = useForm({
        title: '',
        category_id: ''
    });

    // --- CRUD ACTIONS ---

    // CREATE
    const handleCreate = (e) => {
        e.preventDefault();
        post(route('books.store'), {
            onSuccess: () => reset() // Clear form on success
        });
    };

    // UPDATE
    const startEdit = (book) => {
        setEditingId(book.id);
        setEditData({ title: book.title, category_id: book.category_id });
    };

    const handleUpdate = (e, id) => {
        e.preventDefault();
        put(route('books.update', id), {
            onSuccess: () => setEditingId(null) // Close edit mode on success
        });
    };

    // DELETE
    const handleDelete = (id) => {
        if (confirm('Are you sure you want to delete this book?')) {
            router.delete(route('books.destroy', id));
        }
    };

    return (
        <AuthenticatedLayout
            header={<h2 className="text-xl font-semibold leading-tight text-gray-800">Library Books</h2>}
        >
            <Head title="Books" />

            <div className="py-12">
                <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    
                    {/* READ / UPDATE / DELETE TABLE */}
                    <div className="mb-8 overflow-hidden bg-white p-6 shadow-sm sm:rounded-lg">
                        <h3 className="text-lg font-bold mb-4">Book List</h3>
                        <table className="w-full text-left border-collapse">
                            <thead>
                                <tr>
                                    <th className="border-b p-4">Book Title</th>
                                    <th className="border-b p-4">Category</th>
                                    <th className="border-b p-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                {books.map((book) => (
                                    <tr key={book.id}>
                                        {/* If this row is being edited... */}
                                        {editingId === book.id ? (
                                            <>
                                                <td className="border-b p-4">
                                                    <input 
                                                        type="text" 
                                                        value={editData.title} 
                                                        onChange={e => setEditData('title', e.target.value)} 
                                                        className="border rounded p-1 w-full"
                                                    />
                                                </td>
                                                <td className="border-b p-4">
                                                    <select 
                                                        value={editData.category_id} 
                                                        onChange={e => setEditData('category_id', e.target.value)} 
                                                        className="border rounded p-1 w-full"
                                                    >
                                                        {categories.map(cat => (
                                                            <option key={cat.id} value={cat.id}>{cat.name}</option>
                                                        ))}
                                                    </select>
                                                </td>
                                                <td className="border-b p-4 space-x-2">
                                                    <button onClick={(e) => handleUpdate(e, book.id)} className="text-green-600 font-bold hover:underline">Save</button>
                                                    <button onClick={() => setEditingId(null)} className="text-gray-600 hover:underline">Cancel</button>
                                                </td>
                                            </>
                                        ) : (
                                            /* Normal Display Mode */
                                            <>
                                                <td className="border-b p-4">{book.title}</td>
                                                <td className="border-b p-4">
                                                    <span className="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                                        {book.category?.name || 'Uncategorized'}
                                                    </span>
                                                </td>
                                                <td className="border-b p-4">
                                                    {/* TASK 3: UI RULES - Hide actions from regular users */}
                                                    {isAdmin ? (
                                                        <div className="flex space-x-3">
                                                            <button onClick={() => startEdit(book)} className="text-indigo-600 hover:underline">Edit</button>
                                                            <button onClick={() => handleDelete(book.id)} className="text-red-600 hover:underline">Delete</button>
                                                        </div>
                                                    ) : (
                                                        <span className="text-gray-400 italic text-sm">View Only</span>
                                                    )}
                                                </td>
                                            </>
                                        )}
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>

                    {/* CREATE FORM - Only Admins can see this */}
                    {isAdmin && (
                        <div className="overflow-hidden bg-gray-50 p-6 shadow-sm sm:rounded-lg border border-gray-200">
                            <h3 className="text-lg font-bold mb-4">Add New Book</h3>
                            <form onSubmit={handleCreate} className="flex gap-4 items-start">
                                <div className="flex-1">
                                    <input 
                                        type="text" 
                                        placeholder="Book Title" 
                                        value={createData.title} 
                                        onChange={e => setCreateData('title', e.target.value)}
                                        className="w-full border-gray-300 rounded shadow-sm"
                                    />
                                    {createErrors.title && <div className="text-red-600 text-sm mt-1">{createErrors.title}</div>}
                                </div>
                                
                                <div className="flex-1">
                                    <select 
                                        value={createData.category_id} 
                                        onChange={e => setCreateData('category_id', e.target.value)}
                                        className="w-full border-gray-300 rounded shadow-sm"
                                    >
                                        <option value="">Select a Category...</option>
                                        {categories.map(cat => (
                                            <option key={cat.id} value={cat.id}>{cat.name}</option>
                                        ))}
                                    </select>
                                    {createErrors.category_id && <div className="text-red-600 text-sm mt-1">{createErrors.category_id}</div>}
                                </div>

                                <button type="submit" className="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700">
                                    Create Book
                                </button>
                            </form>
                        </div>
                    )}

                </div>
            </div>
        </AuthenticatedLayout>
    );
}