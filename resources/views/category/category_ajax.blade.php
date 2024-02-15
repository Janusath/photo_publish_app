<!-- Include jQuery before any other scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $(function() {

        // add new employee ajax request
        $("#add_category_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#add_category_btn").text('Adding...');
            $.ajax({
                url: '{{ route('category_store') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        Swal.fire(
                            'Added!',
                            'Category Added Successfully!',
                            'success'
                        )
                        fetchAllCategories();
                    }
                    $("#add_category_btn").text('Add Category');
                    $("#add_category_form")[0].reset();
                    $("#addCategoryModal").modal('hide');
                }
            });
        });

        // fetch all employees ajax request
        fetchAllCategories();

        function fetchAllCategories() {
            $.ajax({
                url: '{{ route('category_show') }}',
                method: 'get',
                success: function(response) {
                    $("#show_all_categories").html(response);
                    $("table").DataTable({
                        order: [0, 'desc']
                    });
                }
            });
        }

        // edit employee ajax request
        $(document).on('click', '.editIcon', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            $.ajax({
                url: '{{ route('category_edit') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#edit_name").val(response.name);
                    $("#category_id").val(response.id);

                }
            });
        });


        // update employee ajax request
        $("#edit_category_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#edit_category_btn").text('Updating...');
            $.ajax({
                url: '{{ route('category_update') }}',
                method: 'post',
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 200) {
                        Swal.fire(
                            'Updated!',
                            'Category Updated Successfully!',
                            'success'
                        )
                        fetchAllCategories();
                    }
                    $("#edit_category_btn").text('Update Category');
                    $("#edit_category_form")[0].reset();
                    $("#editCategoryModal").modal('hide');
                }
            });
        });

        // delete employee ajax request
        $(document).on('click', '.deleteIcon', function(e) {
            e.preventDefault();
            let id = $(this).attr('id');
            let csrf = '{{ csrf_token() }}';
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
                        url: '{{ route('category_delete') }}',
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {
                            console.log(response);
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            fetchAllCategories();
                        }
                    });
                }
            })
        });

    });
</script>
