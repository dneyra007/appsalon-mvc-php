<?php

namespace Controllers;
use MVC\Router;
use Model\Usuario;
use Classes\Email;

class LoginController {

    public static function login(Router $router) {

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);

           $alertas = $auth->validarLogin();

           if(empty($alertas)) {
                //comprobar que exista el usuario
                $usuario = Usuario::where('email', $auth->email);

                if($usuario) {
                    //verificar password
                   if($usuario->comprobarPasswordAndVerificado($auth->password));
                       // Autenticar el usuario
                       session_start();

                       $_SESSION['id'] = $usuario->id;
                       $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                       $_SESSION['email'] = $usuario->email; 
                       $_SESSION['login'] = true; 
                     

                       // redireccionamiento
                       if($usuario->admin === "1") {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                       } else {
                            header('Location: /cita');

                       }
                         //debuguear($_SESSION);
                } else {
                    Usuario::setAlerta('error', 'User incorrect');
                }

           }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'alertas' => $alertas
        ]);

    }
    public static function logout() {
        session_start();

        $_SESSION = [];
        
        header('Location: /');

    }
    public static function olvide(Router $router) {
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();
           
           if(empty($alertas)) {
            $usuario = Usuario::where('email', $auth->email);
             if($usuario &&$usuario->confirmado === "1") {
                 //generar un token
                 $usuario->crearToken();
                 $usuario->guardar();

                 //enviar el email
                 $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                 $email->enviarInstrucciones();

                 //alerta de exito
                 Usuario::setAlerta('exito', 'Please, check your email');
                 
             } else{
                Usuario::setAlerta('error', 'User no exist or not confirmed');
               
             }
            
             $alertas = Usuario::getAlertas();
           // debuguear($usuario);
           }
           
        }
        $router->render('auth/olvide-password', [
            'alertas' => $alertas ]);

    }
    public static function recuperar(Router $router) {

        $alertas = [];
        
        $token = s($_GET['token']);
        
        //buscar usuario por su token
        $error = false;
        $usuario = Usuario::where('token', $token);
        
        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token Invalid');
            $error = true; 
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //leer el nuevo password y guardarlo
            $password = new Usuario($_POST);
            $alertas = $password->validarPassword();

            if(empty($alertas)) {
                $usuario->password = null;

                $usuario->password = $password->password;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar();
                if($resultado) {

                   header('Location: /');
                }
            }
        }    
                
        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar-password', [
            'alertas' => $alertas, 'error' => $error
        ]);

    }
    public static function crear(Router $router) {

        $usuario = new Usuario;    

        //alertas vacias
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();
            
           //revisar que alertas este vacio
           if(empty($alertas)) {
            //verificar que el usuario no este registrado
             $resultado = $usuario->existeUsuario();

             if($resultado->num_rows) {
                $alertas = Usuario::getAlertas();
             } else {
                //hashear el password
                $usuario->hashPassword();
               
                //generar un token unico
                $usuario->crearToken();

                // enviar el email
                $email = new Email($usuario->nombre, $usuario->email, $usuario->token);

                $email->enviarConfirmacion();
                //debuguear($usuario);

                //crear el usuario
                $resultado = $usuario->guardar();
                if($resultado) {
                    header('Location: /mensaje');
                }

               
             }
           }
        }
        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);

    }

    public static function mensaje(Router $router) { 

        $router->render('auth/mensaje');

    }

    public static function confirmar(Router $router) {  
        
        $alertas = [];

        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

       if(empty($usuario)) {
            //mostrar mensaje de error
            Usuario::setAlerta('error', 'Code Invalid');
       } else {
              //mostrar mensaje de exito  
         $usuario->confirmado = "1";
         $usuario->token = "null";
         $usuario->guardar();
         Usuario::setAlerta('exito', 'Your account was activated!!');
       }

       $alertas = Usuario::getAlertas();
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas

        ]);

}
}