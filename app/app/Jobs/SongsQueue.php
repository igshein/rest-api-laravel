<?php

namespace App\Jobs;

use App\Modules\Song\Interfaces\SongInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SongsQueue implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle(SongInterface $songService)
    {
        if ($this->data['event'] === SongInterface::EVENT_CREATE) {
            $songService->create($this->data['songName']);
        }
        if ($this->data['event'] === SongInterface::EVENT_UPDATE) {
            $songService->update($this->data['songId'], $this->data['songName']);
        }
        if ($this->data['event'] === SongInterface::EVENT_DELETE) {
            $songService->delete($this->data['songId']);
        }
    }
}
