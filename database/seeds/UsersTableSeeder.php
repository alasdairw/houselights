<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = App\User::where('email', 'test@example.com')->count();

        if($count < 1)
        {
            User::create(['name'=>'Main Account','email'=>'test@example.com','password'=>bcrypt('password')]);
        }
    }
}
