<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Repositories\ProfileRepository;
use App\Services\ProfileService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function __construct(
        public readonly ProfileService $profileService,
        public readonly ProfileRepository $profileRepository
    ) {
        $this->middleware('auth');
    }

    public function show(int $id): View|RedirectResponse
    {
        $user = $this->profileRepository->getUser($id);

        if (!$user) {
            return redirect()->route('home')->with('error', 'User not found.');
        }

        return view('user.profile.show', ['user' => $user]);
    }

    public function edit(int $id): View|RedirectResponse
    {
        $user = $this->profileRepository->getUser($id);

        if (!$user) {
            return redirect()->route('home')->with('error', 'User not found.');
        }

        return view('user.profile.edit', ['user' => $user]);
    }

    public function update(UpdateProfileRequest $request, int $id): RedirectResponse
    {
        $user = $this->profileRepository->getUser($id);

        if (!$user) {
            return redirect()->route('home')->with('error', 'User not found.');
        }

        try {
            $validatedData = $request->validated();

            $this->profileService->updateProfile($user, $validatedData, $request->file('profile_picture'));

            return redirect()->route('profile.show', $user->id)->with('success', 'Profile updated successfully.');
        } catch (ValidationException $exception) {
            return redirect()->back()->withErrors($exception->errors())->withInput();
        }
    }
}
