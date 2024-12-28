<?php

namespace Database\Seeders\Migration;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClearPlaneUserTableSeeder extends Seeder
{
    public function run(): void
    {
        // Tabelleninhalt löschen
        DB::table('plane_user')->truncate();

        $this->command->info('Die Tabelle "plane_user" wurde erfolgreich geleert.');
    }
}
