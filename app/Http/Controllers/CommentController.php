<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Call;

class CommentController extends Controller
{
    public function store(Request $request, Call $call)
    {
        $data = $request->all();
        $data['call_id'] = $call->id;
        $data['user_id'] = auth()->user()->id;
        $comment = Comment::create($data);
        return redirect()->back();
    }

    public function delete(Comment $comment)
    {
        $comment = Comment::findOrFail($comment->id);
        $comment->delete();
        session()->flash('alert', ['type' => 'success', 'message' => 'Comentário Excluído!']);
        return redirect()->back();
    }
}
