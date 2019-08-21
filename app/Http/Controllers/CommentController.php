<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Submission; 
use App\ChallengeDay;
use App\Challnege;
use Auth;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return 'success';
    }

    public function addComment($entity, $entityId){
        $comment = request('comment');
        $user = Auth::user();
        $comment['user_id'] = $user->id;
        switch($entity){
            case 'submission':
                $model = Submission::find($entityId);
                break;
            case 'day':
                $model = ChallengeDay::find($entityId);
                break; 
            case 'challenge':
                $model = Challenge::find($entityId);
                break;
            default:
                $model = 'error';
        }
        if($model !== 'error'){
            //$comment = request('comment');
            $model->addComment($comment);
            $newComment = $model->comments()->where('content', $comment['content'])->first();
            return $newComment->load('user');
        } else {
            return 'error';
        }
    }

    public function getComments($entity, $entityId){
        $comments = [];
        switch($entity){
            case 'submission':
                $model = Submission::find($entityId);
                $model->load('comments.user');
                $comments = $model->comments;
                break;
            case 'day':
                $model = ChallengeDay::find($entityId);
                $model->load('comments.user');
                $comments = $model->comments;
                break;
            case 'challenge': 
                $model = Challenge::find($entityId);
                $model->load('comments.user');
                $comments = $model->comments;
                break;
            default: 
                break;
        }

        return $comments;
    }
}
