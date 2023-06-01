<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\SaveMessageEvent;
use App\Repositories\MessageRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Events\Dispatcher;


class MessageSubscriber implements ShouldQueue
{
    public function __construct(private readonly MessageRepository $messageRepository)
    {
    }

    public function handleSaveMessage(SaveMessageEvent $event): void
    {
        $this->messageRepository->saveMessage($event->sender, $event->message, $event->roomId);
    }

    public function subscribe(Dispatcher $dispatcher): void
    {
        $dispatcher->listen(
            SaveMessageEvent::class,
            [MessageSubscriber::class, 'handleSaveMessage']
        );
    }
}
