<!-- Miguel Angel Hornos -->

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// incloem el fitxer de modificar que conté la funció modificarArticle
require "../Model/modificar.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // obtenim la informacio del formulari
    $id = $_POST["id"] ?? null;
    $marca = $_POST["marca"] ?? null;
    $model = $_POST["model"] ?? null;
    $any = $_POST["any"] ?? null;
    $color = $_POST["color"] ?? null;
    $matricula = $_POST["matricula"] ?? null;
    $imatge = $_POST["imatge"] ?? null;

    // obtenim el nom de l'usuari de la sessió
    $usuari = $_SESSION["usuari"] ?? null;

    // array per guardar els errors que es puguin produir durant la validació
    $errors = [];

    // si falta l'id mostrem un missatge d'error
    if (empty($id)) {   
        $errors[] = "falta l'ID ❌";
    }
    // si la matrícula té més de 12 dígits mostrem missatge d'error
    if (strlen($matricula) > 12) {
        $errors[] = "la matrícula no pot tenir més de 12 caràcters ❌";
    }

    // si no hi ha errors, modifiquem l'article cridant la funció modificarArticle
    if (empty($errors)) {
        modificarArticle($marca, $model, $any, $color, $matricula, $imatge, $id);
    }  

    // mostrem tots els errors trobats en el procés de validació
    foreach ($errors as $error) {
        echo "<p>$error</p>";
    }
}
?>


<!-- tornem a mostrar el formulari amb les dades ja introduides per agilitzar el proces de repetir l'accio -->
<?php
include_once "../Vistes/Modificar.php";
?>