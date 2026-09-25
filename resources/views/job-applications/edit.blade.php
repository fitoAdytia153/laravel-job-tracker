@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-50">
    <div class="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">

        {{-- Back Link --}}
        <a href="/" class="text-sm font-medium text-indigo-600 hover:text-indigo-700">
            ← Kembali ke Dashboard
        </a>

        {{-- Header --}}
        <div class="mt-4 mb-8">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">
                Edit Lamaran
            </h1>
            <p class="mt-1 text-gray-500">
                Perbarui informasi lamaran pekerjaan.
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

        {{-- Form Card --}}
        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
            <form action="/jobs/{{ $jobApplication->id }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Company --}}
                <div>
                    <label for="company" class="mb-2 block text-sm font-semibold text-gray-700">
                        Nama Perusahaan
                    </label>
                    <input
                        type="text"
                        id="company"
                        name="company"
                        value="{{ old('company', $jobApplication->company) }}"
                        placeholder="Contoh: Google"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                </div>

                {{-- Position --}}
                <div>
                    <label for="position" class="mb-2 block text-sm font-semibold text-gray-700">
                        Posisi
                    </label>
                    <input
                        type="text"
                        id="position"
                        name="position"
                        value="{{ old('position', $jobApplication->position) }}"
                        placeholder="Contoh: Junior Web Developer"
                        required
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                </div>

                {{-- Status --}}
                <div>
                    <label for="status" class="mb-2 block text-sm font-semibold text-gray-700">
                        Status
                    </label>
                    <select
                        id="status"
                        name="status"
                        required
                        class="w-full cursor-pointer rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                        <option value="Applied" {{ old('status', $jobApplication->status) == 'Applied'   ? 'selected' : '' }}>Applied</option>
                        <option value="Interview" {{ old('status', $jobApplication->status) == 'Interview' ? 'selected' : '' }}>Interview</option>
                        <option value="Accepted" {{ old('status', $jobApplication->status) == 'Accepted'  ? 'selected' : '' }}>Accepted</option>
                        <option value="Rejected" {{ old('status', $jobApplication->status) == 'Rejected'  ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                {{-- Applied Date --}}
                <div>
                    <label for="applied_at" class="mb-2 block text-sm font-semibold text-gray-700">
                        Tanggal Melamar
                    </label>
                    <input
                        type="date"
                        id="applied_at"
                        name="applied_at"
                        value="{{ old('applied_at', $jobApplication->applied_at) }}"
                        class="w-full cursor-pointer rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                </div>

                {{-- Notes --}}
                <div>
                    <label for="notes" class="mb-2 block text-sm font-semibold text-gray-700">
                        Catatan
                    </label>
                    <textarea
                        id="notes"
                        name="notes"
                        rows="5"
                        placeholder="Tambahkan catatan..."
                        class="w-full resize-none rounded-lg border border-gray-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">{{ old('notes', $jobApplication->notes) }}</textarea>
                </div>

                {{-- Buttons --}}
                <div class="flex flex-col-reverse gap-3 border-t border-gray-100 pt-6 sm:flex-row sm:justify-end">
                    <a href="/"
                        class="inline-flex cursor-pointer justify-center rounded-lg border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-100">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex cursor-pointer justify-center rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection