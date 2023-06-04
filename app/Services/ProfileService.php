<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Repositories\ProfileRepository;
use Illuminate\Http\UploadedFile;

class ProfileService
{
    public function __construct(public readonly ProfileRepository $profileRepository)
    {
    }

    public function updateProfile(User $user, array $data, ?UploadedFile $profilePicture): void
    {
        $user->name = $data['name'];
        $user->email = $data['email'];

        if ($data['password']) {
            $user->password = bcrypt($data['password']);
        }

        if ($profilePicture) {
            $filename = md5($user->id . $user->name) . '.' . explode('.', $profilePicture->getClientOriginalName())[1];

            $this->storeProfilePicture($profilePicture, $filename,$user->id);
            $user->profile_picture = $filename;
        }

        $this->profileRepository->saveUser($user);
    }

    private function storeProfilePicture(UploadedFile $profilePicture, string $filename, int $userId): void
    {
        $profilePicture->storeAs(sprintf('public/avatars/%s', $userId), $filename);
    }
}
