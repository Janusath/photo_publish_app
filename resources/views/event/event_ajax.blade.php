<!-- Include jQuery before any other scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $(function() {


        // show the image when add
$("#thumbnail_image").on("change", function () {
    const input = this;
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function (e) {
            // Update the src attribute of the img tag with the data URL of the selected image
            $("#selectedImage").attr("src", e.target.result);
            $("#selectedImage").show(); // Show the image
        };

        reader.readAsDataURL(input.files[0]);
    }
});

        // add new employee ajax request
        $("#add_event_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#add_event_btn").text('Adding...');
            $.ajax({
                url: '{{ route('event_store') }}',
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
                            'Event Added Successfully!',
                            'success'
                        )
                        fetchAllEvents();
                    }
                    $("#add_event_btn").text('Add Event');
                    $("#add_event_form")[0].reset();
                    $("#addEventModal").modal('hide');
                }
            });
        });

        // fetch all employees ajax request
        fetchAllEvents();

        function fetchAllEvents() {
            $.ajax({
                url: '{{ route('event_show') }}',
                method: 'get',
                success: function(response) {
                    $("#show_all_events").html(response);
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
                url: '{{ route('event_edit') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#edit_title").val(response.title);
                    $("#edit_cate_id").val(response.cate_id);
                    $("#edit_date").val(response.date);
                    $("#image").html(`<img src="images/${response.thumbnail_image}" width="100" class="img-fluid img-thumbnail">`);
                    $("#event_id").val(response.id);
                    $("#event_image").val(response.thumbnail_image);
                }
            });
        });


        // update employee ajax request
        $("#edit_event_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#edit_event_btn").text('Updating...');
            $.ajax({
                url: '{{ route('event_update') }}',
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
                            'Event Updated Successfully!',
                            'success'
                        )
                        fetchAllEvents();
                    }
                    $("#edit_event_btn").text('Update Event');
                    $("#edit_event_form")[0].reset();
                    $("#editEventModal").modal('hide');
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
                        url: '{{ route('event_delete') }}',
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
                            fetchAllEvents();
                        }
                    });
                }
            })
        });

    });
</script>
