<?php
namespace App\Http\Traits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait MyPraiseCount{

    public function getMyPraiseCnt()
    {

        //褒めた数を取得
        $myPraiseCount = DB::table('boards')
                        ->where('from_user_id',Auth::user()->id)
                        ->count();

        return $myPraiseCount;
    }
    public function getMyPraisedCnt()
    {
        //褒められた数を取得
        $toMyPraiseCount = DB::table('boards')
                        ->where('to_user_id',Auth::user()->id)
                        ->count();

        return $toMyPraiseCount;
    }
}