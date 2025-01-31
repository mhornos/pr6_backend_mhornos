<?php
//Miguel Angel Hornos Granda

// funció per establir una cookie
function crearCookie($nom, $valor, $durada = 86400 * 30) { // durada per defecte de 30 dies
    setcookie($nom, $valor, time() + $durada, "/"); // "/" fa que la cookie estigui disponible a tot el lloc
}

// funció per eliminar una cookie
function eliminarCookie($nom) {
    setcookie($nom, "", time() - 3600, "/"); // estableix la cookie en el passat per eliminar-la
}

// funció per obtenir el valor d'una cookie
function obtenirCookie($nom) {
    return isset($_COOKIE[$nom]) ? $_COOKIE[$nom] : null;
}
?>

<?php
//salutacio al usuari
if (obtenirCookie("salutacio") && isset($_SESSION["usuari"])) { ?>
    <div class="salutacio">
        Benvingut, <?php echo htmlspecialchars($_SESSION["usuari"]); ?>! 👋
    </div>
<?php }