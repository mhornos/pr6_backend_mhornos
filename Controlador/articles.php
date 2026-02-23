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
            case 'Eliminar': {
                eliminarVehicle($id);

                if (isset($_POST['confirmar'])) {
                    $returnTo = $_POST['return_to'] ?? '../Index.php';

                    if (str_starts_with($returnTo, '/')) {
                        header("Location: $returnTo");
                    } else {
                        header("Location: ../Index.php");
                    }
                    exit;
                }
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
