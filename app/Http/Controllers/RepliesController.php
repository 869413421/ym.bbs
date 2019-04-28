<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Http\Requests\ReplyRequest;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    public function store(ReplyRequest $request, Reply $reply)
    {
        $reply->content = $request['content'];
        $reply->user_id = \Auth::id();
        $reply->topic_id = $request->topic_id;
        $reply->save();

        return redirect()->to($reply->topic->link())->with('success', '评论创建成功！');
    }

    public function destroy(Reply $reply)
    {
        $link = $reply->topic->link();
        $this->authorize('destroy', $reply);
        $reply->delete();

        return redirect()->to($link)->with('success', '删除成功');
    }
}