<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\DashboardController;
use Controllers\LoginController;
use Controllers\TareaController;
use MVC\Router;
$router = new Router();

//Login
$router->get('/',[LoginController::class, 'index']);
$router->post('/',[LoginController::class, 'index']);
$router->get('/logout',[LoginController::class, 'logout']);

//crear cuenta
$router->get('/signup',[LoginController::class, 'signup']);
$router->post('/signup',[LoginController::class, 'signup']);

//formulario olvide mi password
$router->get('/forgot',[LoginController::class, 'forgot']);
$router->post('/forgot',[LoginController::class, 'forgot']);

//reestablecer contraseña
$router->get('/reset',[LoginController::class, 'reset']);
$router->post('/reset',[LoginController::class, 'reset']);

//confirmaciones de cuenta
$router->get('/message',[LoginController::class, 'message']);
$router->get('/confirm',[LoginController::class, 'confirm']);

//error 404
$router->get('/404',[LoginController::class, 'error']);

//zona de proyectos
$router->get('/dashboard',[DashboardController::class, 'index']);
$router->get('/new-project',[DashboardController::class, 'project']);
$router->post('/new-project',[DashboardController::class, 'project']);
$router->get('/my-project',[DashboardController::class, 'myproject']);
$router->get('/profile',[DashboardController::class, 'profile']);
$router->post('/profile',[DashboardController::class, 'profile']);
$router->get('/changepassword',[DashboardController::class, 'changepassword']);
$router->post('/changepassword',[DashboardController::class, 'changepassword']);

//API para las tareas
$router->get('/api/tasks',[TareaController::class, 'index']);
$router->post('/api/task',[TareaController::class, 'new']);
$router->post('/api/task/update',[TareaController::class, 'update']);
$router->post('/api/task/delete',[TareaController::class, 'delete']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();