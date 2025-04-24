<div id="modalMoveCard" class="fixed inset-0 flex items-center justify-center p-4 z-50 hidden" style="display: none;">
    <div class="bg-gray-800 rounded-lg shadow-lg w-full max-w-md relative z-50">
        <div class="flex justify-between items-center p-4 border-b border-gray-700">
            <h2 class="text-xl font-semibold text-white">Move Card</h2>
            <button id="closeModalMoveCard" class="text-gray-500 hover:text-gray-400 cursor-pointer">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <div class="p-4">
            <label class="block text-sm font-medium text-gray-300 mb-2">Select Destination List</label>
            <select id="newParentSelect" class="w-full p-2 border border-gray-600 rounded bg-gray-700 text-white">
                @foreach ($todoSession->parentLists as $list)
                    <option value="{{ $list->id }}">{{ $list->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex justify-end p-4 border-t border-gray-700 gap-2">
            <button id="cancelMove"
                    class="px-4 py-2 text-gray-300 rounded-md hover:text-white focus:outline-none focus:ring focus:ring-gray-500">
                Cancel
            </button>
            <button id="confirmMove"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-500 transition-colors">
                Move Card
            </button>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            let currentCardElement = null;
            let currentCardId = null;

            // Buka modal move
            $(document).on('click', '.btn-move-card', function() {
                currentCardElement = $(this).closest('.card-item');
                currentCardId = currentCardElement.data('card-id');
                $('#modalMoveCard').removeClass('hidden').css('display', 'flex');
            });

            // Tutup modal
            $('#closeModalMoveCard, #cancelMove').click(function() {
                $('#modalMoveCard').addClass('hidden').hide();
            });

            // Proses move dengan animasi
            $('#confirmMove').click(function() {
                const newParentId = $('#newParentSelect').val();
                const $cardElement = $(`.card-item[data-card-id="${currentCardId}"]`);

                // Show loading indicator
                const $button = $(this);
                $button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Moving...');

                $.ajax({
                    url: `/cards/${currentCardId}/move`,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    data: {
                        new_parent_id: newParentId
                    },
                    success: function(response) {
                        if (response.success) {
                            // Add visual feedback
                            const card = $(`.card-item[data-card-id="${currentCardId}"]`);
                            card.addClass('animate-move-out');

                            setTimeout(function() {
                                // Move the card to new list
                                card.detach();
                                $(`#list-content-${newParentId}`).prepend(card);
                                card.removeClass('animate-move-out').addClass('animate-move-in');

                                // Remove empty state if it exists
                                $(`#list-content-${newParentId} .flex.flex-col.items-center.justify-center`).remove();

                                // Update card's parent ID data attribute
                                card.find('.btn-move-card, .move-card-btn').data('current-parent-id', newParentId);

                                // Close the modal
                                $('#modalMoveCard').addClass('hidden').hide();

                                // Show success notification
                                showNotification('Card moved successfully', 'success');
                            }, 300);
                        } else {
                            showNotification(response.message || 'Failed to move card', 'error');
                        }
                    },
                    error: function(xhr) {
                        showNotification(xhr.responseJSON?.message || 'Error moving card', 'error');
                    },
                    complete: function() {
                        $button.prop('disabled', false).text('Move Card');
                    }
                });
            });
        });
    </script>
@endpush
