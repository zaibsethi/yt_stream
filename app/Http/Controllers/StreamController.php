<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\StreamVideo;

class StreamController extends Controller
{
    public function startStream(Request $request)
    {
        $request->validate([
            'streams' => 'required|array',
            'streams.*.streamKey' => 'required|string',
            'streams.*.videoname' => 'required|string',
        ]);

        $ffmpegPath = 'C:\ffmpeg\bin\ffmpeg.exe'; // Update this path based on your ffmpeg installation

        foreach ($request->input('streams') as $stream) {
            $streamKey = $stream['streamKey'];
            $videoName = $stream['videoname'];

            $inputFile = storage_path('app/public/' . $videoName);

            if (!file_exists($inputFile)) {
                return redirect()->back()->with('error', 'Video file not found: ' . $videoName);
            }

            // Dispatch the job to start streaming
            StreamVideo::dispatch($inputFile, $streamKey, $ffmpegPath);
        }

        return redirect()->route('welcome')->with('success', 'Multiple streaming jobs scheduled successfully');
    }
}
