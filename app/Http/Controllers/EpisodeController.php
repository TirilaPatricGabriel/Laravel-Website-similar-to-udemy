<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Episode;
use Illuminate\Support\Facades\Auth;
use App\Jobs\CreateEpisode;

class EpisodeController extends Controller
{

    public function index()
    {
        //
    }


    public function store(Request $request, $id)
    {

        $course = Course::findOrFail($id);
        if(!$course) return response(['error' => '404 not found'], 404);
        if(Auth::id() != $course->user_id){
            return response(['error' => 'This is not your course!'], 404);
        }

        $data = $request->validate([
            'title' => 'string|required',
            'description' => 'string|required',
            'video' => 'required|mimes:mp4,ogx,oga,ogg,ogv,webm'
        ]);

        $user_id = $course->user_id;

        $destination_path = 'public/videos';
        $video = $data['video'];
        $video_name = $video->getClientOriginalName();
        $path = $data['video']->storeAs($destination_path, $video_name);

        
        $episode = Episode::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'video' => $video_name,
            'course_id' => $course->id,
            'user_id' => $user_id
        ]);


        CreateEpisode::dispatch($data, $course->id, $user_id);

        return response(['success' => 'Video is now uploading! It will take a few minutes...'], 201);
    }

    
    public function show($id)
    {
        $episode = Episode::findOrFail($id);

        if(!$episode) return response(['error' => 'This episode does not exist!'], 404);

        return response([
            'episode' => [$episode]
        ], 201);
    }


    public function update(Request $request, $id)
    {
        $episode = Episode::findOrFail($id);

        if(Auth::id() != $episode->user_id){
            return response(['error' => 'This is not your course!'], 409);
        }

        $episode->update([
            'title' => $request->title,
            'description' => $request->description,

        ]);

        return response(['success' => 'Episode updated successfully!'], 201);
    }


    public function destroy($id)
    {
        $episode = Episode::findOrFail($id);

        if(Auth::id() != $episode->user_id){
            return response(['error' => 'This is not your episode!'], 409);
        }

        $episode->delete();
        return response(['success' => 'Episode deleted successfully!'], 201);
    }
}
