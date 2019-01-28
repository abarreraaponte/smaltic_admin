<?php

use Illuminate\Database\Seeder;
use App\Models\Artist;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $artist = new Artist;
        $artist->name = 'Mariangel Fernandez';
        $artist->save();

        $artist = new Artist;
        $artist->name = 'Norwys Leon';
        $artist->save();
    }
}
