<?php

use Illuminate\Database\Seeder;
use App\Models\Account;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $account = new Account;
        $account->name = 'Efectivo';
        $account->save();

        $account = new Account;
        $account->name = 'Puntos';
        $account->is_reward = 1;
        $account->save();
    }
}
