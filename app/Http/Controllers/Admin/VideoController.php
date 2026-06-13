<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VideoRequest;
use App\Models\Video;

class VideoController extends Controller
{
    public function index()
    {
        return view('admin.videos.index', ['videos' => Video::latest()->paginate(20)]);
    }

    public function create()
    {
        return view('admin.videos.create');
    }

    public function store(VideoRequest $request)
    {
        $video = Video::create($request->validated());

        return redirect()->route('admin.videos.edit', $video)->with('success', __('Video created.'));
    }

    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    public function update(VideoRequest $request, Video $video)
    {
        $video->update($request->validated());

        return back()->with('success', __('Video updated.'));
    }

    public function destroy(Video $video)
    {
        $video->delete();

        return redirect()->route('admin.videos.index')->with('success', __('Video deleted.'));
    }
}
