<?php
require "../Model/connexio.php";
require "../Model/forgotPassw.php";

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $token = $_POST['token'];
    $contrasenya = $_POST['contrasenya'];
    $contrasenya2 = $_POST['contrasenya2'];

    $errors = [];

    // comprovem si les contrasenyes estan buides i si coincideixen
    if (empty($contrasenya)) {
        $errors[] = "falta la contrasenya ❌";
    } elseif (empty($contrasenya2)) {
        $errors[] = "has de repetir la contrasenya ❌";
    } elseif ($contrasenya !== $contrasenya2) {
        $errors[] = "les contrasenyes no coincideixen ❌";
    } else {
        // comprovem si la longitud de la contrasenya és inferior a 8 caràcters
        if (strlen($contrasenya) < 8) {
            $errors[] = "la contrasenya ha de tenir almenys 8 caràcters ❌";
        }
        
        // comprovem si la contrasenya conté almenys un número
        if (!preg_match('/[0-9]/', $contrasenya)) {
            $errors[] = "la contrasenya ha de contenir almenys un número ❌";
        }

        // comprovem si la contrasenya conté almenys una lletra majúscula
        if (!preg_match('/[A-Z]/', $contrasenya)) {
            $errors[] = "la contrasenya ha de contenir almenys una lletra majúscula ❌";
        }

        // comprovem si la contrasenya conté almenys una lletra minúscula
        if (!preg_match('/[a-z]/', $contrasenya)) {
            $errors[] = "la contrasenya ha de contenir almenys una lletra minúscula ❌";
        }
    }

    //validar el token
    $resultat = validarToken($token, $connexio);
    if (!$resultat){
        $errors[] = "token no vàlid ❌";
    } elseif (strtotime($resultat['expiracio_token']) < time()) {
        $errors[] = "el token ha caducat ❌";
    }
    
    //si hi ha errors tornem a mostrar el formulari amb els errors
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        include_once "../Vistes/RestartPassword.php";
        exit;
    }

    //encriptar la nova password i actualitzarla a la bd
    $contrasenyaEncriptada = password_hash($contrasenya, PASSWORD_DEFAULT);
    $correo = $resultat["correo"];

    if (actualitzarContrasenya($contrasenyaEncriptada, $correo, $connexio)) {
        echo "<p>la teva contrasenya s'ha actualitzat correctament ✅</p>";
        
    } else {
        echo "<p>hi ha hagut un error en actualitzar la contrasenya ❌</p>";
    }
}

?>
<!-- botó per tornar a inici -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mhornos</title>
    <link rel="stylesheet" href="../Estils/estils.css">
</head>
<body>
<a href="../Index.php?pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 1; ?>">
            <button>Tornar a inici</button>
        </a>
</body>
</html>