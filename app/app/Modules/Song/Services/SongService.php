<?php

namespace App\Modules\Song\Services;

use App\Modules\Song\Interfaces\SongInterface;
use App\Modules\Song\Models\Song;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class SongService implements SongInterface
{
    public function getAll(): array
    {
        $songs = Song::all()->sortByDesc('song_id')->toArray();
        return $songs;
    }

    public function getById(int $songId): Model
    {
        $song = Song::find($songId);
        return $song;
    }

    public function create(string $songName): void
    {
        $song = new Song;
        $song->song_name = $songName;

        try {
            $song->save();
        } catch (\Exception $e) {
            Log::error('Song not save: ' . json_encode($e));
        }
    }

    public function update(int $songId, string $songName): void
    {
        $song = Song::find($songId);
        $song->song_name = $songName;

        try {
            $song->save();
        } catch (\Exception $e) {
            Log::error('Song not update: ' . json_encode($e));
        }
    }

    public function delete(int $songId): void
    {
        $song = Song::find($songId);

        try {
            $song->delete();
        } catch (\Exception $e) {
            Log::error('Song not update: ' . json_encode($e));
        }
    }
}
