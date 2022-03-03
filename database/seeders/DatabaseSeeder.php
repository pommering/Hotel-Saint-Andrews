<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //\App\Models\User::factory(10)->create();
        DB::table('activities')->insert([
            ['assignment' => 'Arrumar cama', 'mandatory' => true, 'created_at' => date('Y-m-d h:i:s')],
            ['assignment' => 'Retirar o lixo', 'mandatory' => true, 'created_at' => date('Y-m-d h:i:s')]
        ]);
    }
}
