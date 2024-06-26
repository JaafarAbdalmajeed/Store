$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function loadTable() {
        $.ajax({
            type: "GET",
            url: "/categories",
            success: function (response) {
                if (response && response.categories) {
                    let categoriesTable = '';
                    response.categories.forEach(function(category) {
                        categoriesTable += `
                        <tr>
                            <td><img src="storage/${category.image}" alt="Category Image" class="img-thumbnail" width="50" height="50"></td>
                            <td>${category.id}</td>
                            <td>${category.name}</td>
                            <td>${category.parent_id}</td>
                            <td>${category.slug}</td>
                            <td>${category.status}</td>
                            <td>${category.description}</td>
                            <td>${category.created_at}</td>
                            <td>${category.updated_at}</td>
                            <td>
                                <button type="button" class="edit-category-btn" data-id="${category.id}" data-toggle="modal" data-target="#editModal">
                                    <i class="fas fa-edit text-primary"></i>
                                </button>
                            </td>
                            <td>
                                <button type="button" class="delete-category-btn" data-id="${category.id}">
                                    <i class="fas fa-trash-alt text-danger"></i>
                                </button>
                            </td>
                        </tr>`;
                    });
                    $('tbody').html(categoriesTable);
                } else {
                    console.error("Invalid response format:", response);
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX error:", status, error);
            }
        });
    }
    $(document).on('click', '#pagination-links a', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        fetchCategories(url);
    });

    function fetchCategories(url) {
        $.ajax({
            url: url,
            success: function(data) {
                updateTable(data);
            },
            error: function(xhr, status, error) {
                console.error("AJAX Error:", status, error);
            }
        });
    }
    function updateTable(data) {
        if (data && data.categories) {
            let categoriesTable = '';
            data.categories.forEach(function(category) {
                categoriesTable += `
                    <tr>
                        <td><img src="/storage/${category.image}" alt="Category Image" class="img-thumbnail" width="50" height="50"></td>
                        <td>${category.id}</td>
                        <td>${category.name}</td>
                        <td>${category.parent_id}</td>
                        <td>${category.slug}</td>
                        <td>${category.status}</td>
                        <td>${category.description}</td>
                        <td>${category.created_at}</td>
                        <td>${category.updated_at}</td>
                        <td>
                            <button type="button" class="edit-category-btn" data-id="${category.id}" data-toggle="modal" data-target="#editModal">
                                <i class="fas fa-edit text-primary"></i>
                            </button>
                        </td>
                        <td>
                            <button type="button" class="delete-category-btn" data-id="${category.id}">
                                <i class="fas fa-trash-alt text-danger"></i>
                            </button>
                        </td>
                    </tr>`;
            });
            $('tbody').html(categoriesTable);
            $('#pagination-links').html(data.pagination); // Update pagination links
        } else {
            console.error("Invalid response format:", data);
        }
    }

        // loadTable();

    $('#createForm').submit(function (e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: "/category",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    confirmButtonText: 'Okay'
                });
                loadTable();
                $('#createForm')[0].reset();
            },
            error: function (error) {
                let errorMessage = "An error occurred. Please try again.";

                if (error.responseJSON && error.responseJSON.errors) {
                    let errors = error.responseJSON.errors;
                    errorMessage = '<ul style="list-style-type: none;">';
                    for (let key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            errors[key].forEach(msg => {
                                errorMessage += `<li>${msg}</li>`;
                            });
                        }
                    }
                    errorMessage += '</ul>';
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    html: errorMessage, // use html to render the list
                    confirmButtonText: 'Okay'
                });
            }
        });
    });

    $('tbody').on('click', '.delete-category-btn', function () {
        let categoryId = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this category!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: '/category/' + categoryId,
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            confirmButtonText: 'Okay'
                        });
                        loadTable();
                    },
                    error: function (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Failed to delete category. Please try again later.'
                        });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    title: 'Cancelled',
                    text: 'Your category is safe :)',
                    icon: 'info'
                });
            }
        });
    });

    $('tbody').on('click', '.edit-category-btn', function () {
        let id = $(this).data('id');
        $.ajax({
            type: "GET",
            url: "/category/" + id + "/edit",
            success: function (response) {
                $('#edit_name').val(response.name);
                $('#edit_id').val(id);
                $('#edit_parent_id').val(response.parent_id);
                $('#edit_status').val(response.status);
                $('#edit_description').val(response.description);
                $('#edit_image').attr('src', '/storage/' + response.image); // Adjusted path for image preview
                $('#editModal').modal('show');
            },
            error: function (error) {
                let errorMessage = "Failed to fetch category data. Please try again later.";

                if (error.responseJSON && error.responseJSON.message) {
                    errorMessage = error.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMessage,
                    confirmButtonText: 'Okay'
                });
            }
            });
    });


    $('#editForm').submit(function(e) {
        e.preventDefault();
        let id = $('#edit_id').val();
        let formData = new FormData(this);

        $.ajax({
            type: "POST",
            url: "/category/" + id,
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-HTTP-Method-Override': 'PUT'
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    confirmButtonText: 'Okay'
                });
                loadTable();
                $('#editModal').modal('hide');
                $('#editForm')[0].reset();
            },
            error: function (error) {
                let errorMessage = "An error occurred. Please try again.";

                if (error.responseJSON && error.responseJSON.errors) {
                    let errors = error.responseJSON.errors;
                    errorMessage = '<ul style="list-style-type: none;">';
                    for (let key in errors) {
                        if (errors.hasOwnProperty(key)) {
                            errors[key].forEach(msg => {
                                errorMessage += `<li>${msg}</li>`;
                            });
                        }
                    }
                    errorMessage += '</ul>';
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    html: errorMessage, // use html to render the list
                    confirmButtonText: 'Okay'
                });
            }
        });
    });
});
