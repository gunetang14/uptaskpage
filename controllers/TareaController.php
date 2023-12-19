<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;
#[\AllowDynamicProperties]
class TareaController {
    public static function index(){
        
        $proyectoId = $_GET['id'];
        if(!$proyectoId) header('Location: /dashboard');
        
        $proyecto = Proyecto::where('url', $proyectoId);
        session_start();
        if(!$proyecto || ($proyecto->propietarioId !== $_SESSION['id']) ) header('Location: /404'); 

        $tareas = Tarea::belongsTo('proyectoId', $proyecto->id);
        
        echo json_encode(['tareas' => $tareas]);

    }
    public static function new(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            session_start();
            $proyecto = Proyecto::where('url', $_POST['proyectoId']);
            if(!$proyecto || ($proyecto->propietarioId !== $_SESSION['id']) ){
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al agregar la tarea'
                ];
                echo json_encode($respuesta);
                return;
            } 
            //todo bien, instancia y crear la tarea
            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();
            $respuesta = [
                'tipo' => 'exito',
                'id' => $resultado['id'],
                'mensaje' => 'Tarea Creada Correctamente',
                'proyectoId' => $proyecto->id
            ];
            echo json_encode($respuesta);
        }
    }
    public static function update(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //validar que el proyecto exista
            $proyecto = Proyecto::where('url', $_POST['proyectoId']);
            session_start();
            if(!$proyecto || ( $proyecto->propietarioId !== $_SESSION['id']) ) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al Actualizar la Tarea'
                ];
                echo json_encode($respuesta);
                return;
            }
            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();
            if($resultado) {
                $respuesta = [
                    'tipo' => 'exito',
                    'id' => $tarea->id,
                    'proyectoId' => $proyecto->id,
                    'mensaje' => 'Tarea Actualizada Correctamente'
                ];
                echo json_encode(['respuesta' =>$respuesta]);
            }
            
        }
    }
    public static function delete(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //validar que el proyecto exista
            $proyecto = Proyecto::where('url', $_POST['proyectoId']);
            session_start();
            if(!$proyecto || ( $proyecto->propietarioId !== $_SESSION['id']) ) {
                $respuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un error al Actualizar la Tarea'
                ];
                echo json_encode($respuesta);
                return;
            }
            $tarea = new Tarea($_POST);
            $resultado = $tarea->eliminar();
            $resultado = [
                'resultado' => $resultado,
                'mensaje' => 'Tarea Eliminada Correctamente',
                'tipo' => 'exito'
            ];
            echo json_encode($resultado);
        }
    }
}

?>