<?php

namespace App\Http\Controllers;

use App\Good;
use App\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\PostComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Http\Traits\MyPraiseCount;
use App\Http\Traits\GetBoardsInfo;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    use MyPraiseCount;
    use GetBoardsInfo;


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

        $boardPaths=$this->getBoards(
            $this->getBoardComments(),
            $this->getBoardFavorites(),
            $this->getMyFavoriteCnt(),
            2,
            0
        );

        return view('home')->with([
            'boardPaths'=>$boardPaths,
            'myPraiseCount'=>$this->getMyPraiseCnt(),
            'toMyPraiseCount'=>$this->getMyPraisedCnt()
            ]);
    }

    //コメント一覧取得
    public function showCommentList(int $board_id)
    {
        $commentList = DB::table('boards')
                        ->join('comments','boards.id','=','comments.board_id')
                        ->leftJoin('users','comments.user_id','=','users.id')
                        ->where('boards.id','=',$board_id)
                        ->orderBy('comments.created_at','DESC')
                        ->select('users.image','users.name','comments.comment','comments.created_at')
                        ->get();
        return Response::json($commentList);
    }

    //コメント投稿
    public function postComment(int $board_id,PostComment $request)
    {
        $data = $request->all();
        $comment = $data['comment'];

        $comment  = Comment::create([
            'board_id'=>$board_id,
            'user_id'=>Auth::user()->id,
            'comment'=>$comment
        ]);

        $commentList = DB::table('boards')
                ->join('comments','boards.id','=','comments.board_id')
                ->leftJoin('users','comments.user_id','=','users.id')
                ->where('boards.id','=',$board_id)
                ->orderBy('comments.created_at','DESC')
                ->select('users.image','users.name','comments.comment','comments.created_at')
                ->get();

        return Response::json($commentList);
    }

    //いいねボタン押下処理
    public function postGood(int $board_id,Request $request)
    {
        $data = $request->all();
        $pushedFlg = $data['pushedFlg'];

        # code...
        //いいね数を増減
        if($pushedFlg==1){
            $board = Good::where('board_id',$board_id)->where('user_id',Auth::user()->id)
                        ->delete();
        }else{
            $board = Good::create([
                'board_id'=>$board_id,
                'user_id'=>Auth::user()->id
            ]);

        }

        //ボードのいいね数を取得
        $goodCnt = DB::table('goods')
                    ->where('board_id',$board_id)
                    ->select(DB::raw('COALESCE(count(board_id),0) as cnt'))->get();

        return Response::json($goodCnt);
    }

    //スクロール時ボード取得
    public function getGood(int $page)
    {
        $boardPaths=$this->getBoards(
            $this->getBoardComments(),
            $this->getBoardFavorites(),
            $this->getMyFavoriteCnt(),
            2,
            $page
        );         
                    
        return Response::json($boardPaths);
    }

}
