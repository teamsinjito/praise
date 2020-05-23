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

class PraiseController extends Controller
{
    use MyPraiseCount;
    
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

        //褒めた数を取得
        $myPraiseCount = DB::table('boards')
                        ->where('from_user_id',Auth::user()->id)
                        ->count();
        //褒められた数を取得
        $toMyPraiseCount = DB::table('boards')
                        ->where('to_user_id',Auth::user()->id)
                        ->count();
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
        DB::beginTransaction();

        try{
            $board = Board::create([
                'from_user_id'=>$auth_user->id,
                'to_user_id'=>$request->to_user,
                'stamp_id'=>$request->to_stamp,
                'message'=>$request->message
            ]);
    
            //ユーザアイコンを整形
            $from_user_img= CraftImageController::trimUserIconCircle(Image::make(storage_path('app/public/img/users/'.$board->from_user_id.'.png')));
            $to_user_img= CraftImageController::trimUserIconCircle(Image::make(storage_path('app/public/img/users/'.$board->to_user_id.'.png')));
    
            //スタンプを整形
            $stamp_img=CraftImageController::trimStampIcon(Image::make(storage_path('app/public/img/stamps/'.$board->stamp_id.'.png')));
    
            //看板を作成
            $board_img = Image::make(storage_path('app/public/img/templetes/board_temp1.png'));
            $board_img_message = Image::make(storage_path('app/public/img/templetes/board_temp1.png'));
    
            //矢印を整形
            $arrow_img = CraftImageController::trimArrowIcon(Image::make(storage_path('app/public/img/templetes/arrow.png')));
    
            //看板に挿入
            $board_img->insert($from_user_img,'top-left',300,300);
            $board_img->insert($to_user_img,'top-right',300,400);
            $board_img->insert($stamp_img,'bottom',0,400);
            $board_img->insert($arrow_img,'top',0,30);
    
            //日付挿入
            $board_img ->text(Carbon::now(), 2400, 2300, function($font) {
                $font->file(storage_path('fonts/851MkPOP_002.ttf'));
                $font->size(140);
                $font->align('center');
                $font->color('#444444');
                $font->angle(3);
            }); 
            //日付挿入
            $board_img_message ->text(Carbon::now(), 2400, 2300, function($font) {
                $font->file(storage_path('fonts/851MkPOP_002.ttf'));
                $font->size(140);
                $font->align('center');
                $font->color('#444444');
                $font->angle(3);
            }); 

            //メッセージ挿入
            //メッセージの文字数から改行処理を行う
            if(mb_strlen($board->message,'UTF-8') <=15){

                $message=$board->message;

            }else{
                $message= mb_substr($board->message,0,15)."\n".
                            mb_substr($board->message,15,15);
            }

            $board_img_message ->text($message, 1680, 1210, function($font) {
                $font->file(storage_path('fonts/851MkPOP_002.ttf'));
                $font->size(220);
                $font->align('center');
                $font->color('#444444');
                $font->angle(3);
            }); 
            $board_img->save(storage_path('app/public/img/boards/'.$board->id.'_1.png'));
            $board_img_message->save(storage_path('app/public/img/boards/'.$board->id.'_2.png'));

            DB::commit();

        }catch(\Exception $e){
            DB::rollback();

            echo "例外キャッチ：",$e->getMessage(),"\n";
        };



        return redirect()->route('home')->with('praised', $board->id);

    }


}
