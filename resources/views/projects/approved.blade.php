@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    {{-- Navigation --}}
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    {{-- Logo --}}
                    <div class="flex-shrink-0 flex items-center">
                        <svg class="h-8 w-8 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    
                    {{-- Navigation Links --}}
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('dashboard') }}" class="border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Dasbor
                        </a>
                        <a href="{{ route('projects.approved') }}" class="border-indigo-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                            Proyek Tersedia
                        </a>
                    </div>
                </div>
                
                {{-- User Menu --}}
                <div class="flex items-center">
                    <div class="relative">
                        <button type="button" class="flex items-center text-sm text-gray-700 hover:text-gray-900 focus:outline-none">
                            <span class="mr-2">Mahasiswa</span>
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        {{-- Page Header --}}
        <div class="px-4 sm:px-0 mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Proyek yang Tersedia</h1>
            <p class="mt-2 text-gray-600">Daftar proyek yang telah disetujui oleh admin dan tersedia untuk diajukan</p>
        </div>

        {{-- Projects List --}}
        <div class="px-4 sm:px-0 space-y-4">
            @forelse($projects as $project)
            <div class="bg-white shadow rounded-lg p-6 hover:shadow-md transition-shadow duration-200">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        {{-- Project Title --}}
                        <h2 class="text-xl font-semibold text-gray-900 mb-1">
                            {{ $project->title }}
                        </h2>
                        
                        {{-- Project Description --}}
                        <p class="text-gray-600 mb-3">
                            {{ $project->description }}
                        </p>
                        
                        {{-- Project Meta --}}
                        <div class="flex items-center text-sm text-gray-500 space-x-4">
                            <span>Durasi: {{ $project->duration }}</span>
                            <span>•</span>
                            <span>Peminat Maksimal: {{ $project->max_applicants }}</span>
                            <span>•</span>
                            <span>Tersisa: {{ max(0, $project->max_applicants - $project->applications_count) }} tempat</span>
                        </div>
                    </div>
                    
                    {{-- Project Status & Actions --}}
                    <div class="ml-6 flex flex-col items-end space-y-2">
                        {{-- Status Badge --}}
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            Disetujui
                        </span>
                        
                        {{-- Action Buttons --}}
                        <div class="flex space-x-2">
                            @if($project->applications_count < $project->max_applicants)
                                <a href="{{ route('projects.apply', $project->id) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                    Ajukan Lamaran
                                </a>
                            @else
                                <span class="text-gray-500 text-sm font-medium">
                                    Penuh
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white shadow rounded-lg p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada proyek yang tersedia</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada proyek yang disetujui oleh admin.</p>
                <div class="mt-6">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Kembali ke Dasbor
                    </a>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection