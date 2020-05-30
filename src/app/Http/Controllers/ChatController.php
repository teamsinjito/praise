<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Chat;
use App\Http\Traits\MyPraiseCount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ChatController extends Controller
{
    use MyPraiseCount;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showMainList(User $auth_user){

        if(Auth::user()->id!==$auth_user->id){
            abort(403);
        }
        try{
            $union1 = DB::table('chats')
                ->select('from_user_id as f','to_user_id as t','message','created_at');
            $union2 = DB::table('chats')
                ->select('to_user_id as f','from_user_id as t','message','created_at');

            $ti=$union1->union($union2)->toSql();

            $main=DB::table(DB::raw('('.$ti.') AS ti'))
                ->where('ti.f','=',':user_id')
                ->select('ti.t','ti.message','ti.created_at')->toSql(); 
        // $sub=DB::table(DB::raw('('.$ti.') AS ti'))
        //     ->whereRaw('ti.f=?',1)
        //     ->select('ti.t','ti.message','ti.created_at')->toSql(); 
        // var_dump($sub);
            $mains=DB::table(DB::raw('('.$main.') AS main'))
                ->whereRaw('main.created_at=(select max(sub.created_at) from('.DB::table(DB::raw('('.$ti.') AS ti'))->whereRaw('ti.f='.Auth::user()->id)->select('ti.t','ti.message','ti.created_at')->toSql().') AS sub where main.t=sub.t)')
                ->setBindings([':user_id'=>Auth::user()->id])
                
                ->select('main.*');

            // var_dump($mains);
            $list = DB::table('users as uuu')
                ->leftjoinSub($mains,'mains',function($join){
                    $join->on('uuu.id','=','mains.t');
                })
                ->where('uuu.id','!=',Auth::user()->id)
                ->orderByRaw('mains.created_at IS NULL ASC')
                ->orderBy('mains.created_at', 'DESC')
                ->select('uuu.id','uuu.name','uuu.image','mains.*')
                ->get();
            
            // var_dump($list);

            //ビューを返す
            return view('chat',[
                'userList'=>$list,
                'myPraiseCount'=>$this->getMyPraiseCnt(),
                'toMyPraiseCount'=>$this->getMyPraisedCnt()
            ]);

        }catch(\Exception $e){
            echo('例外キャッチ:'.$e->getMessage());
        }
        //自分以外のユーザリストを取得
        // $userList = DB::table('users')->where('id','!=',$auth_user->id)->get();

        // $list =DB::table('users')

    }

    //ユーザ毎のチャット画面を表示
    public function showChartForm(int $to_user){

        $union = DB::table('chats')
            ->where('from_user_id','=',Auth::user()->id)
            ->where('to_user_id','=',$to_user)
            ->select('from_user_id','message','created_at');
        $chatlist=DB::table('chats')
            ->where('to_user_id','=',Auth::user()->id)
            ->where('from_user_id','=',$to_user)
            ->select('from_user_id','message','created_at')
            ->union($union)
            ->orderBy('created_at')
            ->get();

        return Response::json($chatlist);
    }

    public function postChatForm(int $to_user,Request $request){
        $data = $request->all();
        $comment = $data['comment'];

        $newMessage  = Chat::create([
            'from_user_id'=>Auth::user()->id,
            'to_user_id'=>$to_user,
            'message'=>$comment
        ]);

        return Response::json($newMessage);
    }
}
