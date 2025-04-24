@extends('components.layout')

@section('title')
    Lowtodo
@endsection

@section('contents')
    <div class="flex flex-col px-4 md:px-8 py-6 bg-gray-900">
        {{-- Header Search --}}
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center mb-4 md:mb-0">
                <h1 class="text-2xl font-bold text-white">Lowtodo</h1>
            </div>
            <form class="w-full max-w-md">
                <label for="project-search" class="sr-only">Search Projects</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35M11 18a7 7 0 1 1 0-14 7 7 0 0 1 0 14z" />
                        </svg>
                    </div>
                    <input type="search" id="project-search"
                        class="block w-full pl-10 pr-4 py-3 text-sm rounded-xl border border-gray-700 focus:ring-indigo-500 focus:border-indigo-500 bg-gray-800 shadow-sm placeholder-gray-500 text-gray-200"
                        placeholder="Search your projects..." />
                </div>
            </form>
        </div>

        {{-- Recently Section --}}
        <div>
            <h2 class="text-xl font-semibold text-gray-100 mb-6">Recently</h2>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="projects-container">
                @foreach ($sessions as $session)
                    <div class="w-full bg-gray-800 border border-gray-700 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition duration-300 ease-in-out">
                        {{-- Header Card --}}
                        <div class="bg-gradient-to-r from-indigo-900/40 to-gray-800 px-4 py-3 flex flex-col space-y-2">
                            <div class="flex justify-between items-start">
                                <div class="text-base font-semibold text-gray-100 leading-snug truncate project-title">
                                    {{ $session->title }}
                                </div>
                                <button class="text-gray-400 hover:text-indigo-400 transition" data-id="{{ $session->id }}" id="btn-detail-todo">
                                    <i class="fas fa-info-circle"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Image --}}
                        <a href="{{ route('projects.show', $session->id) }}" class="block group">
                            <div class="h-40 overflow-hidden">
                                @if (!empty($session->img) && file_exists(public_path($session->img)))
                                    <img src="{{ asset($session->img) }}" class="w-full h-full object-cover transition duration-300 group-hover:scale-105 group-hover:opacity-80" alt="Card Image">
                                @else
                                    <div class="flex items-center justify-center h-full bg-gradient-to-br from-gray-700 to-gray-900 text-gray-500">
                                        <svg class="w-12 h-12 opacity-60 transition-all duration-300 group-hover:opacity-80 group-hover:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </a>

                        {{-- Footer with stats --}}
                        <div class="px-4 py-3 bg-gray-900/50 text-gray-400 text-xs">
                            <div class="flex justify-between items-center">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>Updated recently</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded bg-indigo-900/50 text-indigo-300">
                                        Active
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Empty State --}}
            <div id="no-results-message" class="hidden text-center py-16 bg-gray-800 rounded-xl border border-gray-700 shadow-md mt-8">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-200">Project not found</h3>
                <p class="mt-2 text-gray-400">No projects match your search criteria.</p>
            </div>
        </div>
    </div>
@endsection

@include('components.modalDetailProject')

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            let searchTimer;

            $('#project-search').on('input', function () {
                clearTimeout(searchTimer);

                searchTimer = setTimeout(() => {
                    const searchTerm = $(this).val().toLowerCase().trim();
                    let hasVisibleProjects = false;

                    $('.project-title').each(function () {
                        const $card = $(this).closest('.w-full');
                        const title = $(this).text().toLowerCase();
                        const isVisible = title.includes(searchTerm);

                        $card.toggle(isVisible);
                        if (isVisible) hasVisibleProjects = true;
                    });

                    $('#no-results-message').toggle(!hasVisibleProjects && searchTerm !== '');
                    $('#projects-container').toggle(hasVisibleProjects || searchTerm === '');
                }, 250);
            });

            $('#project-search').on('keydown', function (e) {
                if (e.key === 'Escape') {
                    $(this).val('').trigger('input');
                }
            });
        });
    </script>
@endpush
