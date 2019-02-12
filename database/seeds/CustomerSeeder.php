<?php

use Illuminate\Database\Seeder;
use App\Models\Source;
use App\Models\Artist;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = new Customer;
        $customer->source_id = Source::active()->pluck('id')->first();
        $customer->artist_id = Artist::active()->pluck('id')->first();
        $customer->name = 'Lucas';
        $customer->instagram = '@lucas_the_poodle';
        $customer->save();
    }
}
