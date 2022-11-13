<?php
global $datos;

class UsuarioControlador{

    public function retornarEstadoCreado($request, $response, $arg){
        $json = $request->getBody();
        $datosUsuario = json_decode($json);
        //print_r($datosUsuario);
        $objetoUsuario = new Usuario();
        $usuarioLogueado = $objetoUsuario->crearUsuario($datosUsuario);
        $json = json_encode($usuarioLogueado);
        $response->getBody()->write($json);
        return $response;
    }

    public function retonarListaUsuarios($request, $response, $arg){
        $listaUsuarios = Usuario::buscarTodos();
        $json = json_encode($listaUsuarios);
        $response->getBody()->write($json);
        return $response;
    }

    public function retonarUsuarioLogueado($request, $response, $arg){   
        $json = $request->getBody();
        $datos = json_decode($json); 
        $email = $datos->email;
        $objetoUsuario = new Usuario();
        
        $usuarioLogueado = $objetoUsuario->buscarUsuarioLogueado($email);
        $json = json_encode($usuarioLogueado);
        $response->getBody()->write($json);
        return $response;
    }

    public function retonarUsuarioPerfil($request, $response, $arg){   
        $json = $request->getBody();
        $datos = json_decode($json); 
        $email = $datos->email;
        $objetoUsuario = new Usuario();
        
        $usuarioPerfil = $objetoUsuario->buscarPerfilUsuario($email);
        $json = json_encode($usuarioPerfil);
        $response->getBody()->write($json);
        return $response;
    }

    
    public function retornarActualizacionPass($request, $response, $arg){
        $json = $request->getBody();
        $datos = json_decode($json); //objeto
        
        $email = $datos ->email;
        $passVieja = $datos ->passVieja;
        $passNueva = $datos ->passNueva;

        $objetoUsuario = new Usuario();
        $usuarioLogueado = $objetoUsuario->actualizarPass($email,$passVieja,$passNueva);
        $json = json_encode($usuarioLogueado);

        $response->getBody()->write($json);
        return $response;
    }


    public function retornarEstadoEliminado($request, $response, $arg){
        $json = $request->getBody();
        $datos = json_decode($json); 
        $email = $datos ->email;

        $objetoUsuario = new Usuario();
        $usuarioLogueado = $objetoUsuario->eliminarUsuario($email );
        
        $json = json_encode($usuarioLogueado);
        $response->getBody()->write($json);
        return $response;
    }
}

?>
