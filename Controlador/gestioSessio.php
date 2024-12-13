<!-- Miguel Angel Hornos -->

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// definir el limit de inactivitat (40 minuts)
$limitInactiu = 40*60;

if (isset($_SESSION['usuari'])) {
    if (isset($_SESSION['last_activity'])) {
        $tempsInactiu = time() - $_SESSION['last_activity'];
        if ($tempsInactiu > $limitInactiu) {
            session_unset(); 
            session_destroy(); 
            require "cookies.php";
            eliminarCookie("salutacio");

            // missatge que la sessió ha caducat
            echo "<script>
                alert('La sessió s\'ha tancat per inactivitat.');
                window.location.href = './Index.php';
            </script>";
            
            exit();
        }
    }
}

// actualitzar el temps d'activitat
$_SESSION['last_activity'] = time();
?>
