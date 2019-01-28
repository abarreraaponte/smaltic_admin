<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = 'Alejandro Barrera Aponte';
        $user->email = 'alejandro@dinamo24.com';
        $user->password = Hash::make('dinamo24-');
        $user->save();

        $user = new User;
        $user->name = 'Mariangel Fernandez';
        $user->email = 'mariangelaless@gmail.com';
        $user->password = Hash::make('dinamo24-');
        $user->save();
    }
}
