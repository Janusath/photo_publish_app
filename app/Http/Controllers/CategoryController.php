<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
      /**
     * Display a listing of the resource.
     */

     public function index()
     {

         return view('category.category');

     }
     /**
      * Show the form for creating a new resource.
      */

     /**
      * Store a newly created resource in storage.
      */
     public function store(Request $request)
     {



         $eventData = [

             'name' => $request->name,
         ];
         category::create($eventData);
         return response()->json([
             'status' => 200,
         ]);
     }

     /**
      * Display the specified resource.
      */
     public function show()
     {
         // $id = auth()->guard('admin_user')->user()->id;

         // Get events based on the user's adminReNo
         // $events = Event::where('adminReNo', $id)->get();
         $categories = category::all();
         $output = '';
         if ($categories->count() > 0) {
             $output .= ' <div class="table-responsive"> <table class="table  table-striped table-sm text-center align-middle">

             <thead >
               <tr>
                 <th>ID</th>
                 <th>Name</th>
                 <th>Action</th>
               </tr>
             </thead>
             <tbody>';
             foreach ($categories as $category) {
                 $output .= '<tr>
                 <td>' . $category->id . '</td>
                 <td>' . $category->name . '</td>

                 <td>
                   <a href="#" id="' . $category->id . '" class="btn btn-primary mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editCategoryModal"><i class="bi-pencil-square h6"></i></a>

                   <a href="#" id="' . $category->id . '" class="btn btn-danger mx-1 deleteIcon"><i class="bi-trash h6"></i></a>
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
         $category = category::find($id);
         return response()->json($category);
     }

     /**
      * Update the specified resource in storage.
      */
       // handle update an employee ajax request
     public function update(Request $request) {

         $category = category::find($request->category_id);

         $categorytData = [

            'name' => $request->name,
         ];

         $category->update($categorytData);
         return response()->json([
             'status' => 200,
         ]);
     }
     /**
      * Remove the specified resource from storage.
      */
     public function delete(Request $request) {
        $id = $request->id;
		$category = category::find($id);
		category::destroy($id);
     }
}
