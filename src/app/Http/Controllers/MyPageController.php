<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

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

    //レーダーチャート用に褒め履歴を集計
    public function showChart()
    {
        //スタンプ毎の褒めた数を集計
        $myPraiseList = DB::table('boards')
                        ->where('from_user_id',Auth::user()->id)
                        ->select('stamp_id','from_user_id');

        $sendStampSum = DB::table('stamps')
                        ->leftJoinSub($myPraiseList,'b',function($join){
                            $join->on('stamps.id','=','b.stamp_id');
                        })
                        ->groupBy('id')
                        ->select(DB::raw('id,count(b.from_user_id) as cnt1'));

        //スタンプ毎の褒められた数を集計                
        $myPraisedList = DB::table('boards')
                        ->where('to_user_id',Auth::user()->id)
                        ->select('stamp_id','to_user_id');

        $getStampSum = DB::table('stamps')
                        ->leftJoinSub($myPraisedList,'b',function($join){
                            $join->on('stamps.id','=','b.stamp_id');
                        })
                        ->groupBy('id')
                        ->select(DB::raw('id,count(b.to_user_id) as cnt2'));

        //それぞれの集計結果を結合
        $sum=DB::table('stamps')
            ->leftJoinSub($sendStampSum,'you',"you.id","stamps.id")
            ->leftJoinSub($getStampSum,'me',"me.id","stamps.id")
            ->select('stamps.name','you.cnt1','me.cnt2')
            ->get();

        return Response::json($sum);
    }

    //相関図用に褒め履歴を集計
    public function showdiagram()
    {
        //褒められた履歴（カウント）を集計
        $myPraisedCntList = DB::table('boards')
                        ->where('to_user_id',Auth::user()->id)
                        ->groupBy('to_user_id','from_user_id')
                        ->select(DB::raw('from_user_id,to_user_id,count(from_user_id) as hometa'));

        //褒めた履歴（カウント）を集計
        $mypraiseCntList=DB::table('boards')
                        ->where('from_user_id',Auth::user()->id)
                        ->groupBy('to_user_id','from_user_id')
                        ->select(DB::raw('from_user_id,to_user_id,count(to_user_id) as hometa'));

        //集計結果をUNION
        $total_praiseCntList=$mypraiseCntList->union($myPraisedCntList)->get();

        //褒められた履歴（ユーザ）を集計
        $myPraisedUserList=DB::table('boards')
                            ->leftJoin('users as u','u.id','=','from_user_id')
                            ->where('to_user_id',Auth::user()->id)
                            ->groupBy('from_user_id','u.name')
                            ->select('from_user_id as id','u.name');
        //褒めた履歴（ユーザ）を集計
        $myPraiseUserList=DB::table('boards')
                            ->leftJoin('users as u','u.id','=','to_user_id')
                            ->where('from_user_id',Auth::user()->id)
                            ->groupBy('to_user_id','u.name')
                            ->select('to_user_id as id','u.name');

        //集計結果をUNIONかつログインユーザの情報も加える
        $tota_praiseUserList=DB::table('users')
                            ->where('id',Auth::user()->id)
                            ->select('id','name')
                            ->union($myPraisedUserList)
                            ->union($myPraiseUserList)->get();



        return Response::json([$tota_praiseUserList,$total_praiseCntList]);

    }

    //編集保存
    public function EditProfile(Request $request)
    {
        DB::beginTransaction();

        try{

            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update([
                    'name' => $request->name,
                    'profile' => $request->profile,
                    'updated_at'=>Carbon::now()
                ]);
            
            if($request->file('img')){
                $request->file('img')->storeAs('public/img/users',Auth::user()->id.'.png');
                $img = Image::make(storage_path('app/public/img/users/'.Auth::user()->id.'.png'));
    
                $img->fit(400,400);
                $img->save(storage_path('app/public/img/users/'.Auth::user()->id.'.png'));

            }
            
            DB::commit();

        }catch(\Exception $e){
            
        }
        return redirect()->route('mypage',[
            'auth_user' => Auth::user()
        ]);
    }
}
