<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Community;
use App\Models\DisLike;
use App\Models\Like;
use App\Models\Post;
use App\Models\UserPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\CallLike;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sort = $request->input('sort');
        $sort = $sort ?? 'nou';
        
        $dataType = $request->input('dataType');

        $user = Auth::user();

        if ($dataType == 'subscribed' && $user) {
            $communityIds = $user->communities()->pluck('communities.id');

            return view('home-page', [
                'posts1' => Post::whereIn('community_id', $communityIds)
                    ->when($sort == 'antic', fn ($query) => $query->orderBy('created_at', 'asc'))
                    ->when($sort == 'nou', fn ($query) => $query->orderBy('created_at', 'desc'))
                    ->when($sort == 'popular', fn ($query) => $query->orderByRaw('(likes - dislikes) desc'))
                    ->get(),
            ]);
        } else {
            return view('home-page', [
                'posts1' => Post::when($sort == 'antic', fn ($query) => $query->orderBy('created_at', 'asc'))
                    ->when($sort == 'nou', fn ($query) => $query->orderBy('created_at', 'desc'))
                    ->when($sort == 'popular', fn ($query) => $query->orderByRaw('(likes - dislikes) desc'))
                    ->get(),
            ]);
        }
//        return view('home-page', ['posts1' =>  $sort == 'antic' ? Post::orderBy('created_at', 'asc')->get() : ($sort == 'nou' ? Post::orderBy('created_at', 'desc')->get() : Post::orderByRaw('(likes - dislikes) desc')->get())]);
    }

    public function like(Request $request, $postId)
    {
        $user = auth()->user();

        if ($user) {
            $existLike = Like::where('user_id', $user->id)->where('post_id', $postId)->first();
            $post = Post::find($postId);

            if (!$existLike) {
                Like::create([
                    'post_id' => $postId,
                    'user_id' => $user->id
                ]);

                if ($dislike = DisLike::where('user_id', $user->id)->where('post_id', $postId)->first()) {
                    $post->dislikes -= 1;
                    $dislike->delete();
                }

                $post->likes += 1;

            } else {
                $existLike->delete();

                $post->likes -=1;
            }
            $post->save();

            return back();
        } else {
            return redirect(route('login'));
        }
    }

    public function disLike(Request $request, $postId)
    {
        $user = auth()->user();

        if ($user) {
            $dislike = DisLike::where('user_id', $user->id)->where('post_id', $postId)->first();
            $post = Post::find($postId);

            if (! $dislike) {
                DisLike::create([
                    'post_id' => $postId,
                    'user_id' => $user->id,
                ]);

                if ($like = Like::where('user_id', $user->id)->where('post_id', $postId)->first()) {
                    $like->delete();
                    $post->likes -= 1;
                }

                $post->dislikes += 1;

            } else {
                $dislike->delete();

                $post->dislikes -= 1;
            }
            $post->save();
            return back();
        } else {
            return redirect(route('login'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    //! needs major refactoring: make CommentController handle the comment part
    public function show($post_id)
    {
        $post = Post::findOrFail($post_id);
        $allComments = $post->comments;
        return view('post-full', ['post' => $post, 'comments1' => $allComments]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($post_id)
    {
        $post = Post::findOrFail($post_id);
        $post->delete();

        return back();
    }

    public function save($post_id)
    {
        $user_id = auth()->user()->id;

        $existingRecord = UserPost::where('user_id', $user_id)
            ->where('post_id', $post_id)
            ->first();

        if ($existingRecord) {
            $existingRecord->delete();

            return redirect()->back();
        } else {
            UserPost::create([
                'user_id' => $user_id,
                'post_id' => $post_id,
            ]);

            return redirect()->back();
        }
    }
    public function sortSubscribed(Request $request)
    {
        $user = auth()->user();

        $communities = $user->communities;

        $posts = collect();

        foreach ($communities as $community) {
            $posts = $posts->merge($community->posts);
        }

        $sort = $request->input('sort');

        return view('home-page-subscribed',['posts' => $posts],  ['posts1' => $sort == 'antic' ? Post::orderBy('created_at', 'asc')->get() : ($sort == 'nou' ? Post::orderBy('created_at', 'desc')->get() : Post::orderByRaw('(likes - dislikes) desc')->get())]);
    }
}
