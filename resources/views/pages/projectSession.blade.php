@extends('components.layout')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('title')
    Project {{ $todoSession->title }}
@endsection

@section('contents')
    <div class="p-5 bg-gray-900 min-h-screen">
        <!-- Project Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div class="flex items-center">
                <div class="bg-blue-600 p-3 rounded-lg mr-4">
                    <i class="fas fa-project-diagram text-white text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-white">
                    {{ $todoSession->title }}
                </h1>
            </div>

            <!-- Search Bar -->
            <div class="relative w-full md:w-96">
                <div class="flex items-center">
                    <input type="text" id="searchInput" placeholder="Search lists or cards..."
                        class="block w-full py-3 px-4 pl-11 text-sm border border-gray-700 rounded-lg bg-gray-800 focus:ring-blue-500 focus:border-blue-500 text-white transition-all duration-200 shadow-sm">
                    <button id="clearSearch" class="absolute right-3 text-gray-400 hover:text-white ml-2 hidden">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
        </div>

        <!-- Search Not Found Notification -->
        <div id="searchNotFound" class="hidden mb-6 p-4 rounded-lg bg-gray-800 border border-gray-700 text-center">
            <div class="flex flex-col items-center justify-center py-3">
                <i class="fas fa-search-minus text-gray-400 text-3xl mb-3"></i>
                <h3 class="text-lg font-medium text-white mb-1">No results found</h3>
                <p class="text-gray-400 text-sm">We couldn't find any lists or cards matching your search</p>
            </div>
        </div>

        <!-- Parent Lists Grid - Changed to 3 columns instead of 4 -->
        <div id="parent-list-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($todoSession->parentLists as $list)
                <div class="bg-gray-800 text-white rounded-xl shadow-lg flex flex-col parent-list-item border border-gray-700 transition-all duration-200 hover:border-blue-500 hover:shadow-blue-500/10"
                    data-parent-id="{{ $list->id }}">
                    <div class="flex justify-between items-center p-4 border-b border-gray-700 bg-gray-850 rounded-t-xl">
                        <h2 class="text-lg font-semibold parent-title truncate max-w-[180px]">{{ $list->title }}</h2>
                        <div class="flex gap-2">
                            <button class="text-gray-400 hover:text-white transition duration-200" id="btn-add-card"
                                data-parent-id="{{ $list->id }}">
                                <i class="fas fa-plus"></i>
                            </button>
                            <button class="text-gray-400 hover:text-white transition duration-200 cursor-pointer"
                                id="btn-detail-parent" data-id="{{ $list->id }}">
                                <i class="fas fa-info fa-sm"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Cards Container -->
                    <div class="space-y-3 card-container p-4 max-h-[65vh] overflow-y-auto custom-scrollbar bg-gray-850/50 rounded-b-xl"
                        id="list-content-{{ $list->id }}">
                        @foreach ($list->cards as $card)
                            @php $card->checkAndUpdateStatus(); @endphp
                            <div class="bg-gray-750 rounded-lg card-item transition-all duration-200 border border-gray-600 hover:border-blue-400 hover:shadow-md group"
                                data-card-id="{{ $card->id }}">

                                <!-- Card Header -->
                                <div class="flex justify-between items-start p-3 border-b border-gray-600">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <h3 class="font-medium text-white truncate max-w-[180px]">{{ $card->title }}</h3>
                                        {!! status_badge($card->status) !!}
                                    </div>
                                    <div class="flex gap-2">
                                        <button
                                            class="text-gray-400 hover:text-green-400 btn-move-card opacity-0 group-hover:opacity-100 transition-opacity"
                                            data-card-id="{{ $card->id }}"
                                            data-current-parent-id="{{ $list->id }}" title="Move Card">
                                            <i class="fas fa-arrow-right"></i>
                                        </button>
                                        <button class="text-gray-400 hover:text-blue-400 btn-detail-card"
                                            data-id="{{ $card->id }}" title="Card Details">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Card Content -->
                                <div class="p-3">
                                    <!-- Card Image (if exists) -->
                                    @if ($card->img && file_exists(public_path('storage/images/cards/' . $card->img)))
                                        <div class="mb-3 rounded-md overflow-hidden">
                                            <img src="{{ asset('storage/images/cards/' . $card->img) }}"
                                                class="w-full h-32 object-cover hover:scale-105 transition-transform duration-300"
                                                alt="Card Image">
                                        </div>
                                    @endif

                                    <!-- Card Description -->
                                    <p class="text-sm text-gray-300 mb-3 line-clamp-3">{{ $card->description }}</p>

                                    <!-- Card Footer -->
                                    <div class="flex justify-between items-center mt-3 text-xs">
                                        <div class="flex items-center text-gray-400">
                                            <i class="far fa-clock mr-1.5"></i>
                                            <span>{{ $card->due_date ? $card->due_date->format('M d, Y H:i') : 'No due date' }}</span>
                                        </div>
                                        <div
                                            class="{{ $card->status === 'completed' ? 'text-green-300' : ($card->status === 'late' ? 'text-red-300' : 'text-yellow-300') }}">
                                            <span class="inline-flex items-center">
                                                <i
                                                    class="fas {{ $card->status === 'completed' ? 'fa-check-circle' : ($card->status === 'late' ? 'fa-exclamation-circle' : 'fa-clock') }} mr-1.5"></i>
                                                {{ status_text($card->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <!-- Empty State for Lists -->
                        @if (count($list->cards) === 0)
                            <div class="flex flex-col items-center justify-center py-8 text-gray-500">
                                <i class="fas fa-tasks text-4xl mb-3 text-blue-400/50"></i>
                                <p class="text-sm mb-2">No cards in this list</p>
                                <button class="text-blue-400 hover:text-blue-300 text-sm btn-add-card flex items-center"
                                    data-parent-id="{{ $list->id }}">
                                    <i class="fas fa-plus-circle mr-1.5"></i> Add first card
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            <!-- Empty State for Project -->
            @if (count($todoSession->parentLists) === 0)
                <div class="col-span-full flex flex-col items-center justify-center py-16 text-gray-400">
                    <div
                        class="bg-gray-800 p-8 rounded-xl text-center max-w-md mx-auto border-2 border-dashed border-gray-700">
                        <div class="bg-blue-600/10 p-5 rounded-full inline-block mb-4">
                            <i class="fas fa-clipboard-list text-4xl text-blue-400"></i>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-white">No lists yet</h3>
                        <p class="text-sm mb-6">Get started by creating your first list</p>
                        <button id="empty-state-add-list"
                            class="bg-blue-600 text-white px-6 py-2.5 rounded-lg hover:bg-blue-700 transition flex items-center justify-center mx-auto"
                            data-session-id="{{ $todoSession->id }}">
                            <i class="fas fa-plus mr-2"></i> Create List
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Floating Action Button -->
        <button id="add-parent-list-button"
            class="fixed bottom-8 right-8 bg-gradient-to-br from-blue-500 to-blue-600 text-white w-16 h-16 rounded-full flex justify-center items-center shadow-xl hover:shadow-2xl transition-all duration-300 cursor-pointer z-50 group"
            data-session-id="{{ $todoSession->id }}">
            <i class="fas fa-plus text-xl group-hover:rotate-90 transition-transform duration-300"></i>
        </button>
    </div>
@endsection


@include('components.modalDetailParent')
@include('components.modalDetailCard')
@include('components.modalCreateCard')
@include('components.modalMoveCard')

@push('scripts')
    <script>
        $(document).ready(function() {
            // Add new parent list
            $('#add-parent-list-button, #empty-state-add-list').click(function() {
                const sessionId = $(this).data('session-id');

                $.ajax({
                    url: '/parent-lists',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .getAttribute('content')
                    },
                    data: {
                        session_id: sessionId
                    },
                    success: function(response) {
                        // Remove empty state if present
                        const emptyState = $('#parent-list-container').find('.col-span-full');
                        if (emptyState.length) {
                            emptyState.remove();
                        }

                        const newListHtml = generateParentListHTML(response.data);
                        $("#parent-list-container").append(newListHtml);

                        // Animate the new list
                        const newList = $(`[data-parent-id="${response.data.id}"]`);
                        newList.addClass('animate-fade-in');

                        // Scroll to the new list
                        newList[0].scrollIntoView({
                            behavior: 'smooth',
                            block: 'nearest'
                        });

                        // Update move card modal options
                        updateMoveCardOptions();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message || 'Failed to create list',
                        });
                    }
                });
            });

            // Function to reset search and show all lists and cards
            function resetSearch() {
                // Show all parent lists
                $('.parent-list-item').show();

                // Show all cards
                $('.card-item').show();

                // Remove highlighting from list titles
                $('.parent-title').removeClass('text-blue-400');

                // Remove highlighting from cards
                $('.card-item').removeClass('border-blue-500');

                // Hide the no results message
                $('#searchNotFound').addClass('hidden');
            }

            // Search functionality with highlighting
            $('#searchInput').on('input', function() {
                const searchTerm = $(this).val().toLowerCase();

                if (searchTerm.length > 0) {
                    $('#clearSearch').show();
                } else {
                    $('#clearSearch').hide();
                    resetSearch(); // Reset to show all content
                    return;
                }

                let totalVisibleLists = 0;

                $('.parent-list-item').each(function() {
                    const parentTitle = $(this).find('.parent-title').text().toLowerCase();
                    let hasMatchingCards = false;

                    // Check each card
                    $(this).find('.card-item').each(function() {
                        const cardTitle = $(this).find('h3').text().toLowerCase();
                        const cardDescription = $(this).find('p.text-sm').text()
                            .toLowerCase();

                        if (cardTitle.includes(searchTerm) || cardDescription.includes(
                                searchTerm)) {
                            $(this).show();
                            hasMatchingCards = true;

                            // Add highlight class to matching text
                            if (searchTerm.length > 0) {
                                $(this).addClass('border-blue-500');
                            } else {
                                $(this).removeClass('border-blue-500');
                            }
                        } else {
                            $(this).hide();
                        }
                    });

                    // Show/hide list based on match
                    const shouldShowList = parentTitle.includes(searchTerm) || hasMatchingCards;
                    $(this).toggle(shouldShowList);

                    if (shouldShowList) {
                        totalVisibleLists++;
                    }

                    // Highlight list title if it matches
                    if (searchTerm.length > 0 && parentTitle.includes(searchTerm)) {
                        $(this).find('.parent-title').addClass('text-blue-400');
                    } else {
                        $(this).find('.parent-title').removeClass('text-blue-400');
                    }
                });

                // Show/hide "No results found" message
                if (totalVisibleLists === 0 && searchTerm.length > 0) {
                    $('#searchNotFound').removeClass('hidden').addClass('animate-fade-in');
                } else {
                    $('#searchNotFound').addClass('hidden');
                }
            });

            // Clear search button
            $('#clearSearch').hide().click(function() {
                $('#searchInput').val('');
                $(this).hide();
                resetSearch(); // Reset to show all content
            });

            // Clear search on ESC
            $(document).keyup(function(e) {
                if (e.key === "Escape") {
                    $('#searchInput').val('');
                    $('#clearSearch').hide();
                    resetSearch(); // Reset to show all content
                }
            });

            // Delegate event handlers for dynamically added elements
            $(document).on('click', '.btn-add-card', function() {
                const parentId = $(this).data('parent-id');
                // Open create card modal with parent ID
                $('#modalCreateCard').removeClass('hidden');
                $('#parent_id').val(parentId);
            });

            $(document).on('click', '.btn-detail-parent', function() {
                const parentId = $(this).data('id');
                // Open parent detail modal
                openParentDetailModal(parentId);
            });

            $(document).on('click', '.btn-detail-card', function() {
                const cardId = $(this).data('id');
                // Open card detail modal
                openCardDetailModal(cardId);
            });

            // Move card functionality
            $(document).on('click', '.btn-move-card, .move-card-btn', function() {
                const cardId = $(this).data('card-id');
                const currentParentId = $(this).data('current-parent-id');

                // Set the card ID in the hidden input
                $('#moveCardId').val(cardId);

                // Disable current parent list in dropdown
                $('#newParentSelect option, #new_parent_id option').prop('disabled', false);
                $(`#newParentSelect option[value="${currentParentId}"], #new_parent_id option[value="${currentParentId}"]`)
                    .prop('disabled', true);

                // Select the first non-disabled option
                const firstEnabledOption = $('#newParentSelect option:not(:disabled):first').val();
                $('#newParentSelect').val(firstEnabledOption);

                // Show the modal
                $('#modalMoveCard').removeClass('hidden').css('display', 'flex');
            });

            // Close move card modal
            $('#closeModalMoveCard, #cancelMove').click(function() {
                $('#modalMoveCard').addClass('hidden');
            });

            // Submit move card form
            $('#moveCardForm').submit(function(e) {
                e.preventDefault();
                processCardMove();
            });

            // Also handle confirmMove button click
            $('#confirmMove').click(function(e) {
                e.preventDefault();
                processCardMove();
            });

            // Process card move function
            function processCardMove() {
                const cardId = $('#moveCardId').val();
                const newParentId = $('#newParentSelect').val();

                // Show loading indicator
                const $button = $('#confirmMove');
                $button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Moving...');

                $.ajax({
                    url: `/cards/${cardId}/move`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    data: {
                        new_parent_id: newParentId
                    },
                    success: function(response) {
                        if (response.success) {
                            // Add visual feedback
                            const card = $(`.card-item[data-card-id="${cardId}"]`);
                            card.addClass('animate-move-out');

                            setTimeout(function() {
                                // Move the card to new list
                                card.detach();
                                $(`#list-content-${newParentId}`).prepend(card);
                                card.removeClass('animate-move-out').addClass(
                                    'animate-move-in');

                                // Remove empty state if it exists
                                $(`#list-content-${newParentId} .flex.flex-col.items-center.justify-center`)
                                    .remove();

                                // Update card's parent ID data attribute
                                card.find('.btn-move-card, .move-card-btn').data(
                                    'current-parent-id', newParentId);

                                // Close the modal
                                $('#modalMoveCard').addClass('hidden');
                            }, 300);
                        }
                    },
                    error: function(xhr) {
                        console.error('Error moving card:', xhr.responseJSON?.message ||
                            'Unknown error');
                    },
                    complete: function() {
                        $button.prop('disabled', false).text('Move Card');
                    }
                });
            }

            // Function to update move card select options
            function updateMoveCardOptions() {
                let options = '';
                $('.parent-list-item').each(function() {
                    const listId = $(this).data('parent-id');
                    const listTitle = $(this).find('.parent-title').text();
                    options += `<option value="${listId}">${listTitle}</option>`;
                });
                $('#newParentSelect, #new_parent_id').html(options);
            }

            // Initialize the move options
            updateMoveCardOptions();
        });

        // Generate HTML for new parent list
        function generateParentListHTML(list) {
            return `
            <div class="bg-gray-800 text-white rounded-lg shadow-lg flex flex-col parent-list-item transition-all duration-200 hover:shadow-xl border border-gray-700"
                data-parent-id="${list.id}">
                <!-- List Header -->
                <div class="flex justify-between items-center p-4 border-b border-gray-700">
                    <h2 class="text-lg font-semibold parent-title">${list.title}</h2>
                    <div class="flex gap-2">
                        <button class="text-gray-400 hover:text-blue-400 transition btn-add-card" data-parent-id="${list.id}"
                            title="Add Card">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button class="text-gray-400 hover:text-blue-400 transition cursor-pointer btn-detail-parent"
                            data-id="${list.id}" title="List Details">
                            <i class="fas fa-info-circle"></i>
                        </button>
                    </div>
                </div>

                <!-- Cards Container with empty state -->
                <div class="space-y-3 card-container p-4 max-h-[70vh] overflow-y-auto custom-scrollbar" id="list-content-${list.id}">
                    <div class="flex flex-col items-center justify-center py-8 text-gray-500">
                        <i class="fas fa-tasks text-4xl mb-2"></i>
                        <p class="text-sm">No cards yet</p>
                        <button class="mt-2 text-blue-400 hover:text-blue-300 text-sm btn-add-card" data-parent-id="${list.id}">
                            <i class="fas fa-plus mr-1"></i> Add a card
                        </button>
                    </div>
                </div>
            </div>`;
        }

        // Function to open parent detail modal
        function openParentDetailModal(parentId) {
            $('#parentListId').val(parentId);
            $('#modalDetailParent').removeClass('hidden');

            // Fetch parent details via AJAX if needed
            $.ajax({
                url: `/parent-lists/${parentId}`,
                type: 'GET',
                success: function(response) {
                    // Populate modal with data
                    $('#parentTitle').val(response.data.title);
                }
            });
        }

        // Function to open card detail modal
        function openCardDetailModal(cardId) {
            $('#cardId').val(cardId);
            $('#modalDetailCard').removeClass('hidden');

            // Fetch card details via AJAX if needed
            $.ajax({
                url: `/cards/${cardId}`,
                type: 'GET',
                success: function(response) {
                    // Populate modal with data
                    $('#cardTitle').val(response.data.title);
                    $('#cardDescription').val(response.data.description);
                }
            });
        }
    </script>

    <style>
        /* Custom scrollbar styling */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #2d3748;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #4a5568;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #718096;
        }

        /* Animation for new elements */
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Animation for moving cards */
        .animate-move-out {
            animation: moveOut 0.3s ease-in-out;
        }

        .animate-move-in {
            animation: moveIn 0.3s ease-in-out;
        }

        @keyframes moveOut {
            to {
                opacity: 0;
                transform: translateX(30px);
            }
        }

        @keyframes moveIn {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>
@endpush
