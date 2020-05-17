<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BoardTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        for ($i = 1; $i<11; $i++) {
            DB::table('boards')->insert([
                'from_user_id' => 1,
                'to_user_id'=>2,
                'stamp_id'=>1,
                'message'=>$i."praise",
                'del_flg'=>0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
