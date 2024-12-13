<?php
// Miguel Angel Hornos Granda

//comproba si existeix el correu introuduit a la bd
function existeixCorreu($correu, $connexio){
    $consulta = $connexio->prepare("SELECT COUNT(*) FROM usuaris WHERE correo = :correo");
    $consulta->bindParam(":correo",$correu);
    $consulta->execute();

    $nCorreus = $consulta->fetchColumn();
    
    if ($nCorreus > 0){
        return true;
    } else {
        return false;
    }
}

//afegeix el token a la bd
function actualitzarToken($correu, $token, $expiracio, $connexio){
    $consulta = $connexio->prepare("UPDATE usuaris SET token = :token, expiracio_token = :expiracio_token WHERE correo = :correo");
    $consulta->bindParam(":token", $token);
    $consulta->bindParam("expiracio_token", $expiracio);
    $consulta->bindParam(":correo", $correu);

    return $consulta->execute();
}

//comproba si es un token valid i no ha caducat
function validarToken($token, $connexio){
    $consulta = $connexio->prepare("SELECT correo, expiracio_token FROM usuaris WHERE token = :token");
    $consulta->bindParam(":token", $token);
    $consulta->execute();

    return $consulta->fetch(PDO::FETCH_ASSOC);
}

//canvia la password i buida el token
function actualitzarContrasenya($contrasenyaEncriptada, $correu, $connexio){
    $consulta = $connexio->prepare("UPDATE usuaris SET contrasenya = :contrasenya, token = NULL, expiracio_token = NULL WHERE correo = :correo");
    $consulta->bindParam(":contrasenya",$contrasenyaEncriptada );
    $consulta->bindParam(":correo", $correu);

    return $consulta->execute();
}

?>