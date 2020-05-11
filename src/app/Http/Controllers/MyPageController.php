<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

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
        //褒めた数を取得
        $myPraiseCount = DB::table('boards')
                        ->where('from_user_id',Auth::user()->id)
                        ->count();
        //褒められた数を取得
        $toMyPraiseCount = DB::table('boards')
                        ->where('to_user_id',Auth::user()->id)
                        ->count();
        //ビューを返す
        return view('mypage',[
            'myPraiseCount'=>$myPraiseCount,
            'toMyPraiseCount'=>$toMyPraiseCount
        ]);
    }

    //褒めた履歴取得
    public function getMyPraiseList()
    {     
        //褒めた履歴取得
        $myBoardPaths = DB::table('boards')
                        ->where('from_user_id',Auth::user()->id)
                        ->select('id')
                        ->orderBy('id', 'desc')
                        ->limit(9)//取得するレコード数
                        ->get();

        return Response::json($myBoardPaths);

    }

    //スクロール最下時、褒めた履歴取得
    public function moreGetMyPraiseList(int $page)
    {     
        //褒めた履歴取得
        $myBoardPaths = DB::table('boards')
                        ->where('from_user_id',Auth::user()->id)
                        ->select('id')
                        ->orderBy('id', 'desc')
                        ->offset($page*9) //スキップするレコード数
                        ->limit(9)//取得するレコード数
                        ->get();

        return Response::json($myBoardPaths);

    }
    //褒められた履歴取得
    public function getToMyPraiseList()
    {
        
        $toMyBoardPaths = DB::table('boards')
                ->where('to_user_id',Auth::user()->id)
                ->select('id')
                ->orderBy('id', 'desc')
                ->limit(9)//取得するレコード数
                ->get();

        return Response::json($toMyBoardPaths);

    }

    //スクロール最下時、褒められた履歴取得
    public function moreGetToMyPraiseList(int $page)
    {     
        //褒めた履歴取得
        $toMyBoardPaths = DB::table('boards')
                        ->where('to_user_id',Auth::user()->id)
                        ->select('id')
                        ->orderBy('id', 'desc')
                        ->offset($page*9) //スキップするレコード数
                        ->limit(9)//取得するレコード数
                        ->get();

        return Response::json($toMyBoardPaths);

    }
}
