<?php

namespace App\Http\Controllers;

use App\Models\photos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{
    public function index()
     {

         return view('photo.photo');

     }
     /**
      * Show the form for creating a new resource.
      */

     /**
      * Store a newly created resource in storage.
      */
    //  public function store(Request $request)
    //  {

    //     $imageFile=time().'.'.$request->image_url->extension();
    //     $request->image_url->move(public_path('images'),$imageFile);

    //      $photoData = [

    //          'event_id' => $request->event_id,
    //          'image_url' => $imageFile,
    //      ];
    //      photos::create($photoData);
    //      return response()->json([
    //          'status' => 200,
    //      ]);
    //  }

    public function store(Request $request)
{
    $imagePaths = [];

    // Loop through each uploaded file
    foreach ($request->file('image_url') as $image) {
        $imageFile = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images'), $imageFile);

        // Store the image path in the array
        $imagePaths[] = $imageFile;
    }

    // Loop through each uploaded image path and create a new photo record
    foreach ($imagePaths as $path) {
        $photoData = [
            'event_id' => $request->event_id,
            'image_url' => $path,
        ];

        Photos::create($photoData);
    }

    return response()->json([
        'status' => 200,
    ]);
}


     /**
      * Display the specified resource.
      */
     public function show()
     {

         $photos = photos::all();
         $output = '';
         if ($photos->count() > 0) {
             $output .= ' <div class="table-responsive"> <table class="table  table-striped table-sm text-center align-middle">

             <thead >
               <tr>
                 <th>ID</th>
                 <th>Image</th>
                 <th>Event ID</th>
                 <th>Action</th>
               </tr>
             </thead>
             <tbody>';
             foreach ($photos as $photo) {
                 $output .= '<tr>
                 <td>' . $photo->id . '</td>
                 <td><img src="images/' . $photo->image_url . '" width="60" height="60" class="rounded-circle"></td>
                 <td>' . $photo->event_id . '</td>


                 <td>
                   <a href="#" id="' . $photo->id . '" class="btn btn-primary mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editPhotoModal"><i class="bi-pencil-square h6"></i></a>

                   <a href="#" id="' . $photo->id . '" class="btn btn-danger mx-1 deleteIcon"><i class="bi-trash h6"></i></a>
                 </td>
               </tr>';
             }
             $output .= '</tbody></table></div>';
             echo $output;
         } else {
             echo '<h1 class="text-center text-secondary my-5">No record present in the database!</h1>';
         }
     }

     /**
      * Show the form for editing the specified resource.
      */
     public function edit(Request $request)
     {
         $id = $request->id;
         $photo = photos::find($id);
         return response()->json($photo);
     }

     /**
      * Update the specified resource in storage.
      */
       // handle update an employee ajax request
     public function update(Request $request) {
         $fileName = '';
         $photo = photos::find($request->photo_id);

               //image start
               if ($request->hasFile('image_url')) {
                $file = $request->file('image_url');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images'), $fileName);

                $oldimagePath = public_path('images') . '/' . $photo->image_url;
                if (file_exists($oldimagePath)) {
                   unlink($oldimagePath);
               }

            } else {
                $fileName = $request->photo_image;
            }

            //image stop

         $photoData = [

            'event_id' => $request->event_id,
            'image_url' => $fileName,
         ];

         $photo->update($photoData);
         return response()->json([
             'status' => 200,
         ]);
     }
     /**
      * Remove the specified resource from storage.
      */
     public function delete(Request $request) {
         $id = $request->id;
         $photo = photos::find($id);
         $imagePath = public_path('images') . '/' . $photo->image_url;
         if (file_exists($imagePath)) {
            unlink($imagePath);
     }
         photos::destroy($id);
   }

}
