<img width="48px" height="48px" src="public/img/logo.JPG">
# Informe proyecto 2018



## Fundamentación sobre la elección del framework elegido.
Principalmente evaluamos dos framework, laravel y symfony. Tuvimos en cuenta en los dos ya que son los más usados actualmente, para el lenguaje PHP.
Se terminó eligiendo laravel porque:
- Ambos teníamos conocimientos previos básicos sobre el framework.
- Teníamos conocimiento de una librería en laravel (Entrust), que manejaba perfectamente el sistema de roles y permisos.
-Estructura: en symfony nos costó tiempo entender el porqué y el uso de los Bundles. En cambio, en laravel fácilmente entendimos todo.
- Nos pareció más cómodo el ORM de Laravel (Eloquent), ya que usa active record
- Migraciones: Se tiene registros de todas las migraciones
- Seeders: Laravel tiene seeders que ya vienen por defecto, por lo cual es facil y rapido llenar la base con datos de prueba.

## Referencias
-   [Documentacon oficial](https://laravel.com/docs/5.4) 
-   [Libreria Entrust](https://github.com/Zizaco/entrust) 
-   [Articulo en styde.net](https://styde.net/laravel-5/) 
-   [Articulo en tutorialspoiny](https://www.tutorialspoint.com/laravel/index.htm)


## Descripción de los módulos aprovechados para ser usados por el framework.
-   **Módulo de roles y de permisos:** Ambos módulos fueron implementados con la librería de Entrust. 
	Las clases Role y Permission, heredan de EntrustRole y EntrustPermission respectivamente. Así heredan toda la funcionalidad para manejar el sistema de roles y permisos. Por ejemplo, facilmente se puede crear un permiso asociarlo a un rol y dicho rol asociarlo a un usuario.
-   **Módulo de sesión:** Laravel implementa un sistema de autenticación muy simple, el cual se usa en el proyecto. Si bien se generan archivos para registrar, cambiar contraseña, recuperar contraseña, etc, se usa solo la parte de login. Ya que el registro, está contemplado en el módulo de usuarios manejado por el administrador.
	Usando la autenticación de laravel es muy simple comprobar si un usuario existe, a partir de su contraseña y un dato (email, usuario, etc). Nos abstraemos de todas las comprobaciones.
-   **En todos los módulos**, se aprovechan los mecanismos de validación del framework. Por ejemplo validar que un email o nombre de usuario se único en la base, y todas las demás comprobaciones del lado del servidor. Laravel provee un mecanismo muy simple. En nuestro caso, usamos la clase FormRequest para validar los datos. Existe un Form request por modelo (excepto roles  y permisos que no se implementa CRUD).
-   También, **en todos los módulos** se aprovecha el CRUD de laravel, el cual se explica en un item posterior.





## Mecanismos de seguridad y routing
-   **CSRF:** se usa un token csrf en los formularios, para comprobar la procedencia del request.
-   Se usan **middlewares** en los controllers para impedir acceso a rutas por parte de usuarios que no tienen autorización

## Mecanismo operaciones CRUD
-   Cuando se crea un modelo (con la consola) se envía el parámetro -r para especificar que es un recurso. Este comando es muy potente, ya que automáticamente crea el modelo, un controlador con los acciones CRUD, y modifica el archivo de rutas ruteando a los métodos del controlador correspondientes. Luego se modifican las migraciones a gusto, y se ejecutan. Por último, se maneja todo mediante objetos (los modelos) haciendo uso del ORM, que, como se dijo al principio, usa el patrón active record. Una tabla se mapea a una clase en particular. Si uno acata las restricciones de nombres que pone laravel, es todo automático. Por ejemplo: nombre de la clase en singular (y en inglés), genera una tabla con el mismo nombre en plural.


## Manejo MVC
-	Los directorios más usados durante el proyecto son:
	-   **App:** se ubican modelos, controladores, y los request y middlewares antes mencionados, entre otros.
	-   **Database:** se ubican migraciones y seeders. También factorías, las cuales pueden usar los seeders para generar datos.
	-   **Routes:** se ubica, entre otros, el archivo **web.php** donde se especifican los ruteos.
-   Si bien, según el creador de laravel, este no es un framework MVC. Se puede notar fácilmente en nuestro proyecto este patrón. El modelo se ubica en la carpeta **/app** en archivos sueltos (tambien podria estar en una carpeta ‘models’, eso lo definimos nosotros). El controlador se ubica en **/app/http/controllers**. Y la vista en **/resources/views**, aqui estan todos los templates
	 