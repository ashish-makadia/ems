<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
//use App\Models\Cruiselocationtags;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            AccessIpsSeeder::class,
        ]);
    }
}
