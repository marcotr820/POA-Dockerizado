<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //debemos indicar el guard que queremos que le asignen los roles y permisos
        $role1 = Role::create(['guard_name' => 'usuario', 'name' => 'ADMIN']);
        $role2 = Role::create(['guard_name' => 'usuario', 'name' => 'PLANIFICADOR']);
        $role3 = Role::create(['guard_name' => 'usuario', 'name' => 'TRABAJADOR']);
        $role4 = Role::create(['guard_name' => 'usuario', 'name' => 'GERENTE']);

        //despues de crear el permiso lo relaciona con el rol ->assignRole
        Permission::create(['guard_name' => 'usuario', 'name' => 'SUPER-ADMIN'])->assignRole($role1);
        Permission::create(['guard_name' => 'usuario', 'name' => 'VER-TRABAJADORES'])->assignRole($role1);
        Permission::create(['guard_name' => 'usuario', 'name' => 'VER-USUARIOS'])->assignRole($role1);

        // PLANIFICADOR
        Permission::create(['guard_name' => 'usuario', 'name' => 'VER-DIRECTRIZ'])->assignRole($role2);
        Permission::create(['guard_name' => 'usuario', 'name' => 'VER-ESTADOS-TRABAJADORES'])->assignRole($role2);
        Permission::create(['guard_name' => 'usuario', 'name' => 'VER-ESTADOS-POA'])->assignRole($role2);
        Permission::create(['guard_name' => 'usuario', 'name' => 'VER-PRESUPUESTOS-REQUERIDOS'])->assignRole($role2);
        Permission::create(['guard_name' => 'usuario', 'name' => 'VER-REPORTES-POA'])->assignRole($role2);
        Permission::create(['guard_name' => 'usuario', 'name' => 'CONSOLIDAR-POA'])->assignRole($role2);

        // TRABAJADOR
        Permission::create(['guard_name' => 'usuario', 'name' => 'VER-POA'])->assignRole($role3);
        // Permission::create(['guard_name' => 'usuario', 'name' => 'VER-PLANIFICACION-EVALUACION-POA'])->assignRole($role3);
        Permission::create(['guard_name' => 'usuario', 'name' => 'VER-PLANIFICACION'])->assignRole($role3);
        Permission::create(['guard_name' => 'usuario', 'name' => 'VER-EVALUACION'])->assignRole($role3);
        

        // GERENTE
        Permission::create(['guard_name' => 'usuario', 'name' => 'VER-POA-UNIDADES-GERENCIA'])->syncRoles($role4, $role2);
    }
}
