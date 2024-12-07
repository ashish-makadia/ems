<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;



class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create(['name' => 'Super Admin', 'email' => 'superadmin@admin.com','role'=>'Super Admin','mobile_no' => '1223654578','status' =>'Active','password' => Hash::make('superadmin@1234')]);
        $user->assignRole('Super Admin');

        $user = User::create(['name' => 'Admin', 'email' => 'admin@admin.com','role'=>'Administrator','mobile_no' => '1223654578','status' =>'Active','password' => Hash::make('admin@1234')]);
        $user->assignRole('Administrator');
        
        $user = User::create(['name' => 'User', 'email' => 'user@user.com','role'=>'Administrator','mobile_no' => '1888791460','status' =>'Active', 'password' => Hash::make('user@1234')]);
        $user->assignRole('Supplier');

        $user = User::create(['name' => 'Ship Company', 'email' => 'supplier@mailinator.com','role'=>'Ship Company','mobile_no' => '1888791460','status' =>'Active', 'password' => Hash::make('user@1234')]);
        $user->assignRole('Supplier');
        
    }
}
