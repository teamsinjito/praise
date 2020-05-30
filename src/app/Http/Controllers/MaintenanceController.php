<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Stamp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use App\Http\Traits\MyPraiseCount;
use App\Category;
use Illuminate\Support\Facades\Hash;
class MaintenanceController extends Controller
{
    use MyPraiseCount;
    //
    public function showMaintenanceView()
    {
        //カテゴリー情報を取得
        $categories = DB::table('categories') -> get() ->pluck('name', 'id');

        //ビューを返す
        return view('maintenance',[
            'myPraiseCount'=>$this->getMyPraiseCnt(),
            'toMyPraiseCount'=>$this->getMyPraisedCnt(),
            'categories'=>$categories
        ]);
    }

    public function CategoryCreate(Request $request){

        try{
            $successed = 1;
            $board = Category::create([
                'name'=>$request->category_name,
            ]);
        }catch(\Exception $e){
            $successed = 2;
        };  

        return redirect()->route('maintenance')->with('successed', $successed);
    }

    public function stampCreate(Request $request){

        try{
            $successed = 1;
            //画像加工
            if(!empty($request->file('img'))){
               $image = $request->file('img');
               $image = base64_encode(Image::make($image)->fit(700,460)->stream('png',50));
            }
            else{
                $image = 2;
            }
            
            $board = Stamp::create([
                'name'=>$request->stamp_name,
                'category_id'=>$request->categories,
                'image'=>$image
            ]);

        }catch(\Exception $e){
            $successed = 2;
        };

        return redirect()->route('maintenance')->with('successed', $successed);
    }

    public function userCreate(Request $request){

        try{
            if(Hash::check($request->password, Auth::user()->password)){
                //パスワード変更画面に遷移
                return view('auth.passwords.reset')->with(
                    ['token' => '',
                     'email' => '',
                     'myPraiseCount'=>$this->getMyPraiseCnt(),
                     'toMyPraiseCount'=>$this->getMyPraisedCnt()]);
            }
            else{
                $successed = 3;
                return redirect()->route('maintenance')->with('successed', $successed);
            }
        }catch(\Exception $e){
            $successed = 3;
            return redirect()->route('maintenance')->with('successed', $successed);
        };
    }

    public function PasswordUpdate(Request $request){

        try{
            
            $pass = Hash::make($request->password);


            DB::table('users')->where('id',Auth::user()->id)->update(['password' => $pass]);
            $successed = 4;
            
            return redirect()->route('maintenance')->with('successed', $successed);
        }catch(\Exception $e){
            $successed = 3;
            return redirect()->route('maintenance')->with('successed', $successed);
        };
    }
}
