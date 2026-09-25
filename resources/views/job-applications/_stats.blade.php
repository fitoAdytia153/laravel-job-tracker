<div id="stats-wrapper" class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
    <div class="rounded-xl border border-gray-200 bg-white p-5 text-center shadow-sm">
        <p class="text-sm font-medium text-gray-500">Total Applications</p>
        <p class="mt-2 text-3xl font-bold text-gray-900">{{ $total }}</p>
    </div>
    <div class="rounded-xl border border-gray-200 bg-white p-5 text-center shadow-sm">
        <p class="text-sm font-medium text-gray-500">Applied</p>
        <p class="mt-2 text-3xl font-bold text-blue-600">{{ $applied }}</p>
    </div>
    <div class="rounded-xl border border-gray-200 bg-white p-5 text-center shadow-sm">
        <p class="text-sm font-medium text-gray-500">Interview</p>
        <p class="mt-2 text-3xl font-bold text-yellow-600">{{ $interview }}</p>
    </div>
    <div class="rounded-xl border border-gray-200 bg-white p-5 text-center shadow-sm">
        <p class="text-sm font-medium text-gray-500">Accepted</p>
        <p class="mt-2 text-3xl font-bold text-green-600">{{ $accepted }}</p>
    </div>
    <div class="rounded-xl border border-gray-200 bg-white p-5 text-center shadow-sm">
        <p class="text-sm font-medium text-gray-500">Rejected</p>
        <p class="mt-2 text-3xl font-bold text-red-600">{{ $rejected }}</p>
    </div>
</div>