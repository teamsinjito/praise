<?php
namespace App\Http\Traits;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait GetBoardsInfo{

    //ログインユーザが既にいいねを押したボードを取得
    public function getMyFavoriteCnt()
    {
        $pushedGoodBtn = DB::table('goods')
                ->where('user_id',Auth::user()->id)
                ->groupBy('board_id','user_id')
                ->select('board_id','user_id');

        return $pushedGoodBtn;
    }

    //ボード毎のコメント数を取得
    public function getBoardComments()
    {
        $commentCnt = DB::table('comments')
            ->groupBy('board_id')
            ->select(DB::raw('board_id,count(board_id) as cnt'));

        return $commentCnt;
    }

    //ボード毎のいいね数を取得
    public function getBoardFavorites()
    {
        $goodCnt = DB::table('goods')
                ->groupBy('board_id')
                ->select(DB::raw('board_id,count(board_id) as cnt'));

        return $goodCnt;
    }

    //ボードを取得
    public function getBoards($commentT,$goodT,$pushedT,int $whereId, int $bid)
    {
        $LIMITCNT = 20; //取得する件数

        $whereList = [
            //褒められた履歴抽出
            0 => [      
                'field' => 'to_user_id',
                'value' => Auth::user()->id
            ],
            //褒めた履歴抽出
            1 => [
                'field' => 'from_user_id',
                'value' => Auth::user()->id
            ],
        ];

        $boards = DB::table('boards as b')
                ->leftJoinSub($commentT,'c',function($join){
                    $join->on('b.id','=','c.board_id');
                })
                ->leftJoinSub($goodT,'g',function($join){
                    $join->on('b.id','=','g.board_id');
                })
                ->leftJoinSub($pushedT,'p',function($join){
                    $join->on('b.id','=','p.board_id');
                });
        if($bid != 0){
            $boards = $boards->where('b.id','<',$bid);
        };
        if($whereId == 0 || $whereId == 1){
            $boards = $boards->where($whereList[$whereId]['field'],$whereList[$whereId]['value']);
        };


        $boards = $boards->select(DB::raw('b.id,IFNULL(g.cnt,0) as cnt,IFNULL(c.cnt,0) as cnt_comment,IFNULL(p.user_id,0) as pushed'))
                ->orderBy('b.id', 'DESC')
                ->take($LIMITCNT)
                ->get();
                
                // ->offset($bid*$LIMITCNT) //スキップするレコード数
        return($boards);
    }
}