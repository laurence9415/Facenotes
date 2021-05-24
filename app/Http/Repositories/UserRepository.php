<?php

namespace App\Http\Repositories;

use App\Models\User;

class UserRepository
{
    public function store(array $request)
    {
        return User::create($request);
    }

    public function show(int $id)
    {
        return User::with(['profile'])->findOrFail($id);
    }

    public function update(array $request, int $id)
    {
        return User::findOrFail($id)->update($request);
    }
}
