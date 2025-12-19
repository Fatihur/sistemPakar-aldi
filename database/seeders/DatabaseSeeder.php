<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema; 
use Illuminate\Support\Facades\DB;      

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            GejalaSeeder::class,
            PenyakitSeeder::class,
            SolusiSeeder::class,
            PenyakitSolusiSeeder::class,
            GejalaPenyakitSeeder::class,
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
