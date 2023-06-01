<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Message;
use App\Models\User;

class MessageRepository
{
    public function saveMessage(User $sender, string $message, int $roomId): Message
    {
        return Message::create(['sender_id' => $sender->id, 'room_id' => $roomId, 'content' => $message]);
    }
}
