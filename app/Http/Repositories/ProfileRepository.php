<?php

namespace App\Http\Repositories;

use App\Models\Profile;

class ProfileRepository
{
    public function store(array $request)
    {
        return Profile::create($request);
    }

    public function updateByUserId(array $request, int $user_id)
    {
        return Profile::whereUserId($user_id)->update($request);
    }
}
