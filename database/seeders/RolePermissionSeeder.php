<?php
namespace Database\Seeders;
use App\Models\Permission;
use App\Models\Role;
use Spatie\Permission\PermissionRegistrar;


use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Role::create(['name' => 'Super Admin','guard_name'=>'web']);
        Role::create(['name' => 'Administrator','guard_name'=>'web']);
        Role::create(['name' => 'Supplier','guard_name'=>'web']);
        Role::create(['name' => 'Employee','guard_name'=>'web']);

        $permission = array('user','access ips','roles and permissions','activity logs','agents','department','region','province','customers','municipality','order booking');

        foreach ($permission as $key => $value) {
            Permission::create(['name' => 'view ' . $value,'guard_name' => 'web']);
            Permission::create(['name' => 'add ' . $value ,'guard_name' => 'web']);
            Permission::create(['name' => 'edit ' . $value ,'guard_name' => 'web']);
            Permission::create(['name' => 'delete ' . $value ,'guard_name' => 'web']);
        }

        $role = Role::findOrFail(1);

        $role->syncPermissions(['1', '2', '3', '4', '5', '6', '7', '8']);

        $role = Role::findOrFail(2);
        $role->syncPermissions(['1','3','5','6','8']);

        $role = Role::findOrFail(3);
        $role->syncPermissions(['1', '2']);

    }
}
