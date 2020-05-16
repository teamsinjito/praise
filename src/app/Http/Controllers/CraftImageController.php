<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class CraftImageController extends Controller
{
    const CIRCLE_X =500; //横サイズ
    const CIRCLE_Y =500; //縦サイズ
    const CIRCLE_MATTE='#00ff00'; //透過色
    const ARROW_MATTE='#ffffff'; //透過色

    //円に切り抜く
    public static function trimUserIconCircle($user)
    {
        # code...
        $touka = Image::make(storage_path('app/public/img/templetes/touka_circle.png'));

        $user->fit(self::CIRCLE_X,self::CIRCLE_Y);
        $touka->fit(self::CIRCLE_X,self::CIRCLE_Y);

        $user->insert($touka,'top-left',0,0);
        $user->limitColors(255, self::CIRCLE_MATTE);

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

        // $arrow->limitColors(255, self::ARROW_MATTE);
        
        return $arrow;
    }
}
