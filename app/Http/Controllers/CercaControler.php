<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CercaControler extends Controller
{
    public function cerca(Request $request){
        if($request->input('search') != null){
            $busqueda = $request->input('search');
            return redirect('/cerca/p/'.$busqueda);


        }
        else{
            return redirect('/');
        }
    }
    public function cercaposts($busqueda){
        $busquedaq = "%".$busqueda."%";
        $resultats = Post::where('title', 'like', $busquedaq)->get();
        //$posts = Post::all();
        return view('cerca')->with('resultats', $resultats)->with('busqueda', $busqueda)->with('type','p');

    }
    public function cercacoments($busqueda){
        $busquedaq = "%".$busqueda."%";
        $resultats = Comment::where('content', 'like', $busquedaq)->get();
        return view('cerca')->with('resultats', $resultats)->with('busqueda', $busqueda)->with('type','c');
    }
    public function update(UpdateProfileRequest $request){
        $user = auth()->user();
        if($request->input('bio') != null){
            $user->update(['bio' => $request->input('bio')]);
        }
        if($request->input('name') != null){
            $user->update(['name' => $request->input('name')]);
        }/*
        if($request->file('avatar') != null){
            $newAvatar = $request->file('avatar');
            $filename = $newAvatar->getClientOriginalName();
            $user->update(['avatar'=> '/images/avatars/' . $filename]);
        }*/
        /*
        if($request->file('banner') != null){
            $user->update(['bio' => $request->input('bio')]);
        }*/

        return redirect()->route('profile');
    }
}
