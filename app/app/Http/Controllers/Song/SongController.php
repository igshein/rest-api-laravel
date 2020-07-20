<?php

namespace App\Http\Controllers\Song;

use App\Http\Controllers\Controller;
use App\Jobs\SongsQueue;
use App\Modules\Song\Interfaces\SongInterface;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;

class SongController extends Controller
{
    private $songService;

    public function __construct(SongInterface $songService)
    {
        /**
         * @TODO change simple auth on jwt-auth
         */
        $this->middleware('auth');
        $this->songService = $songService;
    }

    public function getAll()
    {
        $songs = $this->songService->getAll();
        return response()->json($songs, 200);
    }

    public function getById(int $songId)
    {
        $song = $this->songService->getById($songId);
        if (!empty($song)) {
            return response()->json($song, 200);
        } else {
            throw new HttpException(400, 'Song not find');
        }
    }

    public function create(Request $request)
    {
        $request = json_decode($request->getContent(), true);
        if (empty($request['songName'])) {
            throw new HttpException(400, 'Not set songName');
        }

        try {
            $data['event'] = SongInterface::EVENT_CREATE;
            $data['songName'] = $request['songName'];
            SongsQueue::dispatch($data)->onQueue('songs-queue');
        } catch (\Exception $e) {
            Log::error('Song not create: ' . json_encode($e));
            throw new HttpException(400, 'Error create Song');
        }

        return response()->json(['success' => true], 200);
    }

    public function updateById(int $songId, Request $request)
    {
        $request = json_decode($request->getContent(), true);
        if (empty($request['songName'])) {
            throw new HttpException(400, 'Not set songName');
        }

        try {
            $data['event'] = SongInterface::EVENT_UPDATE;
            $data['songName'] = $request['songName'];
            $data['songId'] = $songId;
            SongsQueue::dispatch($data)->onQueue('songs-queue');
        } catch (\Exception $e) {
            Log::error('Song not update: ' . json_encode($e));
            throw new HttpException(400, 'Error update Song');
        }

        return response()->json(['success' => true], 200);
    }

    public function deleteById(int $songId)
    {
        try {
            $data['event'] = SongInterface::EVENT_DELETE;
            $data['songId'] = $songId;
            SongsQueue::dispatch($data)->onQueue('songs-queue');
        } catch (\Exception $e) {
            Log::error('Song not delete: ' . json_encode($e));
            throw new HttpException(400, 'Error delete Song');
        }

        return response()->json(['success' => true], 200);
    }
}
