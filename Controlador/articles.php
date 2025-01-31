<!-- Miguel Angel Hornos Granda -->
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "../Model/articles.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"] ?? null;
    $marca = $_POST['marca'] ?? '';
    $model = $_POST['model'] ?? '';
    $any = $_POST['any'] ?? '';
    $color = $_POST['color'] ?? '';
    $matricula = $_POST['matricula'] ?? '';
    $imatge = $_POST['imatge'] ?? '';
    $boton = $_POST['boton'] ?? null;

    if ($boton) {
        switch ($boton) {
            case 'Editar':{
                include_once "../Vistes/Modificar.php";
                break;
            }
            case 'Eliminar':{
                echo "eliminar: " .  $id;
                eliminarVehicle($id);
                include_once "../Vistes/Articles.php";
                break;
            }
            case 'QR':{
                echo "qr";
                echo " ". $id;
                break;
            }
        }
    }
}
?>
