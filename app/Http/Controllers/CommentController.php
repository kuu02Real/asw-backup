<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\UserComment;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\LikeComment;
use App\Models\DislikeComment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of comments in a post
     */
    public function index(Request $request, $post_id)
    {
        $sort = $request->input('sort');
        $post = Post::findOrFail($post_id);

        $user = Auth::user();

        return view('post-full', [
            'post' => $post,
            'comments1' => Comment::where('post_id', '=', $post_id)
                ->when($sort == 'antic', fn ($query) => $query->orderBy('created_at', 'asc'))
                ->when($sort == null or 'nou', fn ($query) => $query->orderBy('created_at', 'desc'))
                ->when($sort == 'popular', fn ($query) => $query->orderByRaw('(likes - dislikes) desc'))
                ->get(),
        ]);

    }
    /**
     * Show the form for creating a new resource. Requires a post
     */
    public function create()
    {
        //
    }

    public function like(Request $request, $commentId)
    {
        $user = auth()->user();

        if ($user) {
            $existLike = LikeComment::where('user_id', $user->id)->where('comment_id', $commentId)->first();
            $comment = Comment::find($commentId);

            if (!$existLike) {
                LikeComment::create([
                    'comment_id' => $commentId,
                    'user_id' => $user->id,
                ]);

                if ($dislike = DislikeComment::where('user_id', $user->id)->where('comment_id', $commentId)->first()) {
                    $comment->dislikes -= 1;
                    $dislike->delete();
                }

                $comment->likes += 1;

            } else {
                $existLike->delete();

                $comment->likes -=1;
            }
            $comment->save();

            return back();
        } else {
            return redirect(route('login'));
        }
    }

    public function dislike(Request $request, $commentId)
    {
        $user = auth()->user();

        if ($user) {
            $dislike = DislikeComment::where('user_id', $user->id)->where('comment_id', $commentId)->first();
            $comment = Comment::find($commentId);

            if (! $dislike) {
                DislikeComment::create([
                    'comment_id' => $commentId,
                    'user_id' => $user->id,
                ]);

                if ($like = LikeComment::where('user_id', $user->id)->where('comment_id', $commentId)->first()) {
                    $like->delete();
                    $comment->likes -= 1;
                }

                $comment->dislikes += 1;

            } else {
                $dislike->delete();

                $comment->dislikes -= 1;
            }
            $comment->save();
            return back();
        } else {
            return redirect(route('login'));
        }
    }



    /**
     * Store a newly created resource in storage.
     * The request must contain the fields: content, post_id
     * The request might contain the field comment_id if it is in response to another comment
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'post_id' => 'required'
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['likes'] = 0;
        $data['dislikes'] = 0;
        Comment::create($data);

        return redirect()->route('post', ['post_id' => $request['post_id']])->with('success', 'Comentario publicado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($comment_id)
    {
        $comment = Comment::findOrFail($comment_id);
        return view('comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $comment_id)
    {
        $comment = Comment::findOrFail($comment_id);

        if ($comment) {

            $request->validate([
                'content' => 'required'
            ]);

            if (auth()->id() == $comment->user_id) {
                $comment->update([
                    'content' => $request->input('content'),
                    'edited' => 1,
                ]);
            }

        }

        return redirect()->route('post', ['post_id' => $comment->post_id])->with('success', 'Comentario editado exitosamente.');
    }

    /**
     * Flags a comment as deleted, which makes it not appear in any search
     * Allows "deletion" of comments while preserving the comment thread
     */
    public function destroy($comment_id)
    {
        $comment = Comment::findOrFail($comment_id);

        if ($comment) {

            if (auth()->id() == $comment->user_id) {
                $comment->delete();
            }

        }

        return redirect()->route('post', ['post_id' => $comment->post_id])->with('success', 'Comentari esborrat.');
    }

    public function commentsByUser($user_id) {
        $user = User::find($user_id);

        if ($user) return $user->comments;
        else return [];
    }

    public function save($comment_id)
    {
        $user_id = auth()->user()->id;

        $existingRecord = UserComment::where('user_id', $user_id)
            ->where('comment_id', $comment_id)
            ->first();

        if ($existingRecord) {
            $existingRecord->delete();

            return redirect()->back();
        } else {
            UserComment::create([
                'user_id' => $user_id,
                'comment_id' => $comment_id,
            ]);

            return redirect()->back();
        }
    }
}
