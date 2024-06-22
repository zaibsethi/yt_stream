<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Log;

class StreamVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $inputFile;
    protected $streamKey;
    protected $ffmpegPath;

    public function __construct($inputFile, $streamKey, $ffmpegPath)
    {
        $this->inputFile = $inputFile;
        $this->streamKey = $streamKey;
        $this->ffmpegPath = $ffmpegPath;
    }

    public function handle()
    {
        Log::info("Starting stream job with inputFile: {$this->inputFile}, streamKey: {$this->streamKey}, ffmpegPath: {$this->ffmpegPath}");

        $rtmpUrl = 'rtmp://a.rtmp.youtube.com/live2/' . $this->streamKey;

        $process = new Process([
            $this->ffmpegPath,
            '-re',
            '-i', $this->inputFile,
            '-c:v', 'libx264',
            '-c:a', 'aac',
            '-b:v', '3000k',
            '-b:a', '128k',
            '-f', 'flv',
            '-loglevel', 'debug',
            $rtmpUrl
        ]);

        $process->setTimeout(null);
        set_time_limit(0);

        try {
            $process->run(function ($type, $buffer) {
                if (Process::ERR === $type) {
                    Log::error('FFmpeg Error: ' . $buffer);
                } else {
                    Log::info('FFmpeg Output: ' . $buffer);
                }
            });

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            Log::info('Streaming started successfully');
        } catch (ProcessFailedException $exception) {
            Log::error('Streaming failed: ' . $exception->getMessage());
        } catch (\Exception $e) {
            Log::error('An error occurred: ' . $e->getMessage());
        }
    }
}
