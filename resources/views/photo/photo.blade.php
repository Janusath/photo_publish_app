
@extends('layout.layout')
@section('content')

    <main id="main" class="main">
        <div class="container-fluid">
              <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <!-- add new product modal start -->
                    <div class="modal fade" id="addPhotoModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Photo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="#" method="POST" id="add_photo_form" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body p-4 bg-light">


                                        <div class="col-md-12 mb-3">
                                            <label for="event_id">Event ID</label>
                                            <input type="text" name="event_id" id="event_id" class="form-control" placeholder="event_id" required>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="image_url">Select Image</label>
                                            <input type="file" name="image_url" id="image_url" class="form-control">
                                        </div>

                                        <div class="col-md-12 mt-2">
                                            <img id="selectedImage" src="#" alt="Selected Image" class="img-fluid img-thumbnail" style=" width:100px;border-radius:7px;display: none;">
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" id="add_photo_btn" class="btn btn-primary">Photo</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- add new product modal end -->


                    {{-- edit employee modal start --}}
                    <div class="modal fade" id="editPhotoModal" tabindex="-1" aria-labelledby="exampleModalLabel" data-bs-backdrop="static" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Event</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="#" method="POST" id="edit_photo_form" enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="photo_image" id="photo_image">
                                    <input type="hidden" name="photo_id" id="photo_id">

                                    <div class="modal-body p-4 bg-light">

                                       <div class="row">

                                        <div class="col-md-12 mb-3">
                                            <label for="event_id">Event ID</label>
                                            <input type="text" name="event_id" id="edit_event_id" class="form-control" placeholder="event_id" required>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="image_url">Select Image</label>
                                            <input type="file" name="image_url" id="image_url" class="form-control">
                                        </div>
                                        <div class="mt-2" id="image">

                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" id="edit_photo_btn" class="btn btn-success">Update Photo</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- edit employee modal end --}}
            <div class="row ">
                <div class="col-sm-12 col-md-12">
                    <div class="card shadow">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3 class="text-dark">Manage Photo</h3>
                            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#addPhotoModal"><i class="bi-plus-circle me-2"></i>Photo</button>
                        </div>
                        <div class="card-body" id="show_all_photos">
                            <h1 class="text-center text-secondary my-5">Loading...</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
{{-- this is ajax script coding --}}
@include('photo.photo_ajax')
@endsection





