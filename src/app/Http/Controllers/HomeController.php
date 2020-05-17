<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //ユーザ情報取得(褒める・褒められた)

        //TL情報を取得する(6件)
    $boardPaths = \DB::table('boards')->orderBy('id', 'DESC')->take(9)->get();

    return view('home')->with('boardPaths', $boardPaths);
    }


}
