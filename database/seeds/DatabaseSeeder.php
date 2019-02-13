<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(ArtistSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(SourceSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(AccountSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(ExpenseCategorySeeder::class);
    }
}
