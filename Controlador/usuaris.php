<?php
// Miguel Angel Hornos Granda

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "../Model/usuaris.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"] ?? null;
    esborrarUsuari($id);
}
?>

<?php
include_once "../Vistes/Usuaris.php";
?>
