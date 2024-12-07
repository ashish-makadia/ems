<?php

namespace Database\Seeders;
use App\Models\AccessIps;
 
use Illuminate\Database\Seeder;

class AccessIpsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * @return void
     */
    public function run()
    {
        AccessIps::create(['ip' => '127.0.0.1','type'=>'White','status'=>'Active']);
        AccessIps::create(['ip' => '192.168.1.165','type'=>'Black','status'=>'Active']);
        AccessIps::create(['ip' => '192.168.1.229','type'=>'White','status'=>'Active']);
        AccessIps::create(['ip' => '192.168.1.68','type'=>'White','status'=>'Active']);
        AccessIps::create(['ip' => '192.168.1.247','type'=>'White','status'=>'Active']);
        AccessIps::create(['ip' => '14.102.161.146','type'=>'White','status'=>'Active']);
        AccessIps::create(['ip' => '103.238.104.100','type'=>'White','status'=>'Active']);
    }
}
