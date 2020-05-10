<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class MyPageController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function showMyPageForm(User $auth_user)
    {
        if(Auth::user()->id!==$auth_user->id){
            abort(403);
        }

        //ビューを返す
        return view('mypage');
    }
}
