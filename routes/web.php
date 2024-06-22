<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StreamController;
use App\Jobs\StreamVideo;
use Illuminate\Support\Facades\Artisan;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::post('/stream', [StreamController::class, 'startStream'])->name('startStream');


// Route::get('/test-stream', function () {
//     $inputFile = storage_path('app/public/rain.mp4');
//     $streamKey = 'dk9g-gczu-0g8m-35m8-5z5u';
//     $streamKey = '2w23-4uzz-j50e-1m1w-d1zb';
//     $streamKey = '1d9r-07p6-kt4h-0p7k-ehhw';
//     $ffmpegPath = 'C:\ffmpeg\bin\ffmpeg.exe';  // Update this path based on your ffmpeg installation

//     // StreamVideo::dispatchNow($inputFile, $streamKey, $ffmpegPath);
//     StreamVideo::dispatch($inputFile, $streamKey, $ffmpegPath);


//     return 'Streaming job dispatched';
// });

Route::get('/clear', function () {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');

    return "Cleared!";

});