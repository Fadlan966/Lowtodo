<!-- Modal Detail -->
<div id="modalDetailTodo" class="fixed inset-0 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-gray-800 rounded-lg shadow-lg w-full max-w-md relative z-50">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-4 border-b border-gray-600">
            <h2 class="text-xl font-semibold text-white">Detail Todo</h2>
            <button id="closeModalDetailTodo" class="text-gray-400 hover:text-white cursor-pointer">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Modal Body dengan scrolling -->
        <div class="modal-content p-4 space-y-4 overflow-y-auto max-h-[80vh]">
            <form id="updateTodoForm" enctype="multipart/form-data">
                <input type="hidden" id="TodoSession_id" name="id">

                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-white">Title</label>
                    <input type="text" id="title" name="title"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-700 text-white focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-white">Description</label>
                    <textarea id="description" name="description"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm bg-gray-700 text-white focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>

                <!-- Image Upload -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-white">Choose Image</label>
                    <div
                        class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <div class="flex text-sm text-white">
                                <label for="img"
                                    class="relative cursor-pointer bg-gray-800 rounded-md font-medium text-blue-400 hover:text-blue-300">
                                    <span>Upload a file</span>
                                    <input id="img" name="img" type="file" class="sr-only">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-white">PNG, JPG, GIF up to 10MB</p>
                            <span id="file-name" class="text-sm text-white"></span>
                        </div>
                    </div>
                    <div id="current-image-container" class="mt-2 text-center">
                        <span class="text-sm text-white">Current Image:</span>
                        <img id="current-image" src="" class="mt-2 mx-auto max-h-32 hidden">
                    </div>
                </div>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end items-center gap-4 p-4 border-t border-gray-600">
            <!-- Tombol Delete -->
            <button
                class="btn-delete-session flex items-center justify-center p-2 text-red-400 hover:text-red-600 transition-colors"
                data-id="" title="Delete Session">
                <i class="fas fa-trash"></i>
            </button>

            <!-- Tombol Update -->
            <button type="submit" form="updateTodoForm"
                class="px-4 py-2 bg-white text-gray-800 rounded-md hover:bg-blue-500 hover:text-white cursor-pointer transition-colors">
                Update
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Event untuk membuka modal detail
    $('body').on('click', '#btn-detail-todo', function () {
        const sessionId = $(this).data('id');
        $('.btn-delete-session').data('id', sessionId);

        $.ajax({
            url: `/project/${sessionId}`,
            type: "GET",
            cache: false,
            success: function (response) {
                if (!response || !response.data) {
                    console.error("Data tidak ditemukan dalam response:", response);
                    return;
                }

                $('#TodoSession_id').val(response.data.id);
                $('#title').val(response.data.title);
                $('#description').val(response.data.description);
                // $('#visibility').val(response.data.visibility); // DIHAPUS

                if (response.data.img) {
                    $('#current-image').attr('src', response.data.img).removeClass('hidden');
                } else {
                    $('#current-image').addClass('hidden');
                }

                $('#modalDetailTodo').removeClass('hidden');
            },
            error: function (xhr, status, error) {
                console.error("Error saat melakukan request:", error);
            }
        });
    });

    // Event untuk menutup modal detail
    $('#closeModalDetailTodo').click(function () {
        $('#modalDetailTodo').addClass('hidden');
    });

    // Submit form update
    $('#updateTodoForm').on('submit', function (e) {
        e.preventDefault();
        let sessionId = $('#TodoSession_id').val();
        let formData = new FormData(this);

        $.ajax({
            url: `/project/${sessionId}/update`,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-HTTP-Method-Override': 'PUT'
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 3000
                });
                $('#modalDetailTodo').addClass('hidden');
                updateTodoCard(response.data);
            },
            error: function (xhr) {
                let errorMessage = xhr.responseJSON?.message || 'Terjadi kesalahan saat mengupdate data';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage,
                });
            }
        });
    });

    function updateTodoCard(updatedData) {
        const card = $(`[data-id="${updatedData.id}"]`).closest('.block');

        if (card.length) {
            card.find('.text-lg').text(updatedData.title);
            if (updatedData.img) {
                card.find('img').attr('src', updatedData.img);
            }
        }
    }

    $('#img').change(function () {
        const fileName = $(this).val().split('\\').pop();
        $('#file-name').text(fileName || 'No file chosen');
    });

    // Delete session
    $('body').on('click', '.btn-delete-session', function () {
        let sessionId = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/project/${sessionId}/delete`,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        Swal.fire(
                            'Deleted!',
                            response.message,
                            'success'
                        ).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function (xhr) {
                        Swal.fire(
                            'Error!',
                            xhr.responseJSON?.message || 'Failed to delete session',
                            'error'
                        );
                    }
                });
            }
        });
    });
</script>
@endpush
