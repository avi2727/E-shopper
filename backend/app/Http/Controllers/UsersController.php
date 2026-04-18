<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Users  $users
     * @return \Illuminate\Http\Response
     */
    public function getdata(Student $users)
    {
       $studentModel = new Student();
       $data=$studentModel->getStudent();
       return response()->json($data);
    }
    public function adddata(Request $request)
    {
     // dd($request->all());  
    $json = [];
    $validatedData = $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:students,email',
        'contact' => 'required|string|max:10',
    ]);
    $uploadpath = public_path('images');
    $image = $request->file('image');
    $imageName = $image->getClientOriginalName();
    $imagePath = $image->storeAs('images', $imageName, 'public');
    if (!$imagePath) {
        return redirect()->back()->with('error', 'Image upload failed.');
    }
    $studentData = [
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'contact' => $validatedData['contact'],
        'user_image' => $imagePath, 
    ];
    $studentModel = new Student();
    $result = $studentModel->addStudent($studentData);

    if ($result) {
        $json['code'] = 1;
        $json['message'] = 'Details Saved Successfully!';
    } else {
        $json['code'] = 2;
        $json['message'] = 'Error While Saving Details!';
    }

    return response()->json($json);
}


    public function deletedata(Request $request){
        $json=array();
        $studentModel = new Student();
        $id = $request->id;
        $resultt = $studentModel->deleteData($id);
        if($resultt){
            $json['code']= 1;
            $json['message']= 'Details Deleted Successfully!';
          }else{
            $json['code']= 2;
            $json['message']= 'Error while Deleting Details!';
          }
           return response()->json($json);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Users  $users
     * @return \Illuminate\Http\Response
     */
    // public function editdata(Request $request)
    // {
    //     $studentModel = new Student();
    //     $id = $request->id;
    //     $studentModel->editData($id);
    // }

 


public function updatedata(Request $request)
{

    $json = [];
    $id = $request->id;

    // Define custom error messages for validation
    $customMessages = [
        'name.required' => 'The name field is required.',
        'name.max' => 'The name field must not exceed 255 characters.',
        'email.required' => 'The email field is required.',
        'email.email' => 'Please provide a valid email address.',
        'email.unique' => 'The provided email address is already in use.',
        'contact.required' => 'The contact field is required.',
        'contact.max' => 'The contact field must not exceed 10 characters.',
        'image.image' => 'Please upload a valid image (jpeg, png, jpg, gif).',
        'image.mimes' => 'Please upload an image in jpeg, png, jpg, or gif format.',
        'image.max' => 'The image size should not exceed 2048 kilobytes.',
    ];

    // Use the Validator class to perform the validation
    $validator = Validator::make($request->all(), [
        'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:students,email,' . $id,
        'contact' => 'required|string|max:10',
    ], $customMessages);

    // Check if validation fails
    if ($validator->fails()) {
        $json['code'] = 2;
        $json['message'] = $validator->errors()->first();
        return response()->json($json, 400); // Return with 400 Bad Request status code
    }

    // Validation successful, proceed to update data
    $studentModel = new Student();
    $studentData = [
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'contact' => $request->input('contact'),
    ];

    // Handle image update if provided in the request
    if ($request->hasFile('image')) {
        $uploadPath = public_path('images');
        $image = $request->file('image');
        $imageName = $image->getClientOriginalName();
        $imagePath = $image->storeAs('images', $imageName, 'public');
        if (!$imagePath) {
            $json['code'] = 2;
            $json['message'] = 'Image upload failed.';
            return response()->json($json, 500); // Return with 500 Internal Server Error status code
        }
        $studentData['user_image'] = $imagePath;
    }

    // Update student data in the database
    $result = $studentModel->updateStudent($id, $studentData);

    // Check if the image was updated successfully
    if ($request->hasFile('image') && !$result) {
        $json['code'] = 2;
        $json['message'] = 'Error While Updating Image!';
        return response()->json($json, 500); // Return with 500 Internal Server Error status code
    }

    if ($result) {
        $json['code'] = 1;
        $json['message'] = 'Details Updated Successfully!';
    } else {
        $json['code'] = 2;
        $json['message'] = 'Error While Updating Details!';
    }

    return response()->json($json);
}

}

