<?php
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    $conexion = new mysqli('localhost', 'root', '', 'sonicwaves');
    sleep(1);

    $id_grupo_recomendado = $conexion->query("SELECT id from grupo where id <> 0 and foto is not null and activo = 1 order by rand() limit 1");
    $fila = $id_grupo_recomendado->fetch_array(MYSQLI_ASSOC);
    $id = $fila["id"];
    // $sentencia_grupo_recomendado = $conexion->prepare("SELECT enlace, grupo from foto_grupo where grupo = ? order by rand() limit 1");
    // $sentencia_grupo_recomendado->bind_param('i', $id);
    // $sentencia_grupo_recomendado->bind_result($recomendado, $grupo);
    // $sentencia_grupo_recomendado->execute();
    // $sentencia_grupo_recomendado->store_result();
    // $sentencia_grupo_recomendado->fetch();
    
    
    // if($sentencia_grupo_recomendado->num_rows != 0){
    //     $sentencia_grupo_recomendado->close();
    //     $datos["grupo_recomendado"] = $recomendado;
    //     $datos["id_grupo_recomendado"] = $grupo;
    // }else{
        // $sentencia_grupo_recomendado->close();
        $sentencia_grupo_recomendado_v2 = $conexion->prepare("SELECT nombre, foto, id, discografica from grupo where id = ? and foto is not null");
        $sentencia_grupo_recomendado_v2->bind_param('i', $id);
        $sentencia_grupo_recomendado_v2->bind_result($nombre, $recomendado, $grupo, $disc);
        $sentencia_grupo_recomendado_v2->execute();
        $sentencia_grupo_recomendado_v2->fetch();
        $sentencia_grupo_recomendado_v2->close();
        $datos["grupo_recomendado"] = $recomendado;
        $datos["id_grupo_recomendado"] = $grupo;
        $datos["nombre_grupo_recomendado"] = $nombre;
        $datos["discografica"] = $disc;
    // }
    

    // $recomendado=$sentencia_grupo_recomendado->get_result()->fetch_row()[0];
    

    // $sentencia_grupo_recomendado_v2 = $conexion->prepare("SELECT foto from grupo where id = '19' and foto <> null");
    // // $sentencia_grupo_recomendado_v2->bind_param('i', $id);
    // $sentencia_grupo_recomendado_v2->execute();
    // $recomendado = $sentencia_grupo_recomendado_v2->get_result()->fetch_row()[0];
    // $sentencia_grupo_recomendado_v2->close();
    
    // $datos["grupo_recomendado"] = $recomendado;
    
    $datos_recogidos = [];
    $sentencia_albumes = $conexion->query("select a.id id, titulo, a.foto foto, nombre autor, g.id grupo_id from album a, grupo g where a.grupo = g.id");
    while($fila = $sentencia_albumes->fetch_array(MYSQLI_ASSOC)){
        $datos_recogidos[] = $fila;
    }
    $datos['datos'] = $datos_recogidos;

    echo json_encode($datos);