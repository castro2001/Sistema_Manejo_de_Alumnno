# Sistema_Manejo_de_Alumnno

1.- Intrucciones cambie las variable dependiendo de su configuracionn de ssu base de datos.

2.- Cambie la url en el controlador con la ruta real del proyecto

3. Cambie la ruta base con la ruta real del proyecto

4. el codigo de la base de datos esta en la carpeta sql
4.1. Encontrara datos prueba para que funcione el sistema

5. en la carpeta public/image/subidas aqui encontrara todas las imagenes que se suba en la base de datos.

6.en la carpeta public/js/horario encontra una funcion como la siguiente:
function getColor(materia) {
    const colorMap = {
        // Agrega más materias y colores según sea necesario
    };
    return colorMap[materia] || "bg-primary-subtle"; // Color por defecto
}

donde si desea agregar colores personalizado en esta funcion lo hace como funciona. funciona con clave:valor donde la clave es la materia y el valor el color que sea agregar.

7. En la carpeta core/Routes se encuentra la configuracion de las rutas donde si desea agregar rutas lo hace en el objeto $this->listWhite = array('Aqui se encuentra las rutas');

8. la sessionn funcionaa debe crear un usuario o verificar si yaa lo creo en base de datos, se valida si ese usuario existe lo deja entrar caso contrario.

el login esta realizado como un logeo sencillo sin roles.

9. El usuario no puede acceder a ninguna ruta primero debe iniciar sesion para poder entrar. si el usuario ingresa a una ruta lo redije al login.

el usuario ingresa el login se deshabilita puede andar a todas la rutas disponible.

Cualquier consulta me escribe por whatsapp

public function getUrl(){
        // Definir las vistas permitidas solo para usuarios autenticados
        $this->listWhite = array(
            "Administrador",'Alumno','Horario','Pagos','Tutor','Materia','AgregarAlumno','Login'
        );

        if(!isset($_GET['views'])){
            $controller = new LoginController();
            call_user_func(array($controller, 'view_login'));
        }else{
            
            var_dump($_GET);
        }

        