@extends('layouts.app')
@section('content')

<div class="min-h-screen bg-gray-50">
    <div class="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <a href="/"
                class="text-sm font-medium text-indigo-600 hover:text-indigo-700">
                ← Kembali ke Dashboard
            </a>

            <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900">
                Tambah Lamaran
            </h1>

            <p class="mt-1 text-gray-500">
                Catat lamaran pekerjaan yang baru kamu kirim.
            </p>
        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
            <p class="font-semibold text-red-700">
                Ada data yang perlu diperbaiki:
            </p>

            <ul class="mt-2 list-inside list-disc text-sm text-red-600">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Form --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
            <form action="/jobs" method="POST" class="space-y-6">
                @csrf
                {{-- Company --}}
                <div>
                    <label for="company"
                        class="mb-2 block text-sm font-semibold text-gray-700">
                        Nama Perusahaan
                    </label>

                    <input
                        type="text"
                        id="company"
                        name="company"
                        value="{{ old('company') }}"
                        placeholder="Contoh: Tokopedia"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                </div>

                {{-- Position --}}
                <div>
                    <label for="position"
                        class="mb-2 block text-sm font-semibold text-gray-700">
                        Posisi
                    </label>

                    <input
                        type="text"
                        id="position"
                        name="position"
                        value="{{ old('position') }}"
                        placeholder="Contoh: Junior Web Developer"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                </div>

                {{-- Status --}}
                <div>
                    <label for="status"
                        class="mb-2 block text-sm font-semibold text-gray-700">
                        Status
                    </label>

                    <select
                        id="status"
                        name="status"
                        required
                        class="w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                        <option value="Applied" {{ old('status', 'Applied') == 'Applied' ? 'selected' : '' }}>
                            Applied
                        </option>
                        <option value="Interview" {{ old('status') == 'Interview' ? 'selected' : '' }}>
                            Interview
                        </option>
                        <option value="Accepted" {{ old('status') == 'Accepted' ? 'selected' : '' }}>
                            Accepted
                        </option>
                        <option value="Rejected" {{ old('status') == 'Rejected' ? 'selected' : '' }}>
                            Rejected
                        </option>
                    </select>
                </div>

                {{-- Applied Date --}}
                <div>
                    <label for="applied_at"
                        class="mb-2 block text-sm font-semibold text-gray-700">
                        Tanggal Melamar
                    </label>

                    <input
                        type="date"
                        id="applied_at"
                        name="applied_at"
                        value="{{ old('applied_at') }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                </div>

                {{-- Notes --}}
                <div>
                    <label for="notes"
                        class="mb-2 block text-sm font-semibold text-gray-700">
                        Catatan
                    </label>

                    <textarea
                        id="notes"
                        name="notes"
                        rows="5"
                        placeholder="Contoh: Apply melalui LinkedIn, menunggu HR..."
                        class="w-full resize-none rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">{{ old('notes') }}</textarea>
                </div>

                {{-- Buttons --}}
                <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
                    <a
                        href="/"
                        class="inline-flex justify-center rounded-lg border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-100">
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="inline-flex justify-center rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                        Simpan Lamaran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection