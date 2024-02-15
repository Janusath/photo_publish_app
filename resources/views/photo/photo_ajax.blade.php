<!-- Include jQuery before any other scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
    $(function() {


            // show the image when add
$("#image_url").on("change", function () {
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
        $("#add_photo_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#add_photo_btn").text('Adding...');
            $.ajax({
                url: '{{ route('photo_store') }}',
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
                            'Photo Added Successfully!',
                            'success'
                        )
                        fetchAllPhotos();
                    }
                    $("#add_photo_btn").text('Add Photo');
                    $("#add_photo_form")[0].reset();
                    $("#addPhotoModal").modal('hide');
                }
            });
        });

        // fetch all employees ajax request
        fetchAllPhotos();

        function fetchAllPhotos() {
            $.ajax({
                url: '{{ route('photo_show') }}',
                method: 'get',
                success: function(response) {
                    $("#show_all_photos").html(response);
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
                url: '{{ route('photo_edit') }}',
                method: 'get',
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $("#edit_event_id").val(response.event_id);
                    console.log(`public/images/admin_images/${response.image_url}`);
                    $("#image").html
                    (`<img src="images/${response.image_url}" width="100" class="img-fluid img-thumbnail">`);
                    $("#photo_id").val(response.id);
                    $("#photo_image").val(response.image_url);
                }
            });
        });


        // update employee ajax request
        $("#edit_photo_form").submit(function(e) {
            e.preventDefault();
            const fd = new FormData(this);
            $("#edit_photo_btn").text('Updating...');
            $.ajax({
                url: '{{ route('photo_update') }}',
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
                            'Photo Updated Successfully!',
                            'success'
                        )
                        fetchAllPhotos();
                    }
                    $("#edit_photo_btn").text('Update Photo');
                    $("#edit_photo_form")[0].reset();
                    $("#editPhotoModal").modal('hide');
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
                        url: '{{ route('photo_delete') }}',
                        method: 'delete',
                        data: {
                            id: id,
                            _token: csrf
                        },
                        success: function(response) {
                            console.log(response);
                            Swal.fire(
                                'Deleted!',
                                'Your Record has been deleted.',
                                'success'
                            )
                            fetchAllPhotos();
                        }
                    });
                }
            })
        });

    });
</script>
