@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-50">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Job Tracker</h1>
                <p class="mt-1 text-gray-500">Manage and track your job applications.</p>
            </div>
            <button onclick="openAddModal()"
                class="cursor-pointer inline-flex items-center justify-center rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                + Application
            </button>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
        <div id="success-message"
            class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 transition-opacity duration-500">
            {{ session('success') }}
        </div>
        @endif

        {{-- Statistics --}}
        @include('job-applications._stats')

        {{-- Search & Filters --}}
        <div class="mb-6 rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <form id="filter-form" method="GET" action="/" class="grid grid-cols-1 gap-4 md:grid-cols-3">
                {{-- Search --}}
                <div class="md:col-span-1">
                    <label class="mb-2 block text-sm font-semibold text-gray-700">Search</label>
                    <div class="relative">
                        <input id="search-input" type="text" name="search" value="{{ request('search') }}"
                            placeholder="Company or position..."
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 pr-10 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                        <div id="search-spinner" class="pointer-events-none absolute right-3 top-1/2 hidden -translate-y-1/2">
                            <svg class="h-4 w-4 animate-spin text-indigo-500" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700">Status</label>
                    <select id="status-filter" name="status"
                        class="cursor-pointer w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                        <option value="">All</option>
                        <option value="Applied" {{ request('status') == 'Applied' ? 'selected' : '' }}>Applied</option>
                        <option value="Interview" {{ request('status') == 'Interview' ? 'selected' : '' }}>Interview</option>
                        <option value="Accepted" {{ request('status') == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                {{-- Date --}}
                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700">Application Date</label>
                    <div class="flex items-center gap-2">
                        <div class="relative flex-1">
                            <input type="text" id="date-filter" name="date-filter" placeholder="Day/Month/Year"
                                value="{{ request('date-filter') }}"
                                class="date-picker cursor-pointer w-full rounded-lg border border-gray-300 px-4 py-3 pr-10 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                            <svg class="pointer-events-none absolute right-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <button type="button" id="reset-btn"
                            class="cursor-pointer shrink-0 rounded-lg border border-gray-300 px-4 py-3 text-sm text-gray-600 hover:bg-gray-50">
                            Reset
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Applications Table --}}
        @include('job-applications._table')
    </div>
</div>

{{-- MODALS --}}
{{-- Add Modal --}}
<div id="add-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4">
    <div class="w-full max-w-lg rounded-xl bg-white shadow-xl">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <div>
                <h2 class="text-lg font-bold text-gray-900">Add an Application</h2>
                <p class="text-sm text-gray-500">Add a new job application.</p>
            </div>
            <button onclick="closeAddModal()" class="cursor-pointer text-2xl text-gray-400 hover:text-gray-600">&times;</button>
        </div>
        <form action="/jobs" method="POST">
            @csrf
            <div class="space-y-5 p-6">
                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700">Company</label>
                    <input type="text" name="company" required placeholder="Contoh: Google"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700">Position</label>
                    <input type="text" name="position" required placeholder="Contoh: Junior Web Developer"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700">Status</label>
                    <select name="status" required
                        class="cursor-pointer w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                        <option value="Applied">Applied</option>
                        <option value="Interview">Interview</option>
                        <option value="Accepted">Accepted</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700">Application Date</label>
                    <div class="relative w-fit">
                        <input type="text" id="applied_at" name="applied_at" placeholder="Day/Month/Year"
                            class="date-picker cursor-pointer w-fit rounded-lg border border-gray-300 px-4 py-3 pr-10 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                        <svg class="pointer-events-none absolute right-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <label class="mb-2 block text-sm font-semibold text-gray-700">Notes</label>
                    <textarea name="notes" rows="3" placeholder="Additional notes..."
                        class="w-full resize-none rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"></textarea>
                </div>
            </div>
            <div class="flex justify-end gap-3 border-t border-gray-200 px-6 py-4">
                <button type="button" onclick="closeAddModal()"
                    class="cursor-pointer rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-100">
                    Cancel
                </button>
                <button type="submit"
                    class="cursor-pointer rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Modal --}}
<div id="edit-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-900">Edit Application</h2>
            <button type="button" onclick="closeEditModal()" class="cursor-pointer text-gray-400 hover:text-gray-600">✕</button>
        </div>
        <form id="edit-form" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Company</label>
                    <input type="text" id="edit-company" name="company" required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Position</label>
                    <input type="text" id="edit-position" name="position" required
                        class="w-full rounded-lg border border-gray-300 px-3 py-2">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Status</label>
                    <select id="edit-status" name="status" required
                        class="cursor-pointer w-full rounded-lg border border-gray-300 px-3 py-2">
                        <option value="Applied">Applied</option>
                        <option value="Interview">Interview</option>
                        <option value="Accepted">Accepted</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Application Date</label>
                    <div class="relative w-fit">
                        <input type="text" id="edit-applied-at" name="applied_at" placeholder="Day/Month/Year"
                            class="date-picker cursor-pointer w-fit rounded-lg border border-gray-300 px-4 py-3 pr-10 text-sm outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                        <svg class="pointer-events-none absolute right-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-medium text-gray-700">Notes</label>
                    <textarea id="edit-notes" name="notes" rows="4"
                        class="w-full rounded-lg border border-gray-300 px-3 py-2"></textarea>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" onclick="closeEditModal()"
                    class="cursor-pointer rounded-lg border border-gray-300 px-4 py-2 text-sm">Cancel</button>
                <button type="submit"
                    class="cursor-pointer rounded-lg bg-gray-900 px-4 py-2 text-sm text-white">Save Update</button>
            </div>
        </form>
    </div>
</div>

{{-- Delete Modal --}}
<div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl">
        <div class="mb-4">
            <h2 class="text-xl font-semibold text-gray-900">Delete the application</h2>
            <p class="mt-2 text-sm text-gray-600">
                Are you sure you want to delete your application
                <span id="delete-company" class="font-semibold text-gray-900"></span>?
            </p>
        </div>
        <form id="delete-form" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeDeleteModal()"
                    class="cursor-pointer rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-700">Cancel</button>
                <button type="submit"
                    class="cursor-pointer rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">Delete</button>
            </div>
        </form>
    </div>
</div>

{{-- Detail Modal --}}
<div id="detail-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 p-4">
    <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl">
        <div class="mb-6 flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-900">Application Detail</h2>
            <button type="button" onclick="closeDetailModal()" class="cursor-pointer text-gray-400 hover:text-gray-600">✕</button>
        </div>

        <div id="detail-loading" class="py-8 text-center">
            <svg class="mx-auto h-6 w-6 animate-spin text-indigo-500" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
            </svg>
            <p class="mt-2 text-sm text-gray-500">Loading...</p>
        </div>

        <div id="detail-content" class="hidden space-y-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Company</p>
                <p id="detail-company" class="mt-1 text-sm text-gray-900"></p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Position</p>
                <p id="detail-position" class="mt-1 text-sm text-gray-900"></p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Status</p>
                <p id="detail-status" class="mt-1"></p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Application Date</p>
                <p id="detail-applied-at" class="mt-1 text-sm text-gray-900"></p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Notes</p>
                <p id="detail-notes" class="mt-1 whitespace-pre-line text-sm text-gray-700"></p>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-gray-500">Created At</p>
                <p id="detail-created-at" class="mt-1 text-sm text-gray-700"></p>
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-3">
            <button type="button" onclick="closeDetailModal()"
                class="cursor-pointer rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                Close
            </button>
        </div>
    </div>
</div>
                                        
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        'use strict';
        // ELEMENT REFERENCES & STATE
        const filterForm = document.getElementById('filter-form');
        const searchInput = document.getElementById('search-input');
        const statusFilter = document.getElementById('status-filter');
        const dateFilter = document.getElementById('date-filter');
        const resetBtn = document.getElementById('reset-btn');
        const spinner = document.getElementById('search-spinner');
        const deleteForm = document.getElementById('delete-form');
        const editForm = document.getElementById('edit-form');
        const addForm = document.querySelector('#add-modal form');

        let currentSort = new URLSearchParams(window.location.search).get('sort') || 'created_at';
        let currentOrder = new URLSearchParams(window.location.search).get('order') || 'desc';
        let searchTimeout;

        // Flatpickr instances (di-assign setelah init)
        let datePicker, editDatePicker, appliedAtPicker;

        // UTILITIES
        // Tampilkan toast notification
        function showToast(message, type = 'success') {
            const cls = type === 'success' ?
                'bg-green-50 border border-green-200 text-green-700' :
                'bg-red-50 border border-red-200 text-red-700';

            const toast = document.createElement('div');
            toast.className = `fixed top-5 right-5 z-[100] rounded-lg px-4 py-3 text-sm shadow-lg transition-opacity duration-300 ${cls}`;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // Auto-hide success message
        (function initSuccessMessage() {
            const msg = document.getElementById('success-message');
            if (!msg) return;

            setTimeout(() => {
                msg.style.opacity = '0';
                setTimeout(() => msg.remove(), 500);
            }, 3000);
        })();

        // MODAL HELPERS
        function openModal(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.remove('hidden');
            el.classList.add('flex');
        }

        function closeModal(id) {
            const el = document.getElementById(id);
            if (!el) return;
            el.classList.add('hidden');
            el.classList.remove('flex');
        }

        // Expose ke global (dipakai inline onclick di HTML)
        window.openAddModal = () => openModal('add-modal');
        window.closeAddModal = () => closeModal('add-modal');
        window.closeEditModal = () => closeModal('edit-modal');
        window.closeDeleteModal = () => closeModal('delete-modal');
        window.closeDetailModal = () => closeModal('detail-modal');

        // FLATPICKR INIT
        flatpickr('.date-picker', {
            dateFormat: 'Y-m-d',
            altInput: true,
            altFormat: 'd F Y',
            maxDate: 'today',
            position: 'auto center',
            onChange: function(selectedDates, dateStr, instance) {
                // Khusus filter tanggal → trigger AJAX
                if (instance.element.id === 'date-filter') {
                    loadTable({
                        page: 1
                    }, true);
                }
            }
        });

        datePicker = document.getElementById('date-filter')?._flatpickr;
        editDatePicker = document.getElementById('edit-applied-at')?._flatpickr;
        appliedAtPicker = document.getElementById('applied_at')?._flatpickr;

        // CORE: AJAX LOAD TABLE (table + stats)
        // Bangun query string dari state filter saat ini
        function buildParams(extra = {}) {
            const params = new URLSearchParams();
            if (searchInput.value.trim()) params.set('search', searchInput.value.trim());
            if (statusFilter.value) params.set('status', statusFilter.value);
            if (dateFilter.value) params.set('date-filter', dateFilter.value);
            params.set('sort', currentSort);
            params.set('order', currentOrder);
            params.set('ajax', '1');
            Object.entries(extra).forEach(([k, v]) => params.set(k, v));
            return params;
        }

        // Replace #table-wrapper & #stats-wrapper dari HTML hasil fetch
        function applyPartial(doc) {
            const newTable = doc.getElementById('table-wrapper');
            const oldTable = document.getElementById('table-wrapper');
            if (newTable && oldTable) oldTable.replaceWith(newTable);

            const newStats = doc.getElementById('stats-wrapper');
            const oldStats = document.getElementById('stats-wrapper');
            if (newStats && oldStats) oldStats.replaceWith(newStats);
        }

        // Re-bind semua event ke elemen yang baru di-replace
        function rebindAll() {
            bindSortEvents();
            bindRowActions();
            bindPagination();
            bindDetailRow();
        }

        // Fungsi utama: fetch ulang table + stats
        async function loadTable(extraParams = {}, showSpinner = false) {
            if (showSpinner && spinner) spinner.classList.remove('hidden');

            const url = filterForm.action + '?' + buildParams(extraParams).toString();

            try {
                const res = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    },
                });
                if (!res.ok) throw new Error('Request failed');

                const html = await res.text();
                const doc = new DOMParser().parseFromString(html, 'text/html');
                applyPartial(doc);

                history.pushState({}, '', url);
                rebindAll();
            } catch (err) {
                console.error('AJAX error:', err);
            } finally {
                if (spinner) spinner.classList.add('hidden');
            }
        }

        // Fetch dari URL lengkap (dipakai pagination)
        async function loadTableFromUrl(url) {
            if (spinner) spinner.classList.remove('hidden');
            try {
                const res = await fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    },
                });
                if (!res.ok) throw new Error('Request failed');

                const html = await res.text();
                const doc = new DOMParser().parseFromString(html, 'text/html');
                applyPartial(doc);

                document.getElementById('table-wrapper')?.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });

                history.pushState({}, '', url);
                rebindAll();
            } catch (err) {
                console.error('AJAX pagination error:', err);
            } finally {
                if (spinner) spinner.classList.add('hidden');
            }
        }

        // EVENT BINDINGS (dipanggil ulang tiap partial replace)
        // Sort header → server-side sort
        function bindSortEvents() {
            document.querySelectorAll('#table-wrapper .sort-header').forEach(th => {
                th.addEventListener('click', function() {
                    const sort = this.dataset.sort;
                    if (currentSort === sort) {
                        currentOrder = currentOrder === 'asc' ? 'desc' : 'asc';
                    } else {
                        currentSort = sort;
                        currentOrder = 'asc';
                    }
                    loadTable({
                        sort: currentSort,
                        order: currentOrder,
                        page: 1
                    }, false);
                });
            });
        }

        // Klik row → detail modal
        function bindDetailRow() {
            document.querySelectorAll('#table-wrapper .detail-row').forEach(row => {
                row.addEventListener('click', function(e) {
                    // Skip kalau yang diklik tombol Edit/Delete
                    if (e.target.closest('.edit-btn') || e.target.closest('.delete-btn')) return;

                    openDetailModal(this.dataset.id);
                });
            });
        }

        // Edit & Delete button di row
        function bindRowActions() {
            // EDIT
            document.querySelectorAll('#table-wrapper .edit-btn').forEach(btn => {
                btn.addEventListener('click', async function(e) {
                    e.stopPropagation();
                    const id = this.dataset.id;
                    try {
                        const res = await fetch(`/jobs/${id}`);
                        if (!res.ok) throw new Error('Failed');
                        const application = await res.json();

                        document.getElementById('edit-company').value = application.company ?? '';
                        document.getElementById('edit-position').value = application.position ?? '';
                        document.getElementById('edit-status').value = application.status ?? 'Applied';

                        if (editDatePicker) {
                            if (application.applied_at) {
                                editDatePicker.setDate(application.applied_at, true);
                            } else {
                                editDatePicker.clear();
                            }
                        }

                        document.getElementById('edit-notes').value = application.notes ?? '';
                        document.getElementById('edit-form').action = `/jobs/${id}`;
                        openModal('edit-modal');
                    } catch (error) {
                        console.error(error);
                        alert('Failed to retrieve application data.');
                    }
                });
            });

            // DELETE
            document.querySelectorAll('#table-wrapper .delete-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    document.getElementById('delete-company').textContent = this.dataset.company;
                    deleteForm.action = `/jobs/${this.dataset.id}`;
                    openModal('delete-modal');
                });
            });
        }

        // Pagination
        function bindPagination() {
            document.querySelectorAll('#table-wrapper .pagination-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    loadTableFromUrl(this.href);
                });
            });
        }

        // DETAIL MODAL
        async function openDetailModal(id) {
            const modal = document.getElementById('detail-modal');
            const loading = document.getElementById('detail-loading');
            const content = document.getElementById('detail-content');

            loading.classList.remove('hidden');
            content.classList.add('hidden');
            openModal('detail-modal');

            try {
                const res = await fetch(`/jobs/${id}`);
                if (!res.ok) throw new Error('Failed');
                const app = await res.json();

                document.getElementById('detail-company').textContent = app.company ?? '-';
                document.getElementById('detail-position').textContent = app.position ?? '-';
                document.getElementById('detail-applied-at').textContent = app.applied_at ?? '-';
                document.getElementById('detail-notes').textContent = app.notes || '-';
                document.getElementById('detail-created-at').textContent =
                    app.created_at ? new Date(app.created_at).toLocaleString('id-ID') : '-';

                const statusMap = {
                    'Accepted': 'bg-green-100 text-green-700',
                    'Rejected': 'bg-red-100 text-red-700',
                    'Interview': 'bg-yellow-100 text-yellow-700',
                    'Applied': 'bg-blue-100 text-blue-700',
                };
                const cls = statusMap[app.status] || 'bg-gray-100 text-gray-700';
                document.getElementById('detail-status').innerHTML =
                    `<span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold ${cls}">${app.status ?? '-'}</span>`;

                loading.classList.add('hidden');
                content.classList.remove('hidden');
            } catch (err) {
                console.error(err);
                alert('Failed to load application detail.');
                closeModal('detail-modal');
            }
        }

        // FORM HANDLERS (Add / Edit / Delete) — AJAX
        // Handler generik untuk form submit via fetch
        async function submitFormAjax(form, {
            successMsg,
            errorMsg
        }) {
            const csrfToken = form.querySelector('input[name="_token"]').value;
            const formData = new FormData(form);

            const res = await fetch(form.action, {
                method: 'POST', // Laravel baca _method untuk PUT/DELETE
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                },
                body: formData,
            });

            if (!res.ok) {
                if (res.status === 422) {
                    const data = await res.json();
                    const firstErr = Object.values(data.errors || {}).flat()[0];
                    alert(firstErr || 'Validation error.');
                    return false;
                }
                throw new Error(errorMsg);
            }

            if (successMsg) showToast(successMsg, 'success');
            await loadTable();
            return true;
        }

        // ADD
        if (addForm) {
            addForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                try {
                    const ok = await submitFormAjax(this, {
                        successMsg: 'Application added successfully.',
                        errorMsg: 'Add failed',
                    });
                    if (!ok) return;

                    this.reset();
                    if (appliedAtPicker) appliedAtPicker.clear();
                    closeModal('add-modal');
                } catch (err) {
                    console.error('Add error:', err);
                    alert('Failed to add application.');
                }
            });
        }

        // EDIT
        if (editForm) {
            editForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                try {
                    const ok = await submitFormAjax(this, {
                        successMsg: 'Application updated successfully.',
                        errorMsg: 'Update failed',
                    });
                    if (!ok) return;
                    closeModal('edit-modal');
                } catch (err) {
                    console.error('Update error:', err);
                    alert('Failed to update application.');
                }
            });
        }

        // DELETE
        if (deleteForm) {
            deleteForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                try {
                    const ok = await submitFormAjax(this, {
                        successMsg: 'Application deleted successfully.',
                        errorMsg: 'Delete failed',
                    });
                    if (!ok) return;
                    closeModal('delete-modal');
                } catch (err) {
                    console.error('Delete error:', err);
                    alert('Failed to delete application.');
                }
            });
        }

        // FILTER INPUTS (search / status / reset)
        // Search dengan debounce
        searchInput.addEventListener('input', function() {
            const value = this.value.trim();
            clearTimeout(searchTimeout);

            const delay = value === '' ? 300 : 450;
            searchTimeout = setTimeout(() => loadTable({
                page: 1
            }, true), delay);
        });

        // Status langsung
        statusFilter.addEventListener('change', () => loadTable({
            page: 1
        }, true));

        // Reset semua filter
        resetBtn.addEventListener('click', function() {
            searchInput.value = '';
            statusFilter.value = '';
            if (datePicker) datePicker.clear();

            currentSort = 'created_at';
            currentOrder = 'desc';
            loadTable({
                page: 1
            }, true);
        });

        // GLOBAL LISTENERS
        // Klik luar modal → close
        document.querySelectorAll('[id$="-modal"]').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            });
        });

        // ESC → close semua modal
        document.addEventListener('keydown', function(e) {
            if (e.key !== 'Escape') return;
            closeModal('add-modal');
            closeModal('edit-modal');
            closeModal('delete-modal');
            closeModal('detail-modal');
        });

        // Back/Forward browser → reload table dari URL
        window.addEventListener('popstate', () => loadTableFromUrl(window.location.href));

        // INITIAL BIND
        bindSortEvents();
        bindRowActions();
        bindPagination();
        bindDetailRow();
    });
</script>
@endsection