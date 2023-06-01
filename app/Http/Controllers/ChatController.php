<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\SaveMessageEvent;
use App\Events\SendMessageEvent;
use App\Models\User;
use App\Repositories\ChatRepository;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct(private readonly ChatRepository $chatRepository)
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        //get teh users
        $users = User::query()
            ->where('id', '<>', auth()->user()->id)
            ->get();

        return view('chat.index', ['users' => $users]);
    }

    public function sendMessage(Request $request): JsonResponse
    {
        /** @var User $loggerInUser */
        $loggerInUser = auth()->user();
        $receiverId = $request->get('receiver');

        try {
            $receiver = User::findOrFail($receiverId);
            $message = $request->get('message');
            $roomId = $request->get('roomId');

            event(new SendMessageEvent($loggerInUser, $receiver, $message, $roomId, Carbon::now()->format('h:i')));
            event(new SaveMessageEvent($loggerInUser, $message, $roomId));
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }

        return response()->json(['status' => 'success']);
    }

    public function findOrCreateRoom(Request $request): \Illuminate\View\View
    {
        try {
            $userOne = (int)$request->get('userOne');
            $userTwo = (int)$request->get('userTwo');
            $roomQuery = $this->chatRepository->findRoomByUserIds($userTwo, $userOne);

            if (!$roomQuery->exists()) {
                $room = $this->chatRepository->createRoom($userOne, $userTwo);
            } else {
                $room = $roomQuery->first();
            }
        } catch (\Exception $e) {
            return view('home');
        }

        return view('chat.room', ['roomId' => $room->id, 'messages' => $room?->messages]);
    }
}
