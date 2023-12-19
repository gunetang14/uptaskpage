<?php
    namespace Model;
    #[\AllowDynamicProperties]
    class Usuario extends ActiveRecord {

        protected static $tabla = 'usuarios';
        protected static $columnasDB= ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

        public $id;
        public $nombre;
        public $email;
        public $password;
        public $password2;
        public $password_nuevo;
        public $password_actual;
        public $token;
        public $confirmado;

        public function __construct($args = []) {
            $this->id = $args['id'] ?? null;
            $this->nombre = $args['nombre'] ?? '';        
            $this->email = $args['email'] ?? '';        
            $this->password = $args['password'] ?? '';        
            $this->password2 = $args['password2'] ?? '';        
            $this->password_actual = $args['password_actual'] ?? '';        
            $this->password_nuevo = $args['password_nuevo'] ?? '';        
            $this->token = $args['token'] ?? '';        
            $this->confirmado = $args['confirmado'] ?? 0;        
        }

        public function validarLogin() {
            if(!$this->email){
                self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
            }
            if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
                self::$alertas['error'][] = 'El Formato del Email no es Correcto';
            }
            if(strlen($this->password) < 6 ){
                self::$alertas['error'][] = 'El Password debe contener mínimo 6 caracteres';
            }
            return self::$alertas;
        }

        public function validarNuevaCuenta() {
            
            if(!$this->nombre){
                self::$alertas['error'][] = 'El Nombre del Usuario es Obligatorio';
            }
            if(!$this->email){
                self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
            }
            if(!$this->password){
                self::$alertas['error'][] = 'El Password no puede ir vacio';
            }
            if(strlen($this->password) < 6 ){
                self::$alertas['error'][] = 'El Password debe contener mínimo 6 caracteres';
            }
            if($this->password !== $this->password2){
                self::$alertas['error'][] = 'Los passwords son diferentes';
            }

            return self::$alertas;
        }
        public function validarEmail(){
            if(!$this->email){
                self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
            }
            if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
                self::$alertas['error'][] = 'El Formato del Email no es Correcto';
            }
            return self::$alertas;
        }
        public function validarPassword(){
            if(!$this->password){
                self::$alertas['error'][] = 'El Password no puede ir vacio';
            }
            if(strlen($this->password) < 6 ){
                self::$alertas['error'][] = 'El Password debe contener mínimo 6 caracteres';
            }
            return self::$alertas;
        }
        public function validar_perfil(){
            if(!$this->nombre){
                self::$alertas['error'][] = 'El Nombre es Obligatorio';
            }
            if(!$this->email){
                self::$alertas['error'][] = 'El Email es Obligatorio';
            }
            return self::$alertas;
        }
        public function nuevoPassword(){
            if(!$this->password_actual) {
                self::$alertas['error'][] = 'El Password Actual no pude ir vacio';
            }
            if(!$this->password_nuevo) {
                self::$alertas['error'][] = 'El Password Nuevo no pude ir vacio';
            }
            if(strlen($this->password_nuevo) < 6) {
                self::$alertas['error'][] = 'El Password debe contener mínimo 6 caracteres';
            }
            return self::$alertas;
        }
        //comprobar el password
        public function comprobarPassword() : bool {
            return password_verify($this->password_actual, $this->password);
        }
        public function hashearPassword() : void {
            $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        }
        public function crearToken() : void {
            $this->token = uniqid();
        }
    }
?>