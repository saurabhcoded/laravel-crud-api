<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class studentController extends Controller {

    public function index() {
        $studentsData = Student::get();
        $response_data = [
            "data" => $studentsData,
            "status" => "success",
            "message" => "Students Data Fetched Successfully"
        ];
        return response()->json($response_data, 200);
    }
    public function getSingleStudent(int $id) {
        $student = Student::find($id);
        if ($student) {
            return response()->json([
                "data" => $student,
                "status" => "success",
                "message" => "Student Fetched Successfully"
            ], 200);
        } else {
            return response()->json([
                "status" => 404,
                "message" => "Student Not Found"
            ], 200);
        }
    }
    public function addStudent(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                "name" => "required|string|max:191",
                "course" => "required|string|max:191",
                "email" => "required|email|max:191",
                "phone" => "required|digits:10"
            ]);
            if ($validator->fails()) {
                return response()->json([
                    "status" => 422,
                    "message" => $validator->messages()
                ], 500);
            } else {
                // check if user already exists
                $checkStudent = count(Student::get()->where('email', $request->email));
                if (!$checkStudent) {
                    $body = [
                        'name' => $request->name,
                        'course' => $request->course,
                        'email' => $request->email,
                        'phone' => $request->phone
                    ];
                    $student = Student::create($body);
                    return response()->json([
                        "data" => $student,
                        "status" => 200,
                        "message" => "Student Details Created Successfully"
                    ], 500);
                } else {
                    return response()->json(
                        [
                            "status" => 409,
                            "message" => "Email address already exists."
                        ],
                        200
                    );
                }
            }
        } catch (\Throwable $th) {
            return response()->json([
                "status" => 500,
                "message" => "Internal Server Error"
            ], 500);
        }
    }
    public function updateStudent(Request $request, int $id) {
        try {
            $request=$this->$request->all();
            $validator = Validator::make($request->all(), [
                "name" => "required|string|max:191",
                "course" => "required|string|max:191",
                "phone" => "required|digits:10"
            ]);
            if ($validator->fails()) {
                return response()->json([
                    "status" => 422,
                    "message" => $validator->messages()
                ], 500);
            } else {
                // Find the User
                $student = Student::find($id);
                if ($student) {

                    $body = [
                        'name' => $request->name,
                        'course' => $request->course,
                        'phone' => $request->phone
                    ];
                    $student->update($body);
                    return response()->json([
                        "data" => $student,
                        "status" => 200,
                        "message" => "Student Details Updated Successfully 👌"
                    ], 500);
                } else {
                    return response()->json(
                        [
                            "status" => 409,
                            "message" => "Student Not Found 👎."
                        ],
                        200
                    );
                }
            }
        } catch (\Throwable $th) {
            return response()->json([
                "status" => 500,
                "message" => "Internal Server Error"
            ], 500);
        }
    }
}
