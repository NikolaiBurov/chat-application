<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Builder;


class ChatRepository
{
    public function findRoomByUserIds(int $userOneId, $userTwoId): Builder
    {
        return Room::where(function ($query) use ($userOneId, $userTwoId) {
            $query->where('user_1_id', $userOneId)
                ->where('user_2_id', $userTwoId);
        })->orWhere(function ($query) use ($userOneId, $userTwoId) {
            $query->where('user_1_id', $userTwoId)
                ->where('user_2_id', $userOneId);
        });
    }

    public function createRoom(int $userOneId, $userTwoId): Room
    {
        return Room::create(['user_1_id' => $userOneId, 'user_2_id' => $userTwoId]);
    }
}
