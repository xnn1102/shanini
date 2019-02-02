<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        for($i=0;$i<30;$i++){

        
        DB::table('user')->insert([
            'username' => str_random(10),
            'email' => str_random(10).'@qq.com',
            'password' => Hash::make('123456789'),
            'phone'=>'13'.rand(111111111,999999999),
            'profile'=>'/uploads/48291548080750.jpg',
        ]);
     }
    }
}
