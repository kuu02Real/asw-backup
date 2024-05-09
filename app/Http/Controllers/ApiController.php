<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\Comment;
use App\Models\Community;
use App\Models\DisLike;
use App\Models\DislikeComment;
use App\Models\Like;
use App\Models\LikeComment;
use App\Models\Post;
use App\Models\User;
use App\Models\UserComment;
use App\Models\UserPost;
use Aws\S3\S3Client;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApiController extends Controller
{
    public function posts(Request $request){

        $sort = $request->input('sort');
        $sort = $sort ?? 'new';

        $posts = Post::when($sort == 'old', fn ($query) => $query->orderBy('created_at', 'asc'))
                ->when($sort == 'new', fn ($query) => $query->orderBy('created_at', 'desc'))
                ->when($sort == 'popular', fn ($query) => $query->orderByRaw('(likes - dislikes) desc'))
                ->get();

        return response()->json($posts);
    }

    public function postsSubscribed(Request $request) {

        $sort = $request->input('sort');
        $user = auth()->user();

        $communityIds = $user->communities()->pluck('communities.id');
        $posts = Post::whereIn('community_id', $communityIds)
            ->when($sort == 'old', fn($query) => $query->orderBy('created_at', 'asc'))
            ->when($sort == 'new', fn($query) => $query->orderBy('created_at', 'desc'))
            ->when($sort == 'popular', fn($query) => $query->orderByRaw('(likes - dislikes) desc'))
            ->get();

        return response()->json($posts);
    }

    public function post(Request $request, $post_id){
        $post = Post::find($post_id);
        if($post != null){
            return response()->json($post);
        } else{
            return response()->json("Post not found", 404);
        }

    }

    public function userPosts(Request $request, $user_id){
        $user = User::find($user_id);
        if($user != null){
            $posts = $user->posts;
            return response()->json($posts);
        } else{
            return response()->json("User not found", 404);
        }

    }

    public function newPost(Request $request)
    {

        // Crear el post
        $post = new Post();
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->url = $request->input('url');
        $post->user_id = auth()->user()->id;
        $post->community_id = $request->input('community_id');
        $post->likes = 0;
        $post->disLikes = 0;
        $post->save();

        return response()->json(['message' => 'El post s\'ha creat correctament'], 201);
    }

    public function updatePost(Request $request, $post_id)
    {
        // Trobar el post a editar
        $post = Post::findOrFail($post_id);

        // Actualitzar les dades del post
        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->url = $request->input('url');
        $post->community_id = $request->input('community_id');
        $post->save();

        // Retornar una resposta satisfactòria
        return response()->json(['message' => 'Post actualitzat amb èxit'], 200);
    }

    public function deletePost($post_id)
    {
        // Trobar el post a esborrar
        $post = Post::findOrFail($post_id);

        $post->comments()->delete();
        // Esborrar el post
        $post->delete();

        // Retornar una resposta satisfactòria
        return response()->json(['message' => 'Post esborrat amb èxit'], 204);
    }

    public function likePost($post_id)
    {
        $user = auth()->user();
        $post = Post::find($post_id);
        if ($post) {
            $existLike = Like::where('user_id', $user->id)->where('post_id', $post_id)->first();

            if (!$existLike) {
                Like::create([
                    'post_id' => $post_id,
                    'user_id' => $user->id
                ]);
                $post->likes += 1;
            }

            if ($dislike = DisLike::where('user_id', $user->id)->where('post_id', $post_id)->first()) {
                $post->dislikes -= 1;
                $dislike->delete();
            }
            $post->save();

            return response()->json(['message' => 'Like processat amb èxit', 'post' => $post]);
        } else {
            return response()->json(['error' => 'Not found'], 404);
        }
    }

    public function dislikePost(Request $request, $post_id)
    {
        $user = auth()->user();
        $post = Post::find($post_id);
        if ($post) {
            $existDisLike = DisLike::where('user_id', $user->id)->where('post_id', $post_id)->first();

            if (!$existDisLike) {
                DisLike::create([
                    'post_id' => $post_id,
                    'user_id' => $user->id,
                ]);
                $post->dislikes += 1;
            }

            if ($like = Like::where('user_id', $user->id)->where('post_id', $post_id)->first()) {
                $post->likes -= 1;
                $like->delete();
            }
            $post->save();

            return response()->json(['message' => 'Dislike processat amb èxit', 'post' => $post]);
        } else {
            return response()->json(['error' => 'Not found'], 404);
        }
    }

    public function unlikePost(Request $request, $post_id)
    {
        $user = auth()->user();
        $post = Post::find($post_id);
        if ($post) {
            if ($dislike = DisLike::where('user_id', $user->id)->where('post_id', $post_id)->first()) {
                $post->dislikes -= 1;
                $dislike->delete();
            }

            if ($like = Like::where('user_id', $user->id)->where('post_id', $post_id)->first()) {
                $post->likes -= 1;
                $like->delete();
            }
            $post->save();

            return response()->json(['message' => 'Unlike processat amb èxit', 'post' => $post]);
        } else {
            return response()->json(['error' => 'Not found'], 404);
        }


    }

    public function savePost(Request $request, $post_id)
    {
        $user_id = \auth()->user()->id;
        $post = Post::where('id', $post_id)->first();

        if (! $post) {
            return response()
                ->json(['error' => 'Aquest post no existeix, indica un post vàlid'], 404);
        }

        $savedPost = UserPost::where('user_id', $user_id)
            ->where('post_id', $post_id)->first();

        if (! $savedPost) {
            UserPost::create([
                'user_id' => $user_id,
                'post_id' => $post_id,
            ]);

            return response()->json(['message' => 'Post guardat amb èxit'], 200);
        }

        return response()->json(['message' => 'El post ja està guardat'], 200);
    }

    public function unsavePost(Request $request, $post_id)
    {
        $user_id = \auth()->user()->id;
        $post = Post::where('id', $post_id)->first();

        if (! $post) {
            return response()
                ->json(['error' => 'Aquest post no existeix, indica un post vàlid'], 404);
        }

        $savedPost = UserPost::where('user_id', $user_id)
            ->where('post_id', $post_id)->first();

        if ($savedPost) {
            $savedPost->delete();

            return response()->json(['message' => 'Post unsaved amb èxit'], 200);
        }

        return response()->json(['message' => 'El post no està guardat'], 200);
    }

    public function newComment(Request $request) {

        $data = $request->all();

        if (Arr::exists($data, 'content')) {
            $post = Post::find($data['post_id']);
            if (!$post) {
                return response()->json(['message' => 'You must provide a valid post ID.'], 422);
            }

            if (!Arr::exists($data, 'content')) {
                return response()->json(['message' => 'The comment must have non-empty content.'], 422);
            }
            else if ($data['content'] == '') {
                return response()->json(['message' => 'The comment must have non-empty content.'], 422);
            }
            else {
                if (Arr::exists($data, 'comment_id')) {

                    $parentComment = Comment::where('id', $data['comment_id'])->first();
                    if (!$parentComment) {
                        return response()->json(['message' => 'Parent comment not found.'], 422);
                    }
                    if ($data['post_id'] != $parentComment->post_id) {
                        return response()->json(['message' => 'The parent comment does not belong to this post.'], 422);
                    }
                }

                $data['user_id'] = auth()->id();
                $data['likes'] = 0;
                $data['dislikes'] = 0;

                $comment = Comment::create($data);

                return response()->json(['message' => 'Comment successfully created', 'comment'=>$comment], 201);
            }

        }
        else {
            return response()->json(['message' => 'You must provide a valid post ID.'], 422);
        }

    }
    public function deleteComment($comment_id)
    {
        $comment = Comment::find($comment_id);

        if ($comment) {

            if (auth()->id() == $comment->user_id) {
                $comment->delete();

                return response()->json(['message' => 'Comment deleted successfully.'], 200);
            }
            else return response()->json(['message' => 'You provided an invalid token'], 403);
        }
        else {
            return response()->json(['message' => 'Comment not found.'], 404);
        }
    }

    public function updateComment(Request $request, $comment_id)
    {
        $comment = Comment::find($comment_id);

        if ($comment) {
            if (auth()->id() == $comment->user_id) {
                $comment->update([
                    'content' => $request->input('content'),
                    'edited' => 1,
                ]);
                return response()->json(['message' => 'Comment updated successfully.'], 200);
            }
            else return response()->json(['message' => 'You provided an invalid token'], 403);
        }
        else {
            return response()->json(['message' => 'Comment not found.'], 404);
        }
    }


    public function likeComment($commentId)
    {
        $user = auth()->user();
        $comment = Comment::find($commentId);
        if ($comment) {
            $existLike = LikeComment::where('user_id', $user->id)->where('comment_id', $commentId)->first();

            if (!$existLike) {
                LikeComment::create([
                    'comment_id' => $commentId,
                    'user_id' => $user->id,
                ]);
                $comment->likes += 1;
            }

            $dislike = DislikeComment::where('user_id', $user->id)->where('comment_id', $commentId)->first();

            if ($dislike) {
                $comment->dislikes -= 1;
                $dislike->delete();
            }

            $comment->save();

            return response()->json(['message' => 'You now like this comment.', 'comment' => $comment], 201);

        } else {
            return response()->json(['message' => 'Invalid comment ID.'], 422);
        }
    }

    public function dislikeComment($commentId)
    {
        $user = auth()->user();
        $comment = Comment::find($commentId);
        if ($comment) {
            $dislike = DislikeComment::where('user_id', $user->id)->where('comment_id', $commentId)->first();

            if (! $dislike) {
                DislikeComment::create([
                    'comment_id' => $commentId,
                    'user_id' => $user->id,

                ]);
                $comment->dislikes += 1;
            }

            $like = LikeComment::where('user_id', $user->id)->where('comment_id', $commentId)->first();

            if ($like) {
                $like->delete();
                $comment->likes -= 1;
            }

            $comment->save();

            return response()->json(['message' => 'You now dislike this comment.', 'comment' => $comment], 201);

        } else {
            return response()->json(['message' => 'Invalid comment ID.'], 422);
        }
    }

    public function unlikeComment($commentId)
    {
        $user = auth()->user();
        $comment = Comment::find($commentId);
        if ($comment) {
            $dislike = DislikeComment::where('user_id', $user->id)->where('comment_id', $commentId)->first();
            if ($dislike) {
                $comment->dislikes -= 1;
                $dislike->delete();
            }
            $like = LikeComment::where('user_id', $user->id)->where('comment_id', $commentId)->first();
            if ($like) {
                $like->delete();
                $comment->likes -= 1;
            }
            $comment->save();

            return response()->json(['message' => 'You have unliked this comment.', 'comment' => $comment], 201);

        } else {
            return response()->json(['message' => 'Invalid comment ID.'], 422);
        }
    }

    public function saveComment($comment_id)
    {
        if (Comment::find($comment_id)) {
            $user_id = auth()->user()->id;
            $existingRecord = UserComment::where('user_id', $user_id)
                ->where('comment_id', $comment_id)
                ->first();

            if (!$existingRecord) {
                UserComment::create([
                    'user_id' => $user_id,
                    'comment_id' => $comment_id,
                ]);
            }


            return response()->json(['message' => 'You have saved this comment.'], 201);

        }
        else {
            return response()->json(['message' => 'Comment not found.'], 404);
        }
    }

    public function unsaveComment($comment_id)
    {
        if (Comment::find($comment_id)) {
            $user_id = auth()->user()->id;
            $existingRecord = UserComment::where('user_id', $user_id)
                ->where('comment_id', $comment_id)
                ->first();

            if ($existingRecord) {
                $existingRecord->delete();
            }
            return response()->json(['message' => 'You have unsaved this comment.'], 201);
        }
        else {
            return response()->json(['message' => 'Comment not found.'], 404);
        }
    }


    public function postComments(Request $request, $post_id)
    {
        $post = Post::find($post_id);

        if ($post) {
            $sort = $request->input('sort');

            //if the request contains a sorting criteria
            if ($sort) {
                if ($sort == 'old' or $sort == 'new' or $sort == 'popular') {
                    $comments = Comment::where('post_id', '=', $post_id)
                        ->when($sort == 'old', fn ($query) => $query->orderBy('created_at', 'asc'))
                        ->when($sort == 'new', fn ($query) => $query->orderBy('created_at', 'desc'))
                        ->when($sort == 'popular', fn ($query) => $query->orderByRaw('(likes - dislikes) desc'))
                        ->get();
                    return response()->json($comments, 200);
                }
                else {
                    return response()->json(['message' => 'Invalid sort criteria.'], 422);
                }
            }
            //if sort is not defined in the request
            else {
                return response()->json($post->comments, 200);
            }
        }
        else {
            return response()->json(['message' => 'Post not found.'], 404);
        }

    }

    public function commentReplies(Request $request, $comment_id)
    {
        $parent = Comment::find($comment_id);
        if ($parent) {
            return response()->json($parent->replies, 200);
        }
        else {
            return response()->json(['message' => 'Comment not found.'], 404);
        }
    }

    public function newCommunity(Request $request) {
        $data = $request->all();

        if (Arr::exists($data, 'idComm')) {
            $id = $data['idComm'];

            $existeixId = Community::where('idComm', $id)->exists();

            if ($existeixId) {
                return response()->json(['message' => 'Already exists a community with the same ID'], 409);
            }
        } else {
            return response()->json()(['message' => 'A community needs an ID', 422]);
        }
        if (Arr::exists($data, 'image')) {
            $image = $data['image'];

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif']; // Lista de extensiones de imagen permitidas

            $fileExtension = pathinfo($image, PATHINFO_EXTENSION);
            //imatge no valida
            if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                return response()->json(['message' => 'Icon is not a valid image'], 422);
            }
        }

        if (Arr::exists($data, 'banner')) {
            $image = $data['banner'];

            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            $fileExtension = pathinfo($image, PATHINFO_EXTENSION);
            //imatge no valida
            if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                return response()->json(['message' => 'Banner is not a valid image'], 422);
            }
        }

        $community = new Community();
        $community->name = $request->input('name');
        $community->image = $request->input('image');
        $community->banner = $request->input('banner');
        $community->idComm = $request->input('idComm');
        $community->save();

        return response()->json(['message' => 'Community created successfully'], 200);
    }

    public function communitySubscribe(Request $request, $idComm) {
        $user = auth()->user();
        $community = Community::where('idComm', $idComm)->first();

        if ($community) {

            if ($user->communities->contains($community)) {

                return response()->json(['message' => 'Already subscribed to this community'], 409);
            }

            $user->communities()->attach($community);

            return response()->json(['message' => 'User subscribed to the community successfully'], 200);
        } else {
            return response()->json(['message' => 'Community ID does not exist / is incorrect'], 422);
        }
    }

    public function communityUnsubscribe(Request $request, $idComm) {
        $user = auth()->user();
        $community = Community::where('idComm', $idComm)->first();

        if ($community) {

            if (!$user->communities->contains($community)) {

                return response()->json(['message' => 'User is not subscribed to this community'], 409);
            }

            $user->communities()->detach($community);

            return response()->json(['message' => 'User unsubscribed from the community successfully'], 200);
        } else {
            return response()->json(['message' => 'Community ID does not exist / is incorrect'], 422);
        }
    }

    public function postsFromCommunity(Request $request, $idComm) {
        $community = Community::where('idComm', $idComm)->first();

        if ($community) {
            $posts = $community->posts;

            if ($posts->isEmpty()) {
                return response()->json(['message' => 'No posts found for this community'], 201);
            } else {
                return response()->json(['posts' => $posts], 200);
            }
        } else {
            return response()->json(['message' => 'Community ID does not exist / is incorrect'], 422);
        }
    }

    public function commentsFromCommunity(Request $request, $idComm) {
        $community = Community::where('idComm', $idComm)->first();

        if ($community) {
            $comments = $community->through('posts')->has('comments')->get();

            if ($comments->isEmpty()) {
                return response()->json(['message' => 'No comments found for this community'], 201);
            } else {
                return response()->json(['posts' => $comments], 200);
            }
        } else {
            return response()->json(['message' => 'Community ID does not exist / is incorrect'], 422);
        }
    }

    public function subscribedCommunities(Request $request) {
        $user = auth()->user();

        if ($user) {
            $subscribedCommunities = $user->communities;

            if ($subscribedCommunities->isEmpty()) {
                return response()->json(['message' => 'You are not subscribed to any communities!'], 201);
            } else {
                return response()->json(['communities' => $subscribedCommunities], 200);
            }
        } else {
            return response()->json(['message' => 'Error with auth from the user'], 422);
        }

    }

    public function logged_user(Request $request){
        return response()->json(auth()->user());
    }
    public function savedPosts(Request $request){
        $desats = auth()->user()->savedPosts;
        return response()->json($desats);
    }
    public function savedComments(Request $request){
        $desats = auth()->user()->savedComments;
        return response()->json($desats);
    }
    public function users(Request $request){
        $users = User::all();
        return response()->json($users);
    }
    public function user(Request $request, $user_id){
        $user = User::findOrFail($user_id);
        return response()->json($user);
    }
    public function editUserInfo(Request $request){
        $user = auth()->user();
        $user->update(['name'=>$request->name]);
        $user->update(['bio'=>$request->bio]);
        return response()->json($user);
    }
    public function editUserAvatar(UpdateProfileRequest $request){
        $s3 = new S3Client([
            'version' => 'latest',
            'region' => 'us-east-1', // Cambia la región según tu configuración.
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
                'token' => env('AWS_ACCESS_TOKEN'),
            ],
        ]);
        $user = auth()->user();
        if ($request->hasFile('avatar')){
            $file = $request->file('avatar');
            $path = 'images/user/' . $user->id . '/avatar.' . $file->getClientOriginalExtension();

            Storage::disk('s3')->setVisibility($path,'public');

            $s3->putObject([
                'Bucket' => 'tincganabucket',
                'Key' => $path,
                'SourceFile' => $file->getRealPath(),
            ]);
            $user->update(['avatar' => $path]);
        }
        return response()->json($user);
    }
    public function editUserBanner(UpdateProfileRequest $request){
        $s3 = new S3Client([
            'version' => 'latest',
            'region' => 'us-east-1', // Cambia la región según tu configuración.
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
                'token' => env('AWS_ACCESS_TOKEN'),
            ],
        ]);
        $user = auth()->user();
        if ($request->hasFile('banner')){
            $file = $request->file('banner');
            $path = 'images/user/' . $user->id . '/banner.' . $file->getClientOriginalExtension();

            Storage::disk('s3')->setVisibility($path,'public');

            $s3->putObject([
                'Bucket' => 'tincganabucket',
                'Key' => $path,
                'SourceFile' => $file->getRealPath(),
            ]);
            $user->update(['banner' => $path]);
        }
        return response()->json($user);
    }

    public function communities(Request $request){
        $communities = Community::all();
        return response()->json($communities);
    }
    public function community(Request $request, $idComm){
        $community = Community::where('idComm', $idComm)->first();
        return response()->json($community);
    }

    public function comments(Request $request){
        $comments = Comment::all();
        return response()->json($comments);
    }
    public function comment(Request $request, $comment_id){
        $comment = Comment::find($comment_id);
        if($comment != null) {
            return response()->json($comment);
        } else {
            return response()->json("Comment not found");
        }
    }
    public function userComments(Request $request, $user_id){
        $user = User::find($user_id);
        if($user != null) {
            $comments = $user->comments;
            return response()->json($comments);
        } else{
            return response()->json("User not found");
        }
    }

    public function cercaPosts(Request $request, $cerca){
        $busquedaq = "%".$cerca."%";
        $resultats = Post::where('title', 'like', $busquedaq)->get();
        return response()->json($resultats);
    }
    public function cercaComments(Request $request, $cerca){
        $busquedaq = "%".$cerca."%";
        $resultats = Comment::where('content', 'like', $busquedaq)->get();
        return response()->json($resultats);
    }
}
