<?php

use Illuminate\Database\Seeder;
use Caffeinated\Shinobi\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//USUARIOS
        Permission::create([
        	'name'			=>	'Navegar usuarios',
        	'slug'			=>	'users.index',
        	'description'	=>	'Lista y navega todos los usuarios del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Ver detalle de usuario',
        	'slug'			=>	'users.show',
        	'description'	=>	'Ver en detalle cada usuario del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Edicion de usuarios',
        	'slug'			=>	'users.edit',
        	'description'	=>	'Edita cualquier usuario del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Eliminar usuario',
        	'slug'			=>	'users.destroy',
        	'description'	=>	'Elimina cualquier usuario del sistema',
        ]);

        //ROLES
        Permission::create([
        	'name'			=>	'Navegar roles',
        	'slug'			=>	'roles.index',
        	'description'	=>	'Lista y navega todos los roles del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Ver detalle de rol',
        	'slug'			=>	'roles.show',
        	'description'	=>	'Ver en detalle cada rol del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Creacion de roles',
        	'slug'			=>	'roles.create',
        	'description'	=>	'Edita cualquier rol del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Edicion de roles',
        	'slug'			=>	'roles.edit',
        	'description'	=>	'Edita cualquier rol del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Eliminar rol',
        	'slug'			=>	'roles.destroy',
        	'description'	=>	'Elimina cualquier rol del sistema',
        ]);

        //TIPO CURSOS
        Permission::create([
        	'name'			=>	'Navegar tipo curso',
        	'slug'			=>	'type_courses.index',
        	'description'	=>	'Lista y navega todos los tipo curso del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Ver detalle de tipo curso',
        	'slug'			=>	'type_courses.show',
        	'description'	=>	'Ver en detalle cada tipo curso del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Creacion de tipo curso',
        	'slug'			=>	'type_courses.create',
        	'description'	=>	'Edita cualquier tipo curso del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Edicion de tipo curso',
        	'slug'			=>	'type_courses.edit',
        	'description'	=>	'Edita cualquier tipo curso del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Eliminar tipo curso',
        	'slug'			=>	'type_courses.destroy',
        	'description'	=>	'Elimina cualquier tipo curso del sistema',
        ]);

        //CURSOS
        Permission::create([
        	'name'			=>	'Navegar cursos',
        	'slug'			=>	'courses.index',
        	'description'	=>	'Lista y navega todos los cursos del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Ver detalle de curso',
        	'slug'			=>	'courses.show',
        	'description'	=>	'Ver en detalle cada curso del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Creacion de cursos',
        	'slug'			=>	'courses.create',
        	'description'	=>	'Edita cualquier curso del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Edicion de cursos',
        	'slug'			=>	'courses.edit',
        	'description'	=>	'Edita cualquier curso del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Eliminar curso',
        	'slug'			=>	'courses.destroy',
        	'description'	=>	'Elimina cualquier curso del sistema',
        ]);

        //LOCACION
        Permission::create([
        	'name'			=>	'Navegar lugar',
        	'slug'			=>	'locations.index',
        	'description'	=>	'Lista y navega todos los lugar del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Ver detalle de lugar',
        	'slug'			=>	'locations.show',
        	'description'	=>	'Ver en detalle cada lugar del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Creacion de lugar',
        	'slug'			=>	'locations.create',
        	'description'	=>	'Edita cualquier lugar del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Edicion de lugar',
        	'slug'			=>	'locations.edit',
        	'description'	=>	'Edita cualquier lugar del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Eliminar lugar',
        	'slug'			=>	'locations.destroy',
        	'description'	=>	'Elimina cualquier lugar del sistema',
        ]);

        //EMPRESA
        Permission::create([
        	'name'			=>	'Navegar empresa',
        	'slug'			=>	'companies.index',
        	'description'	=>	'Lista y navega todos los empresa del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Ver detalle de empresa',
        	'slug'			=>	'companies.show',
        	'description'	=>	'Ver en detalle cada empresa del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Creacion de empresa',
        	'slug'			=>	'companies.create',
        	'description'	=>	'Edita cualquier empresa del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Edicion de empresa',
        	'slug'			=>	'companies.edit',
        	'description'	=>	'Edita cualquier empresa del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Eliminar empresa',
        	'slug'			=>	'companies.destroy',
        	'description'	=>	'Elimina cualquier empresa del sistema',
        ]);

        //APERTURA
        Permission::create([
        	'name'			=>	'Navegar inscripcion',
        	'slug'			=>	'inscriptions.index',
        	'description'	=>	'Lista y navega todas las aperturas de inscripcion del administrador',
        ]);
        Permission::create([
        	'name'			=>	'Ver detalle de inscripcion',
        	'slug'			=>	'inscriptions.show',
        	'description'	=>	'Ver en detalle cada apertura de inscripcion del administrador',
        ]);
        Permission::create([
        	'name'			=>	'Creacion de inscripcion',
        	'slug'			=>	'inscriptions.create',
        	'description'	=>	'Crea apertura de inscripcion del administrador',
        ]);
        Permission::create([
        	'name'			=>	'Edicion de inscripcion',
        	'slug'			=>	'inscriptions.edit',
        	'description'	=>	'Edita cualquier apertura de inscripcion del administrador',
        ]);
        Permission::create([
        	'name'			=>	'Eliminar inscripcion',
        	'slug'			=>	'inscriptions.destroy',
        	'description'	=>	'Elimina cualquier apertura de inscripcion del administrador',
        ]);

        //INSCRIPCION USUARIO
        Permission::create([
        	'name'			=>	'Navegar inscripcion',
        	'slug'			=>	'user_inscriptions.index',
        	'description'	=>	'Lista y navega todos los inscripcion del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Ver detalle de inscripcion',
        	'slug'			=>	'user_inscriptions.show',
        	'description'	=>	'Ver en detalle cada inscripcion del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Creacion de inscripcion',
        	'slug'			=>	'user_inscriptions.create',
        	'description'	=>	'Edita cualquier inscripcion del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Edicion de inscripcion',
        	'slug'			=>	'user_inscriptions.edit',
        	'description'	=>	'Edita cualquier inscripcion del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Eliminar inscripcion',
        	'slug'			=>	'user_inscriptions.destroy',
        	'description'	=>	'Elimina cualquier inscripcion del sistema',
        ]);

        //PARTICIPANTES
        Permission::create([
        	'name'			=>	'Navegar participante',
        	'slug'			=>	'participants.index',
        	'description'	=>	'Lista y navega todos los participante del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Ver detalle de participante',
        	'slug'			=>	'participants.show',
        	'description'	=>	'Ver en detalle cada participante del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Creacion de participante',
        	'slug'			=>	'participants.create',
        	'description'	=>	'Edita cualquier participante del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Edicion de participante',
        	'slug'			=>	'participants.edit',
        	'description'	=>	'Edita cualquier participante del sistema',
        ]);
        Permission::create([
        	'name'			=>	'Eliminar participante',
        	'slug'			=>	'participants.destroy',
        	'description'	=>	'Elimina cualquier participante del sistema',
		]);
		//Fotocheck
		Permission::create([
        	'name'			=>	'Solicitar Fotocheck',
        	'slug'			=>	'fotocheck.solicited',
        	'description'	=>	'Solicita el fotocheck',
        ]);
        
    }
}
