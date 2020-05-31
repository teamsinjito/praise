<?php

namespace App\Http\Controllers;

use App\Board;
use Illuminate\Http\Request;
use App\User;
use App\Stamp;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use App\Http\Requests\PraiseCreate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\MyPraiseCount;
use App\Http\Traits\CraftImage;

class PraiseController extends Controller
{
    use MyPraiseCount;
    use CraftImage;
    
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function showPraiseForm(User $auth_user)
    {
        if(Auth::user()->id!==$auth_user->id){
            abort(403);
        }
        // ユーザ情報取得
        $users = User::where('id','!=',$auth_user->id)->get();

        // スタンプ一覧取得
        $stamps = Stamp::all();

        //ビューを返す
        return view('praise', [
            'users' => $users,
            'stamps' => $stamps,
            'myPraiseCount'=>$this->getMyPraiseCnt(),
            'toMyPraiseCount'=>$this->getMyPraisedCnt()
        ]);
    }

    //褒めデータ保存
    public function praiseCreate(User $auth_user,PraiseCreate $request)
    {
        // $startTime = microtime(true);
        // $initialMemory = memory_get_usage();

        // 褒めるユーザレコード取得
        $to_usersImage = User::where('id','=',$request->to_user)->first();
        //使用するスタンプレコード取得
        $stampsImage = Stamp::where('id','=',$request->to_stamp)->first();

        //ユーザアイコンを整形
        if(empty(($auth_user->image))){
            $from_user_img= $this->trimUserIconCircle(Image::make(public_path('img/user_icon_default.png')));
        }else{
            $from_user_img= $this->trimUserIconCircle(Image::make(base64_decode($auth_user->image)));
        }

        if(empty(($to_usersImage->image))){
            $to_user_img= $this->trimUserIconCircle(Image::make(public_path('img/user_icon_default.png')));
        }else{           
            $to_user_img= $this->trimUserIconCircle(Image::make(base64_decode($to_usersImage->image)));
        }

        //スタンプを整形
        if(empty(($stampsImage->image))){
            $stamp_img=$this->trimStampIcon(Image::make(public_path('img/stamp_icon_default.png')));
        }else{
            $stamp_img=$this->trimStampIcon(Image::make(base64_decode($stampsImage->image)));
        }

        //看板を作成
        $board_img = Image::make(public_path('img/board_temp.png'));
        $board_img_message = Image::make(public_path('img/board_temp.png'));

        //矢印を整形
        $arrow_img = $this->trimArrowIcon(Image::make(public_path('img/arrow.png')));

        //看板に挿入
        $board_img->insert($from_user_img,'top-left',300,300);
        $board_img->insert($to_user_img,'top-right',300,400);
        $board_img->insert($stamp_img,'bottom',0,400);
        $board_img->insert($arrow_img,'top',0,30);

        //日付挿入
        $board_img ->text(Carbon::now(), 2400, 2300, function($font) {
            $font->file(public_path('fonts/851MkPOP_002.ttf'));
            $font->size(140);
            $font->align('center');
            $font->color('#444444');
            $font->angle(3);
        }); 
        //日付挿入
        $board_img_message ->text(Carbon::now(), 2400, 2300, function($font) {
            $font->file(public_path('fonts/851MkPOP_002.ttf'));
            $font->size(140);
            $font->align('center');
            $font->color('#444444');
            $font->angle(3);
        }); 

        //メッセージ挿入
        //メッセージの文字数から改行処理を行う
        if(mb_strlen($request->message,'UTF-8') <=15){

            $message=$request->message;

        }else{
            $message= mb_substr($request->message,0,15)."\n".
                        mb_substr($request->message,15,15);
        }

        $board_img_message ->text($message, 1680, 1210, function($font) {
            $font->file(public_path('fonts/851MkPOP_002.ttf'));
            $font->size(220);
            $font->align('center');
            $font->color('#444444');
            $font->angle(3);
        }); 

        //DBに登録
        $board = Board::create([
            'from_user_id'=>$auth_user->id,
            'to_user_id'=>$request->to_user,
            'stamp_id'=>$request->to_stamp,
            'message'=>$request->message,
            'image'=>base64_encode($board_img->stream('png', 50)),
            'image_message'=>base64_encode($board_img_message->stream('png', 50)),
        ]);

        return redirect()->route('home')->with('praised', $board);

        // $runningTime =  microtime(true) - $startTime;
        // $usedMemory = (memory_get_peak_usage() - $initialMemory) / (1024 * 1024);

        // var_dump('running time: ' . $runningTime . ' [s]'); // or var_dump()
        // var_dump('used memory: ' . $usedMemory . ' [MB]'); // or var_dump()

    }


}
