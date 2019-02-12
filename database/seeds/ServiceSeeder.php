<?php

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $service = new Service;
        $service->name = 'Manos';
        $service->price = 15000;
        $service->save();

		$service = new Service;
        $service->name = 'Pies';
        $service->price = 15000;
        $service->save();        
    }
}
