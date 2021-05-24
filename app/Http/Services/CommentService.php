<?php

namespace App\Http\Services;

use App\Http\Repositories\CommentRepository;
use Illuminate\Support\Facades\DB;

class CommentService
{
    private $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function store(array $request, int $user_id, int $post_id)
    {
        DB::beginTransaction();
        try {
            $request['user_id'] = $user_id;
            $request['post_id'] = $post_id;
            $this->commentRepository->store($request);
            DB::commit();
            return [
                'message' => 'Comment saved successfully'
            ];
        } catch (\Exception $ex) {
            throw new $ex;
        }
    }
}
