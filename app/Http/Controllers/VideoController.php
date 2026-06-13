<?php

namespace App\Http\Controllers;

use App\Models\Video;

class VideoController extends Controller
{
    public function index()
    {
        return view('videos.index', [
            'videos' => Video::published()->latest('published_at')->paginate(12),
        ]);
    }

    public function show(Video $video)
    {
        abort_unless($video->is_active, 404);

        return view('videos.show', [
            'video' => $video,
            'relatedVideos' => Video::published()
                ->where('category', $video->category)
                ->whereKeyNot($video)
                ->take(4)
                ->get(),
        ]);
    }
}
