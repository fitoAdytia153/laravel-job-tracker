@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-50">
    <div class="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Back Link + Header --}}
        <div class="mb-8">
            <a href="/" class="cursor-pointer text-sm font-medium text-indigo-600 hover:text-indigo-700">
                ← Kembali ke Dashboard
            </a>

            <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900">
                Detail Lamaran
            </h1>
            <p class="mt-1 text-gray-500">
                Informasi lengkap lamaran pekerjaan.
            </p>
        </div>

        {{-- Detail Card --}}
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            {{-- Header: Company & Position --}}
            <div class="border-b border-gray-200 p-6">
                <p class="text-sm font-medium text-gray-500">Perusahaan</p>
                <h2 class="mt-1 text-2xl font-bold text-gray-900">
                    {{ $jobApplication->company }}
                </h2>
                <p class="mt-1 text-gray-600">
                    {{ $jobApplication->position }}
                </p>
            </div>

            {{-- Meta: Status & Applied At --}}
            <div class="grid gap-6 p-6 sm:grid-cols-2">
                {{-- Status --}}
                <div>
                    <p class="text-sm font-medium text-gray-500">Status</p>
                    <div class="mt-2">
                        @php
                        $statusClass = match($jobApplication->status) {
                        'Accepted' => 'bg-green-100 text-green-700',
                        'Rejected' => 'bg-red-100 text-red-700',
                        'Interview' => 'bg-yellow-100 text-yellow-700',
                        default => 'bg-blue-100 text-blue-700',
                        };
                        @endphp
                        <span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold {{ $statusClass }}">
                            {{ $jobApplication->status }}
                        </span>
                    </div>
                </div>

                {{-- Applied Date --}}
                <div>
                    <p class="text-sm font-medium text-gray-500">Tanggal Melamar</p>
                    <p class="mt-2 font-medium text-gray-900">
                        {{ $jobApplication->applied_at ?? '-' }}
                    </p>
                </div>
            </div>

            {{-- Notes --}}
            <div class="border-t border-gray-200 p-6">
                <p class="text-sm font-medium text-gray-500">Catatan</p>
                <p class="mt-2 whitespace-pre-line text-gray-700">
                    {{ $jobApplication->notes ?: 'Tidak ada catatan.' }}
                </p>
            </div>

            {{-- Footer: Created At + Actions --}}
            <div class="flex flex-col gap-4 border-t border-gray-200 p-6 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-xs text-gray-400">
                    Dibuat: {{ $jobApplication->created_at?->format('d F Y, H:i') ?? '-' }}
                </p>

                <div class="flex flex-col-reverse gap-3 sm:flex-row">
                    <a href="/"
                        class="inline-flex cursor-pointer justify-center rounded-lg border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-100">
                        Kembali
                    </a>
                    <a href="/jobs/{{ $jobApplication->id }}/edit"
                        class="inline-flex cursor-pointer justify-center rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                        Edit Lamaran
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection