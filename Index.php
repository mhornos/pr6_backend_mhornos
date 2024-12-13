 <?php
//Miguel Angel Hornos Granda

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "Controlador/cookies.php";
require_once "Controlador/gestioSessio.php";
require "Model/register.php";

//crea el usuari admin si no existeix
if (!usuariExisteix("admin")) {
    crearAdmin();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>mhornos</title>
        <link rel="stylesheet" href="Estils\estils.css">
    </head>
    <body>
        <h1>Mecànic Admin de Garatges</h1><br>
    </body>
</html>

<?php
include_once "Controlador/cookies.php";
include_once "Vistes/navbar.php";
include_once "Controlador/llistaArticles.php";
?>