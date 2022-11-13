<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{

    public function index()
    {
        $courses = Course::paginate(10);

        return response(['courses' => $courses], 201);
    }

    public function your_courses(){
        $user = Auth::user();
        $courses = $user->courses()->paginate(5);
        if(count($courses) === 0) return response(['error' => 'You have not created any courses yet']);

        return response(['courses' => $courses], 201);
    }

    public function bought_courses(){
        $user = Auth::user();

        $courses = $user->bought_courses()->paginate(5);

        if(count($courses) === 0) return response(['error' => 'You have not bought any courses yet']);

        return response(['courses' => $courses], 201);
    }


    public function store(Request $request)
    {
        $user_id = Auth::id();

        $fields = $request->validate([
            'title' => 'required|string',
            'thumbnail' => 'required|image',
            'description' => 'required|string',
            'price' => 'required|numeric|between:0,9999999999.99'
        ]);

        $destination_path = 'public/thumbnails/courses';
        $image = $request->file('thumbnail');
        $image_name = $image->getClientOriginalName();
        $path = $request->file('thumbnail')->storeAs($destination_path, $image_name);
        

        $course = Course::create([
            'title' => $fields['title'],
            'thumbnail' => $image_name,
            'description' => $fields['description'],
            'price' => $fields['price'],
            'user_id' => $user_id
        ]);

        return response([
            'course' => $course
        ], 201);
    }


    public function show($id)
    {
        $course = Course::findOrFail($id);
        if(!$course) return response(['error' => 'Course not found'], 404);
        else{
            $episodes = $course->episodes()->paginate(8);
        }
        return response([
            'course' => $course,
            'episodes' => $episodes 
        ], 201);
    }


    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        if(Auth::id() != $course->user_id) return response(['error' => 'This is not your course!'], 409);

        $fields = $request->validate([
            'title' => 'required|string',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'required|string',
            'price' => 'required|numeric|between:0,9999999999.99'
        ]);

        $destination_path = 'public/thumbnails/courses';
        $image = $request->file('thumbnail');
        $image_name = $image->getClientOriginalName();
        $path = $request->file('thumbnail')->storeAs($destination_path, $image_name);
        
        $course->update([
            'title' => $request->title,
            'description' => $request->description,
            'thumbnail' => $image_name,
            'price' => $fields['price']
        ]);

        return response(['course' => $course], 201);
    }


    public function destroy($id)
    {
        $course = Course::findOrFail($id);

        if(Auth::id() != $course->user_id){
            return response(['error' => 'This is not your course!'], 409);
        }

        $course->delete();

        return response(['success' => 'Post deleted successfully'], 201);
    }
}
