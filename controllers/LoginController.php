<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;
#[\AllowDynamicProperties]
class LoginController {
    public static function home(Router $router){
        
        $router->render('auth/home',[
            'titulo' => 'UpTask'
        ]);
    }
    public static function index(Router $router){
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();
            if(empty($alertas)){
                $usuario = Usuario::where('email', $auth->email);
                if(!$usuario || $usuario->confirmado != 1){
                    Usuario::setAlerta('error', 'El Usuario No Existe o No está confirmado');
                } else {
                    // usuario existe
                    if(password_verify($auth->password, $usuario->password)){
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;
                        //Redireccionar
                        header('Location: /dashboard');
                    } else {
                        Usuario::setAlerta('error', 'La Contraseña es Incorrecta');
                    }
                }
            }


        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/login',[
            'titulo' => 'Iniciar Sesión',
            'alertas' => $alertas
        ]);
    }
    public static function logout(Router $router){
        session_start();
        $_SESSION = [];
        header('Location: /login');
        
    }
    public static function signup(Router $router){
        $alertas = [];
        $usuario = new Usuario();
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            if(empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->email);
                if($existeUsuario){
                    Usuario::setAlerta('error', 'El Usuario ya está registrado');
                    $alertas = Usuario::getAlertas();
                } else {
                    //hashear el password
                    $usuario->hashearPassword();
                    //eliminar password2
                    unset($usuario->password2);
                    //crear nuevo usuario
                    $usuario->crearToken();
                    $resultado = $usuario->guardar();
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();
                    if($resultado){
                        header('Location: /message');
                    }
                }
            }
        }

        $router->render('auth/signup',[
            'titulo' => 'Crea Tu Cuenta en UpTask',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }
    public static function forgot(Router $router){
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();
            if(empty($alertas)){
                $usuario = Usuario::where('email', $usuario->email);
                if($usuario && ($usuario->confirmado === "1") ) {
                    //generar un nuevo token
                    $usuario->crearToken();
                    unset($usuario->password2);
                    //actualizar el usuario
                    $usuario->guardar();
                    //enviar el email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();
                    //imprimir la alerta
                    Usuario::setAlerta('exito', 'Hemos enviado las instrucciones a tu Email');
                } else {
                    Usuario::setAlerta('error', 'El Usuario no Existe o no está Confirmado');
                    
                }
            }
        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/forgot',[
            'titulo' => 'Olvidé mi Password',
            'alertas' => $alertas
        ]);
    }

    public static function reset(Router $router){
        $alertas = [];
        $mostrar = true;
        $token = s($_GET['token']);
        if(!$token) header('Location: /login');
        //Identificar el usuario con el token
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token No Válido');
            $mostrar = false;
        }
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //añadir el nuevo password
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarPassword();
            if(empty($alertas)){
                $usuario->hashearPassword();
                unset($usuario->password2);
                $usuario->token = null;
                $resultado = $usuario->guardar();
                if($resultado) {
                    header('Location: /login');
                }
            }

        }
        $alertas = Usuario::getAlertas();
        $router->render('auth/reset',[
            'titulo' => 'Reestablece tu Password',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
    }

    public static function message(Router $router){
        $router->render('auth/message',[
            'titulo' => 'Cuenta Creada Exitosamente'
        ]);
        
    }
    public static function confirm(Router $router){
        $token = s($_GET['token']);
        if(!$token) header('Location: /login');
        // encontrar al usuario con el token
        $usuario = Usuario::where('token', $token);
        if(empty($usuario)){
            //no se encontro un usuario con el token
            Usuario::setAlerta('error', 'Token No Válido');
        } else {
            //confirma al ususario
            $usuario->confirmado = 1;
            $usuario->token = null;
            unset($usuario->password2);
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta Comprobada Correctamente');

        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/confirm',[
            'titulo' => 'Confirma tu Cuenta UpTask',
            'alertas' => $alertas
        ]);
        
    }
    public static function error(Router $router){
        
        $router->render('auth/error',[
            'titulo' => 'Página no Encontrada'
        ]);
        
    }
}

?>