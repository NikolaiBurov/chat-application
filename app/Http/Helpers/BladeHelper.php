<?php

declare(strict_types=1);

namespace App\Http\Helpers;

use App\Models\User;

class BladeHelper
{
    public static function showUserPicture(User $user): string
    {
        if (!is_null($user->profile_picture)) {
            $src = asset(sprintf('storage/avatars/%s/%s', $user->id, $user->profile_picture));
        } else {
            $src = 'https://bootdey.com/img/Content/avatar/avatar7.png';
        }

        return '<img class="profile-picture img-circle img-user img-thumbnail" src="' . $src . '">';
    }
}
