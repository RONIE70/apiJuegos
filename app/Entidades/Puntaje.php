<?php

class Puntaje{
    public $id_usuario;
    public $id_game;
    public $puntos;

    public function crearPuntaje($datosPuntajes){

        $id_game = $datosPuntajes->id_game;
        $puntos = $datosPuntajes->puntos;
        $email = $datosPuntajes->email;

        $consultaIdUsuario = "SELECT id_usuario FROM usuarios
                            WHERE email = '$email'";

        $resultadoConsulta = ejecutarConsulta($consultaIdUsuario, 'Usuario');

        if ($resultadoConsulta) {

            $id_usuario = $resultadoConsulta[0]->id_usuario;

            $consulta = "INSERT INTO puntajes 
            VALUES ($id_usuario,$id_game,$puntos) ";

            $resultadoConsulta = ejecutarConsulta($consulta, __CLASS__);

            return $resultadoConsulta;
        }

        return 'error no trae nada';
    }

    public static function buscarTodos(){
        $consulta = "SELECT id_usuario, id_game, puntos FROM puntajes";
        $resultadoConsulta = ejecutarConsulta($consulta, __CLASS__);
        return $resultadoConsulta;
    }

    public function buscarPuntajeUsuario($emailUsuario){
        $id_Usuario = Usuario::buscarIdUsuario($emailUsuario);
        if ($id_Usuario) {
            $consulta = "SELECT u.nombre, u.apellido, u.tipo_suscripcion, p.puntos,g.nombre
            FROM usuarios u
            INNER JOIN games g ON $id_Usuario = g.id_game
            INNER JOIN puntajes p ON g.id_game = p.id_game";

            $resultadoConsulta = ejecutarConsulta($consulta, __CLASS__);
            return $resultadoConsulta;
        }
        return 'error de consulta';
    }

    public function actualizarPuntaje($datosPuntajeUsuario){
        $id_game = $datosPuntajeUsuario->id_game;
        $puntos = $datosPuntajeUsuario->puntos;
        $email = $datosPuntajeUsuario->email;

        $usuario = new Usuario();

        //ACA PUEDE QUE EXPLOTE PERO SE ARREGLARIA RAPIDO
        $id_usuario = $usuario->buscarUsuarioLogueado($email);

        $consulta = "UPDATE puntajes 
                        SET puntos = $puntos  
                        WHERE id_usuario = '$id_usuario' 
                        AND id_game = '$id_game'";

        $resultadoConsulta = ejecutarConsulta($consulta, __CLASS__);
        return $resultadoConsulta;
    }

}
