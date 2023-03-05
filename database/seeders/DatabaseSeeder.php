<?php

namespace Database\Seeders;

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
        // \App\Models\User::factory(10)->create();
        $this->call(UsersTableSeeder::class);
        $this->call(PersonaSeeder::class);
        $this->call(DomicilioSeeder::class);
        $this->call(RegionesComunaSeeder::class);
        $this->call(DeligenciaSeeder::class);
        $this->call(GestionSeeder::class);
        $this->call(TipoArancelSeeder::class);
        $this->call(TipoEncargoSeeder::class);
        $this->call(TipoMateriaSeeder::class);
        $this->call(TipoTribunalSeeder::class);
        $this->call(TipoCuadernoSeeder::class);
        //$this->call(ArancelSeeder::class);
    }
}
