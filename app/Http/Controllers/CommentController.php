<?php

namespace Modules\DepartamentiShitjes\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Modules\DepartamentiShitjes\Models\DshComments;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('departamentishitjes::index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'comment_type' => 'required',
            'comment' => 'required', // assuming you have a projects table
        ]);


        $user = User::find(Auth::user()->id);

        $comment = new DshComments();
        $comment->comment_type = $request->comment_type;
        $comment->comment = $request->comment;
        $comment->user_id =  $user->name; // or $request->user_id if passed explicitly
        $comment->project_id = $id;
        $comment->save();

        return redirect()->back()->with('success', 'Komenti u ruajt me sukses!');
    }

}