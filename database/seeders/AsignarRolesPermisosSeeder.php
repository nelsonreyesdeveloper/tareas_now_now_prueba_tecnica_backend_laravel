<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class AsignarRolesPermisosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Permisos

       /* autentificacion */
        $crearUsuariosPermission = Permission::create(['name' => 'crear_usuarios']);
        $editarUsuariosPermission = Permission::create(['name' => 'editar_usuarios']);
        $eliminarUsuariosPermission = Permission::create(['name' => 'eliminar_usuarios']);

       $editar_tareas_asignadas= Permission::create(['name' => 'editar_tareas_asignadas']);
        

        /* tareas */
        $verTareasPermission = Permission::create(['name' => 'ver_tareas']);
        $crearTareasPermission = Permission::create(['name' => 'crear_tareas']);
        $editarTareasPermission = Permission::create(['name' => 'editar_tareas']);
        $eliminarTareasPermission = Permission::create(['name' => 'eliminar_tareas']);
        $asignarTareasPermission = Permission::create(['name' => 'asignar_tareas']);
        $cambiarEstadoTareaPermission = Permission::create(['name' => 'cambiar_estado_tarea']);
        
        /* archivos */
        $adjuntarArchivosPermission = Permission::create(['name' => 'adjuntar_archivos']);
        $eliminarArchivosPermission = Permission::create(['name' => 'eliminar_archivos']);
        
        // Roles
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $empleadoRole = Role::create(['name' => 'empleado']);
        
        // Asignar permisos a roles
        $superAdminRole->syncPermissions([
            $editar_tareas_asignadas,
            $crearUsuariosPermission,
            $editarUsuariosPermission,
            $eliminarUsuariosPermission,
            $verTareasPermission,
            $crearTareasPermission,
            $editarTareasPermission,
            $eliminarTareasPermission,
            $asignarTareasPermission,
            $cambiarEstadoTareaPermission,
            $adjuntarArchivosPermission,
            $eliminarArchivosPermission,
        ]);
        
        $empleadoRole->syncPermissions([
            $verTareasPermission,
            $cambiarEstadoTareaPermission, // Sin condiciones
            $adjuntarArchivosPermission,
            $eliminarArchivosPermission, // Sin condiciones
        ]);
    }
}
