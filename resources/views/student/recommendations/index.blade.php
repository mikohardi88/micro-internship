@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Rekomendasi Magang</h1>
        <p class="mt-2 text-gray-600">Proyek magang yang cocok berdasarkan profil dan skill Anda</p>
    </div>

    @if($recommendations->isEmpty())
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <div class="text-gray-400 text-6xl mb-4">🎯</div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Rekomendasi</h3>
            <p class="text-gray-600 mb-6">
                Perbarui profil Anda dengan skill dan minat untuk mendapatkan rekomendasi yang lebih baik.
            </p>
            <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Perbarui Profil
            </a>
        </div>
    @else
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($recommendations as $recommendation)
                @php
                    $project = $recommendation['project'];
                    $score = $recommendation['score'];
                    $reasons = $recommendation['reasons'] ?? [];
                @endphp
                
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
                    <div class="p-6">
                        <!-- Matching Score -->
                        <div class="flex items-center justify-between mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                @if($score >= 80) bg-green-100 text-green-800
                                @elseif($score >= 60) bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ $score }}% Cocok
                            </span>
                            <span class="text-sm text-gray-500">{{ $project->company->name }}</span>
                        </div>

                        <!-- Project Info -->
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                            {{ $project->title }}
                        </h3>
                        
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            {{ Str::limit($project->description, 100) }}
                        </p>

                        <!-- Matching Reasons -->
                        @if(!empty($reasons))
                            <div class="mb-4">
                                <p class="text-xs font-medium text-gray-700 mb-2">Alasan Cocok:</p>
                                <div class="space-y-1">
                                    @foreach($reasons as $reason)
                                        <div class="flex items-center text-xs text-gray-600">
                                            <svg class="w-3 h-3 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            {{ $reason }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Project Details -->
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <span>{{ $project->duration_weeks }} minggu</span>
                            <span>{{ $project->location ?? 'Remote' }}</span>
                        </div>

                        <!-- Skills -->
                        @if($project->skills->isNotEmpty())
                            <div class="mb-4">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($project->skills->take(3) as $skill)
                                        <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">
                                            {{ $skill->name }}
                                        </span>
                                    @endforeach
                                    @if($project->skills->count() > 3)
                                        <span class="inline-block px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">
                                            +{{ $project->skills->count() - 3 }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('student.projects.apply.form', $project) }}" 
                               class="flex-1 text-center px-3 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors">
                                Lamar
                            </a>
                            <a href="{{ route('student.projects.browse') }}#project-{{ $project->id }}" 
                               class="px-3 py-2 border border-gray-300 text-gray-700 text-sm rounded hover:bg-gray-50 transition-colors">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Load More -->
        @if($recommendations->count() >= 10)
            <div class="mt-8 text-center">
                <button class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors">
                    Muat Lebih Banyak
                </button>
            </div>
        @endif
    @endif
</div>
@endsection
