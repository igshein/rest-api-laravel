<?php

namespace App\Modules\Song\Interfaces;

use Illuminate\Database\Eloquent\Model;

interface SongInterface
{
    const EVENT_CREATE = 'create';
    const EVENT_UPDATE = 'update';
    const EVENT_DELETE = 'delete';

    public function getAll(): array;
    public function getById(int $songId): Model;
    public function create(string $songName): void;
    public function update(int $songId, string $songName): void;
    public function delete(int $songId): void;
}
