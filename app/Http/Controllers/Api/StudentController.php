<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index() {
        $students = Student::all();
        if($students->count()>0){
            return response()-> json([
                'status' => 200,
                'students' => $students
            ], 200);
        }else{
            return response()-> json([
                'status' => 404,
                'message' => 'No Records Found'
            ], 404); 
        }
    }

    public function store(request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone_number' => 'required|digits:10',
        ]);

        if ($validator->fails()){

            return response()->json([
                'status' => 422,
                'error' => $validator->messages()
            ],422);
        }else{
            $student = Student::create([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone_number' => $request->phone_number,
            ]);    
            
        if ($student){
            return response()->json([
                'status' => 200,
                'message' => "Student Added Successfully"
            ], 200);
        }else{
            return response()->json([
                'status' => 500,
                'message' => "Something Went Wrong"
            ], 500);
        }
        }

    }
}
