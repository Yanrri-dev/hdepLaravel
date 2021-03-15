<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Role::create(['name' => 'guest']);

        $role1 = Role::create(['name' => 'admin']);
        $role2 = Role::create(['name' => 'mantainer']);
        
        
        
        Permission::create(['name' => 'admin.home'])->syncRoles([$role1,$role2]);

        Permission::create(['name' => 'admin.modulos.index'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'admin.modulos.edit'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'admin.modulos.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'admin.modulos.destroy'])->assignRole($role1);
        
        Permission::create(['name' => 'admin.modulos.participantes.show'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'admin.modulos.participantes.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'admin.modulos.participantes.destroy'])->assignRole($role1);

        Permission::create(['name' => 'admin.users.index'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'admin.users.edit'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'admin.users.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'admin.users.destroy'])->assignRole($role1);

        Permission::create(['name' => 'admin.categories.index'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'admin.categories.edit'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'admin.categories.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'admin.categories.destroy'])->assignRole($role1);
        
        
    }

}
