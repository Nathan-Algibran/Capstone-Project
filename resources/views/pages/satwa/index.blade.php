@extends('layouts.app')

@section('title', 'Satwa Liar Sumatra')
@section('meta_description', 'Database spesies satwa liar Sumatra yang dapat dideteksi oleh sistem SIMAKSI. Informasi lengkap 14 spesies beserta status konservasinya.')

@section('content')

    {{-- Page Header --}}
    <section class="bg-forest-900 pt-24 pb-16 lg:pt-32 lg:pb-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl lg:text-5xl font-bold font-heading text-cream-50 mb-4">
                Satwa Liar Sumatra
            </h1>
            <p class="text-cream-100/70 text-lg max-w-2xl mx-auto">
                Database spesies yang dapat diidentifikasi oleh sistem deteksi AI kami.
                Temukan informasi lengkap tentang setiap spesies.
            </p>
        </div>
    </section>

    {{-- Search & Filter --}}
    <section class="bg-cream-50 border-b border-cream-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <form method="GET" action="{{ url('/satwa') }}" class="flex flex-col sm:flex-row gap-4" id="filter-form">

                {{-- Search Bar --}}
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-text-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari spesies berdasarkan nama..."
                           class="w-full pl-12 pr-4 py-3 bg-white border border-cream-100 rounded-xl text-text-900
                                  placeholder:text-text-500/60 focus:outline-none focus:ring-2 focus:ring-canopy-500/40
                                  focus:border-canopy-500 transition-all duration-300"
                           id="search-input">
                </div>

                {{-- Filter Status --}}
                <div class="relative">
                    <select name="status"
                            class="appearance-none w-full sm:w-56 px-4 py-3 pr-10 bg-white border border-cream-100
                                   rounded-xl text-text-900 focus:outline-none focus:ring-2 focus:ring-canopy-500/40
                                   focus:border-canopy-500 transition-all duration-300 cursor-pointer"
                            id="status-filter"
                            onchange="document.getElementById('filter-form').submit()">
                        <option value="">Semua Status</option>
                        @foreach ($statusList as $status)
                            <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-text-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                        </svg>
                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="px-6 py-3 bg-canopy-500 text-cream-50 font-semibold rounded-xl
                               hover:bg-forest-700 active:scale-95 transition-all duration-300 shadow-sm"
                        id="search-btn">
                    Cari
                </button>

                {{-- Reset --}}
                @if (request('search') || request('status'))
                    <a href="{{ url('/satwa') }}"
                       class="px-6 py-3 bg-cream-100 text-text-900 font-semibold rounded-xl
                              hover:bg-cream-50 border border-cream-100 active:scale-95
                              transition-all duration-300 text-center"
                       id="reset-btn">
                        Reset
                    </a>
                @endif
            </form>
        </div>
    </section>

    {{-- Species Grid --}}
    <section class="py-12 lg:py-16 bg-cream-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Result count --}}
            <p class="text-sm text-text-500 mb-6">
                Menampilkan <span class="font-semibold text-text-900">{{ $species->count() }}</span> spesies
                @if (request('search'))
                    untuk pencarian "<span class="font-semibold text-text-900">{{ request('search') }}</span>"
                @endif
                @if (request('status'))
                    dengan status "<span class="font-semibold text-text-900">{{ request('status') }}</span>"
                @endif
            </p>

            @if ($species->isEmpty())
                <div class="text-center py-16">
                    <svg class="w-16 h-16 text-text-500/30 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/>
                    </svg>
                    <h3 class="text-xl font-heading font-bold text-text-900 mb-2">Tidak ditemukan</h3>
                    <p class="text-text-500">Coba ubah kata kunci pencarian atau filter Anda.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach ($species as $sp)
                        <x-species-card
                            :nama="$sp->nama_umum"
                            :nama-ilmiah="$sp->nama_ilmiah"
                            :status="$sp->status_konservasi"
                            :foto="$sp->foto_url"
                            :slug="$sp->slug"
                        />
                    @endforeach
                </div>
            @endif
        </div>
    </section>

@endsection
