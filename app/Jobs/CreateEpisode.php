<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateEpisode implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($data, $course_id, $user_id)
    {
        // $this->data = $data;
        // $this->course_id = $course_id;
        // $this->user_id = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $destination_path = 'public/videos';
        // $video = $this->data['video'];
        // $video_name = $video->getClientOriginalName();
        // $path = $this->data['video']->storeAs($destination_path, $video_name);

        
        // $episode = Episode::create([
        //     'title' => $this->data['title'],
        //     'description' => $this->data['description'],
        //     'video' => $video_name,
        //     'course_id' => $this->course_id,
        //     'user_id' => $this->user_id
        // ]);
    }
}
