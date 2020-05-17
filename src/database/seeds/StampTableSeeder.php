<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StampTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $names = ['stamp1', 'stamp2', 'stamp3','stamp4','stamp5','stamp6','stamp7','stamp8','stamp9'];

        foreach ($names as $name) {
            DB::table('stamps')->insert([
                'name' => $name,
                'category_id'=>1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
