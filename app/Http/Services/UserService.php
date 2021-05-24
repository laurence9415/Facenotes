<?php

namespace App\Http\Services;

use App\Http\Repositories\ProfileRepository;
use App\Http\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserService
{
    private $userRepository;
    private $profileRepository;

    public function __construct(UserRepository $userRepository, ProfileRepository $profileRepository)
    {
        $this->userRepository = $userRepository;
        $this->profileRepository = $profileRepository;
    }

    public function store(array $request)
    {
        DB::beginTransaction();
        try {
            $request['profile_picture'] = Storage::disk('public')->put('profile', $request['profile_picture']);
            $user = $this->userRepository->store($request);
            $request['user_id'] = $user->id;
            $this->profileRepository->store($request);
            DB::commit();
            return [
                'message' => 'User registered successfully'
            ];
        } catch (\Exception $ex) {
            DB::rollBack();
            throw new $ex;
        }
    }

    public function show(int $id)
    {
        $user_data = $this->userRepository->show($id);
        return view('pages.user_profile', compact('user_data'));
    }

    public function update(array $request, int $user_id)
    {
        DB::beginTransaction();
        try {
            if (isset($request['profile_picture'])) {
                $request['profile_picture'] = Storage::disk('public')->put('profile', $request['profile_picture']);
            }

            $this->userRepository->update($request, $user_id);
            unset($request['name']);
            unset($request['email']);
            unset($request['password']);
            $this->profileRepository->updateByUserId($request, $user_id);

            DB::commit();
            return [
                'message' => 'User updated successfully'
            ];
        } catch (\Exception $ex) {
            DB::rollBack();
            throw new $ex;
        }
    }
}
