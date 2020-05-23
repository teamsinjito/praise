<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $comments = ['comment1', 'comment2', 'commen3','commen4','comment5'];

        foreach ($comments as $comment) {
            DB::table('comments')->insert([
                'board_id' => 1,
                'user_id'=>1,
                'comment'=>$comment,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
