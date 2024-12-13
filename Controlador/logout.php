<!-- Miguel Angel Hornos -->

<?php
require "cookies.php";

//destruim la sessió y redirigim a inici
session_start();
session_unset();
session_destroy();
eliminarCookie("salutacio");
header("Location: ../Index.php");

exit;
?>
