<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Community;
use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Aws\S3\S3Client;

class CommunityController extends Controller
{
    //
    public function index() {
        //obté llista de comunitats sencera

        $communities = Community::all();

        // pasa llista comunitats a la vista
        return view('communities.index', ['communities' => $communities]);

        //return view('communities.index');
    }

    public function create() {
        return view('communities.create');
    }

    public function show($idComm) {
        $community = Community::where('idComm', $idComm)->first();
        $posts = collect($community->posts);

        return view('communities.show', ['community' => $community], ['posts' => $posts]);
    }
    public function showComments($idComm) {
        $community = Community::where('idComm', $idComm)->first();

        $comments = $community->through('posts')->has('comments')->get();

        return view('communities.showcomments', ['community' => $community], ['comments' => $comments]);

    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'nullable',
            'image' => 'nullable|image',
            'banner' => 'nullable|image',
            'idComm' => 'required|unique:communities,idComm'
        ]);

        $s3 = new S3Client([
            'version' => 'latest',
            'region' => 'us-east-1', // Cambia la región según tu configuración.
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
                'token' => env('AWS_ACCESS_TOKEN'),
            ],
        ]);

        if ($request->hasFile('image')){
            $file = $request->file('image');
            $path = 'images/' . $request->idComm . '/' . 'icon' . '.' . $file->getClientOriginalExtension();

            Storage::disk('s3')->setVisibility($path,'public');

            $s3->putObject([
                'Bucket' => 'tincganabucket',
                'Key' => $path,
                'SourceFile' => $file->getRealPath(),
            ]);
            $data['image'] = $path;

        }
        if ($request->hasFile('banner')){
            $file = $request->file('banner');
            $path = 'images/' . $request->idComm . '/' . 'banner' . '.' . $file->getClientOriginalExtension();

            Storage::disk('s3')->setVisibility($path,'public');

            $s3->putObject([
                'Bucket' => 'tincganabucket',
                'Key' => $path,
                'SourceFile' => $file->getRealPath(),
            ]);
            $data['banner'] = $path;
        }

        $newCommunity = Community::create($data);

        $communities = Community::with('posts')->get();
        return redirect(route('community.index'));
    }

    public function subscribe($idCom) {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }
        $communityToSubscribe = Community::where('idComm', $idCom)->first();

        $user->communities()->toggle($communityToSubscribe);

        return redirect()->route('community.index');
    }

    public function listSubscribed() {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $allCommunities = collect($user->communities);


        return view('communities.index', ['communities' => $allCommunities]);
    }

    public function comments(): HasManyThrough {
        return $this->hasManyThrough(
            Comment::class,
            Post::class,
            'community_id',
            'post_id',
            'idComm',
            'id'
        );
    }

}
