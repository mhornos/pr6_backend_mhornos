<?php
//Miguel Angel Hornos Granda

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "../Model/canviarPassw.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuari = $_SESSION['usuari'] ?? null;
    $contrasenya = $_POST["contrasenya"] ?? null;
    $contrasenyaNova1 = $_POST["contrasenyaNova1"] ?? null;
    $contrasenyaNova2 = $_POST["contrasenyaNova2"] ?? null;

    $errors = [];

    // comprobar que tots els camps estan omplerts
    if (empty($contrasenya) || empty($contrasenyaNova1)) {
        $errors[] = "tots els camps són obligatoris ❌";
    } else {
        if (isset($_SESSION['usuari'])) {
            // obtendre la password actual de l'usuari desde la BD
            $usuariDades = obtenirUsuariContrasenya($usuari);
            if ($usuariDades && password_verify($contrasenya, $usuariDades["contrasenya"])) {    
                // verificar que les noves contrasenyes coincideixen
                if ($contrasenyaNova1 === $contrasenyaNova2) {
                    // requisits de la contrasenya nova
                    if (strlen($contrasenyaNova1) < 8) {
                        $errors[] = "la nova contrasenya ha de tenir almenys 8 caràcters ❌";
                    }
                    if (!preg_match('/[0-9]/', $contrasenyaNova1)) {
                        $errors[] = "la nova contrasenya ha de contenir almenys un número ❌";
                    }
                    if (!preg_match('/[A-Z]/', $contrasenyaNova1)) {
                        $errors[] = "la nova contrasenya ha de contenir almenys una lletra majúscula ❌";
                    }
                    if (!preg_match('/[a-z]/', $contrasenyaNova1)) {
                        $errors[] = "la nova contrasenya ha de contenir almenys una lletra minúscula ❌";
                    }
    
                    // mi no hi ha errors, actualitzem la contrasenya
                    if (empty($errors)) {
                        if (canviarContrasenya($usuari, $contrasenyaNova1)) {
                            echo "contrasenya canviada correctament ✅";
                        } else {
                            $errors[] = "error en actualitzar la contrasenya ❌";
                        }
                    }
                } else {
                    $errors[] = "les noves contrasenyes no coincideixen ❌";
                } 
            } else {
                $errors[] = "la contrasenya actual no és correcta ❌";
            }
        } else {
            $errors[] = "no has iniciat sessió ❌";
        }   
    }

    // mostrar tots els errors trobats en el procés de validació
    foreach ($errors as $error) {
        echo "<p>$error</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mhornos</title>

    <link rel="stylesheet" href="..\Estils\estils.css">
</head>
<body>
    <br><h2>Canviar password:</h2><br>
    <form action="../Controlador/canviarPassw.php" method="post">
    <label for="contrasenya">Contrasenya actual:</label>
    <input type="password" id="contrasenya" name="contrasenya">

    <label for="contrasenyaNova1">Nova contrasenya:</label>
    <input type="password" id="contrasenyaNova1" name="contrasenyaNova1" >

    <label for="contrasenyaNova2">Confirmació nova contrasenya:</label>
    <input type="password" id="contrasenyaNova2" name="contrasenyaNova2">

    <p>La contrasenya ha de tenir almenys 8 caràcters, un número, una majúscula i una minúscula.</p><br>

    <input type="submit" name="Canviar" value="Canviar">
    </form>
    <a href="../Index.php?pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 1; ?>">
        <button>Tornar a inici</button>
    </a>
</body>
</html>
