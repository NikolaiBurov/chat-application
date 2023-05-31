<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\SendMessageEvent;
use App\Models\Room;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
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

            event(new SendMessageEvent($loggerInUser, $receiver, $message, $roomId));
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }

        return response()->json(['status' => 'success']);
    }

    public function createRoom(Request $request): \Illuminate\View\View
    {
        try {
            $userOne = (int)$request->get('userOne');
            $userTwo = (int)$request->get('userTwo');

            $room = Room::updateOrCreate(
                ['user_1_id' => $userOne, 'user_2_id' => $userTwo],
                ['user_1_id' => $userOne, 'user_2_id' => $userTwo],
                ['user_1_id' => $userTwo, 'user_2_id' => $userOne],
            );
        } catch (\Exception $e) {
            return view('home');
        }

        return view('chat.room', ['roomId' => $room->id]);
    }
}
