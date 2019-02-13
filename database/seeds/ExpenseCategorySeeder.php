<?php

use Illuminate\Database\Seeder;
use App\Models\ExpenseCategory;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ec = new ExpenseCategory;
        $ec->name = 'Materiales de Trabajo';
        $ec->save();

        $ec = new ExpenseCategory;
        $ec->name = 'Insumos de Limpieza';
        $ec->save();

        $ec = new ExpenseCategory;
        $ec->name = 'Arriendo';
        $ec->save();

        $ec = new ExpenseCategory;
        $ec->name = 'Servicios';
        $ec->save();
    }
}
