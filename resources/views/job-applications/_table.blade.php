<div id="table-wrapper" class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
    <div class="border-b border-gray-200 px-5 py-4">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-gray-900">List of Applications</h2>
                <p class="mt-1 text-xs text-gray-500">Click a column header to sort the data.</p>
            </div>
            {{-- Tampilkan total, bukan count halaman ini --}}
            <span class="text-sm text-gray-500">
                {{ $applications->total() }} data
            </span>
        </div>
    </div>

    @if ($applications->count() > 0)
    <div class="overflow-x-auto">
        <table class="w-full text-center text-sm">
            <thead class="bg-gray-50 text-xs uppercase text-gray-500">
                <tr>
                    <th data-sort="company" class="sort-header cursor-pointer px-5 py-4 hover:bg-gray-100">
                        <div class="flex items-center justify-center gap-1">Company <span class="sort-icon">↕</span></div>
                    </th>
                    <th data-sort="position" class="sort-header cursor-pointer px-5 py-4 hover:bg-gray-100">
                        <div class="flex items-center justify-center gap-1">Position <span class="sort-icon">↕</span></div>
                    </th>
                    <th data-sort="status" class="sort-header cursor-pointer px-5 py-4 hover:bg-gray-100">
                        <div class="flex items-center justify-center gap-1">Status <span class="sort-icon">↕</span></div>
                    </th>
                    <th data-sort="applied_at" class="sort-header cursor-pointer px-5 py-4 hover:bg-gray-100">
                        <div class="flex items-center justify-center gap-1">Date <span class="sort-icon">↕</span></div>
                    </th>
                    <th class="px-5 py-4">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100" id="applications-table-body">
                @foreach ($applications as $application)
                <tr class="detail-row cursor-pointer transition hover:bg-gray-50" data-id="{{ $application->id }}">
                    <td class="px-5 py-4 font-semibold text-gray-900">{{ $application->company }}</td>
                    <td class="px-5 py-4 text-gray-600">{{ $application->position }}</td>
                    <td class="px-5 py-4">
                        @php
                        $statusClass = match($application->status) {
                        'Accepted' => 'bg-green-100 text-green-700',
                        'Rejected' => 'bg-red-100 text-red-700',
                        'Interview' => 'bg-yellow-100 text-yellow-700',
                        default => 'bg-blue-100 text-blue-700',
                        };
                        @endphp
                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusClass }}">
                            {{ $application->status }}
                        </span>
                    </td>
                    <td class="px-5 py-4 text-gray-600">{{ $application->applied_at ?? '-' }}</td>
                    <td class="px-5 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <button type="button" data-id="{{ $application->id }}"
                                class="cursor-pointer edit-btn rounded-lg border border-gray-300 px-3 py-2 text-xs font-medium text-gray-700 hover:bg-gray-100">
                                Edit
                            </button>
                            <button type="button" data-id="{{ $application->id }}" data-company="{{ $application->company }}"
                                class="cursor-pointer delete-btn rounded-lg border border-red-200 px-3 py-2 text-xs font-medium text-red-600 hover:bg-red-50">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="border-t border-gray-200 px-5 py-4">
        {{-- Info "Showing X to Y of Z" --}}
        <div class="mb-3 text-center text-xs text-gray-500">
            Showing {{ $applications->firstItem() }}–{{ $applications->lastItem() }}
            of {{ $applications->total() }} data
        </div>

        {{-- Custom Pagination Buttons (biar lebih rapi & AJAX-friendly) --}}
        @if ($applications->hasPages())
        <div class="flex items-center justify-center gap-1">
            {{-- Prev --}}
            @if ($applications->onFirstPage())
            <span class="cursor-not-allowed rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-300">
                &laquo;
            </span>
            @else
            <a href="{{ $applications->previousPageUrl() }}"
                class="pagination-link rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-600 hover:bg-gray-50"
                data-page="{{ $applications->currentPage() - 1 }}">
                &laquo;
            </a>
            @endif

            {{-- Nomor halaman --}}
            @foreach ($applications->getUrlRange(1, $applications->lastPage()) as $page => $url)
            @if ($page == $applications->currentPage())
            <span class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white">
                {{ $page }}
            </span>
            @else
            <a href="{{ $url }}"
                class="pagination-link rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-600 hover:bg-gray-50"
                data-page="{{ $page }}">
                {{ $page }}
            </a>
            @endif
            @endforeach

            {{-- Next --}}
            @if ($applications->hasMorePages())
            <a href="{{ $applications->nextPageUrl() }}"
                class="pagination-link rounded-lg border border-gray-300 px-3 py-2 text-sm text-gray-600 hover:bg-gray-50"
                data-page="{{ $applications->currentPage() + 1 }}">
                &raquo;
            </a>
            @else
            <span class="cursor-not-allowed rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-300">
                &raquo;
            </span>
            @endif
        </div>
        @endif
    </div>
    @else
    <div class="px-5 py-16 text-center">
        <div class="text-4xl">📋</div>
        <h3 class="mt-4 text-lg font-semibold text-gray-900">No applications</h3>
        <p class="mt-1 text-sm text-gray-500">No data matching the filter was found.</p>
    </div>
    @endif
</div>