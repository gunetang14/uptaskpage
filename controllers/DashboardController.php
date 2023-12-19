<?php

namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;
#[\AllowDynamicProperties]
class DashboardController {

    public static function index(Router $router) {
        session_start();
        isAuth();
        $id = $_SESSION['id'];
        $proyectos = Proyecto::belongsTo('propietarioId', $id);
        $router->render('dashboard/index', [
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos
        ]);
    }
    public static function project(Router $router) {
        session_start();
        isAuth();
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyecto = new Proyecto($_POST);
            //validacion
            $alertas = $proyecto->validarProyecto();
            if(empty($alertas)){
                //generar URL unica
                $hash = md5( uniqid());
                $proyecto->url = $hash;
                //almacenar el creador del proyecto
                $proyecto->propietarioId = $_SESSION['id'];

                //guardar el proyecto
                $proyecto->guardar();
                header('Location: /my-project?id=' . $proyecto->url);
            }
        }

        $router->render('dashboard/newproject', [
            'titulo' => 'Crear Proyecto',
            'alertas' => $alertas
        ]);
    }

    public static function myproject(Router $router) {
        session_start();
        isAuth();
        
        $token = $_GET['id'];        
        if(!$token) header('Location: /dashboard');

        //Revisar que la persona que visita el proyecto es quien lo creo
        $proyecto = Proyecto::where('url', $token);
        
        if($proyecto->propietarioId !== $_SESSION['id']){
            
            header('Location: /dashboard');
        }

        


        $router->render('dashboard/myproject',[
            'titulo' => $proyecto->proyecto
        ]);
    }

    public static function profile(Router $router) {
        session_start();
        isAuth();
        $alertas = [];

        $usuario = Usuario::find($_SESSION['id']);

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validar_perfil();
            if(empty($alertas)){
                $existeUsuario = Usuario::where('email', $usuario->email);
                if($existeUsuario && $existeUsuario->id !== $usuario->id){
                    //mensaje de error
                    Usuario::setAlerta('error','El Email ya está Registrado');
                    $alertas = $usuario->getAlertas();
                } else {
                    //almacenar
                    $usuario->guardar();
                    Usuario::setAlerta('exito','Guardado Correctamente');
                    $alertas = $usuario->getAlertas();
                    ///asignar nuevo nombre a la barra
                    $_SESSION['nombre'] = $usuario->nombre;
                }
                

            }
        }

        $router->render('dashboard/profile', [
            'titulo' => 'Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
    public static function changepassword(router $router){
        session_start();
        isAuth();
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario = Usuario::find($_SESSION['id']);
            $usuario->sincronizar($_POST);
            $alertas = $usuario->nuevoPassword();
            if(empty($alertas)){
                $resultado = $usuario->comprobarPassword();
                if($resultado){
                    //asignar el nuevo password
                    $usuario->password = $usuario->password_nuevo;
                    //eliminar propiedades no necesarias
                    unset($usuario->password_actual);
                    unset($usuario->password_nuevo);
                    unset($usuario->password2);
                    //hasehar nuevo password
                    $usuario->hashearPassword();
                    //actualizar
                    $respuesta = $usuario->guardar();
                    if($respuesta){
                        Usuario::setAlerta('exito', 'Password Guardado Correctamente');
                        $alertas = Usuario::getAlertas();
                    }
                } else {
                    Usuario::setAlerta('error', 'Password Incorrecto'); 
                    $alertas = Usuario::getAlertas();
                }
            }   
        }
        $router->render('dashboard/changepassword', [
            'titulo' => 'Cambiar Password',
            'alertas' => $alertas
        ]);
    }

}

?>