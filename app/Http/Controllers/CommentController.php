<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Services\CommentService;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    private $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request, $user_id, $post_id)
    {
        return $this->commentService->store($request->validated(), $user_id, $post_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        DB::beginTransaction();
        try {
            $comment->update($request->validated());
            DB::commit();
            return [
                'message' => 'Comment deleted successfully'
            ];
        } catch (\Exception $ex) {
            throw new $ex;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        DB::beginTransaction();
        try {
            $comment->delete();
            DB::commit();
            return [
                'message' => 'Comment deleted successfully'
            ];
        } catch (\Exception $ex) {
            throw new $ex;
        }
    }
}
