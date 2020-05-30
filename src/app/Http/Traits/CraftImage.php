<?php
namespace App\Http\Traits;
use Intervention\Image\Facades\Image;

trait CraftImage {

    //円に切り抜く
    public static function trimUserIconCircle($user)
    {
        # code...
        $CIRCLE_X =500; //横サイズ
        $CIRCLE_Y =500; //縦サイズ
        $CIRCLE_MATTE='#00ff00'; //透過色

        $touka = Image::make(public_path('img/touka_circle.png'));

        $user->fit($CIRCLE_X,$CIRCLE_Y);
        $touka->fit($CIRCLE_X,$CIRCLE_Y);

        $user->insert($touka,'top-left',0,0);
        $user->limitColors(255, $CIRCLE_MATTE);

        return $user;

    }

    public static function trimStampIcon($stamp)
    {
        # code...
        $stamp->widen(1800);    // 横幅を基準としてサイズ変更
        $stamp->rotate(3);

        return $stamp;
    }

    public static function trimArrowIcon($arrow)
    {
        # code...
        $arrow->widen(1200);
        $arrow->rotate(-15);
        
        return $arrow;
    }
}