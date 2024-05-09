<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Aws\S3\S3Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function update(UpdateProfileRequest $request){
        $user = auth()->user();
        if($request->input('bio') != null){
            $user->update(['bio' => $request->input('bio')]);
        }
        if($request->input('name') != null){
            $user->update(['name' => $request->input('name')]);
        }

        $s3 = new S3Client([
            'version' => 'latest',
            'region' => 'us-east-1', // Cambia la región según tu configuración.
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
                'token' => env('AWS_ACCESS_TOKEN'),
            ],
        ]);

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

        return redirect()->route('profile');
    }

    public function posts(){
        $posts = auth()->user()->posts;
        return view('profileposts')->with('posts',$posts);
    }
    public function comentaris(){
        $comentaris = auth()->user()->comments;
        return view('profilecoments')->with('comentaris',$comentaris);
    }
    public function desats(Request $request){
        $dataType = $request->input('dataType');

        if ($dataType == 'posts' || !$dataType) {
            $desats = auth()->user()->savedPosts;
            return view('profiledesats')->with('desats',$desats)->with('dataType', $dataType);
        }
        else if ($dataType == 'comentaris') {
            $desats = auth()->user()->savedComments;
            return view('profiledesats')->with('desats',$desats)->with('dataType', $dataType);
        }
        else return response()->json(['message' => 'error'], 500);
    }
    public function desatsComentaris(){
        $desats = auth()->user()->savedComments;
        return view('profiledesats')->with('desats',$desats);
    }
    public function editar(){
        return view('editprofile');
    }
    public function usuari($user_id, $type){
        $user = User::findOrFail($user_id);
        $content = [];
        if($type == 'posts'){
            $content = $user->posts;
        }
        else if($type == 'comentaris'){
            $content = $user->comments;
        }
        else if($type == 'desats'){
            $content = $user->savedPosts;
        }

        return view('user-profile')->with(['user'=> $user,'type'=> $type, 'content'=>$content]);
    }


}
