<div id="modalDetailParent" class="fixed inset-0 flex items-center justify-center p-4 z-50 hidden">
    <div class="bg-gray-800 rounded-lg shadow-lg w-full max-w-md relative z-50">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-4 border-b">
            <h2 class="text-xl font-semibold text-white">Detail List</h2>
            <button id="closeModalDetailParent" class="text-gray-500 hover:text-gray-700 cursor-pointer">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Modal Body dengan scrolling -->
        <div class="modal-content p-4 space-y-4 overflow-y-auto max-h-[80vh] text-white">
            <form id="updateTodoForm" enctype="multipart/form-data">
                <input type="hidden" id="ParentList_id" name="id">

                <!-- Title -->
                <div>
                    <label class="block text-sm font-medium text-white">Name</label>
                    <input type="text" id="ParentList_title" name="title"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end items-center gap-4 p-4 border-t">
            <!-- Tombol Delete -->
            <button
                class="btn-delete-parent flex items-center justify-center p-2 text-red-500 hover:text-red-700 transition-colors cursor-pointer"
                title="Delete Parent List" data-id="{{ $list->id }}"> <!-- Tambahkan data-id disini -->
                <i class="fas fa-trash"></i>
            </button>

            <!-- Tombol Update -->
            <button type="submit" form="updateTodoForm" id="btn-update-parent"
                class="px-4 py-2 bg-white text-gray-800 rounded-md hover:bg-blue-500 hover:text-white cursor-pointer transition-colors">
                Update
            </button>
        </div>
    </div>
</div>
{{-- <style>
    #modalDetailTodo {
        display: none !important;
    }
</style> --}}


@push('scripts')
    <script>
        // Event untuk membuka modal detail
        $(document).on('click', '#btn-detail-parent', function() {
            let ListParent_id = $(this).data('id');
            console.log("Klik Detail Parent, ID:", ListParent_id); // Debugging

            $.ajax({
                url: `/parent-lists/detail/${ListParent_id}`,
                type: "GET",
                cache: false,
                success: function(response) {
                    console.log("Response dari server:", response);

                    if (!response || !response.data) {
                        console.error("Data tidak ditemukan dalam response:", response);
                        return;
                    }

                    // Isi form dengan data dari response
                    $('#ParentList_id').val(response.data.id);
                    $('#ParentList_title').val(response.data.title);

                    // Tampilkan modal setelah data berhasil diambil
                    $('#modalDetailParent').removeClass('hidden');
                },
                error: function(xhr, status, error) {
                    console.error("Error saat melakukan request:", error);
                }
            });
        });


        // Event untuk menutup modal detail
        $('#closeModalDetailParent').click(function() {
            $('#modalDetailParent').addClass('hidden');
        });

        // Event untuk melakukan update data
        $('#updateTodoForm').on('submit', function(e) {
            e.preventDefault();

            let id = $('#ParentList_id').val();
            let title = $('#title').val();
            let formData = new FormData(this);

            $.ajax({
                url: `/parent-lists/update/${id}`,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'X-HTTP-Method-Override': 'PUT'
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });

                        // Update the UI without reload - perbaikan selector
                        $(`.parent-list-item[data-parent-id="${id}"] .parent-title`).text(title);
                        $('#modalDetailParent').addClass('hidden');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || "Failed to update parent list.",
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: xhr.responseJSON?.message ||
                            "Terjadi kesalahan saat memperbarui data.",
                    });
                }
            });
        });

        $('body').on('click', '.btn-delete-parent', function() {
            let parentId = $('#ParentList_id').val(); // Ambil ID dari input hidden

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
                        url: `/parent-lists/delete/${parentId}`, // Sesuaikan dengan route
                        type: "DELETE",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            ).then(() => {
                                // Refresh halaman atau update UI
                                window.location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                xhr.responseJSON?.message || 'Failed to delete parent list',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    </script>
@endpush
