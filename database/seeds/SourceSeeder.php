<?php

use Illuminate\Database\Seeder;
use App\Models\Source;

class SourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $source = new Source;
        $source->name = 'Instagram';
        $source->save();

        $source = new Source;
        $source->name = 'Eventos';
        $source->save();

        $source = new Source;
        $source->name = 'Referencia';
        $source->is_customer_reference = 1;	
        $source->save();
    }
}
