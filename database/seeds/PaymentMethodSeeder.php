<?php

use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pm = new PaymentMethod;
        $pm->name = 'Efectivo';
        $pm->for_income = 1;
        $pm->for_expense = 1;
        $pm->is_reward = 0;
        $pm->save();

        $pm = new PaymentMethod;
        $pm->name = 'Transferencia Bancaria';
        $pm->for_income = 1;
        $pm->for_expense = 1;
        $pm->is_reward = 0;
        $pm->save();

        $pm = new PaymentMethod;
        $pm->name = 'Tarjeta Debito';
        $pm->for_income = 0;
        $pm->for_expense = 1;
        $pm->is_reward = 0;
        $pm->save();

        $pm = new PaymentMethod;
        $pm->name = 'Tarjeta Credito';
        $pm->for_income = 0;
        $pm->for_expense = 1;
        $pm->is_reward = 0;
        $pm->save();

        $pm = new PaymentMethod;
        $pm->name = 'Puntos';
        $pm->for_income = 1;
        $pm->for_expense = 0;
        $pm->is_reward = 1;
        $pm->save();
    }
}
