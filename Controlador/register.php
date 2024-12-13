<!-- Miguel Angel Hornos -->

<?php
// incloem el fitxer de registre que conté la funció crearUsuari
require "../Model/register.php";

// comprovem si la petició s'ha fet mitjançant POST (formulari enviat)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // recollim els valors del formulari amb l'operador nul (per si algun no ha estat enviat)
    $usuari = $_POST["usuari"] ?? null;
    $correu = $_POST["correu"] ?? null;
    $ciutat = $_POST["ciutat"] ?? null;
    $imatge = $_POST["imatge"] ?? null;
    $contrasenya = $_POST["contrasenya"] ?? null;
    $contrasenya2 = $_POST["contrasenya2"] ?? null;

    // array per guardar els errors que es puguin produir durant la validació
    $errors = [];

    // comprovem si el nom d'usuari està buit
    if (empty($usuari)) {
        $errors[] = "falta el nom d'usuari ❌";
    }

    //el nom no pot tenir més de 20 caracters
    if (strlen($usuari) > 20) {
        $errors[] = "el nom no pot tenir més de 20 caràcters ❌";
    }

    // comprovem si el correu està buit i si té un format vàlid
    if (empty($correu)) {
        $errors[] = "falta el correu ❌";
    } elseif (!filter_var($correu, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "el correu no és vàlid ❌";
    }

    // comprovem si la ciutat està buida
    if (empty($ciutat)) {
        $errors[] = "falta la ciutat ❌";
    }

    // validar imatge si s'introudeix
    if (!empty($imatge)) {
        if (!filter_var($imatge, FILTER_VALIDATE_URL)) {
            $errors[] = "l'enllaç de la imatge no és una URL vàlida ❌";
        } 
    }

    // comprovem si les contrasenyes estan buides i si coincideixen
    if (empty($contrasenya)) {
        $errors[] = "falta la contrasenya ❌";
    } elseif (empty($contrasenya2)) {
        $errors[] = "has de repetir la contrasenya ❌";
    } elseif ($contrasenya !== $contrasenya2) {
        $errors[] = "les contrasenyes no coincideixen ❌";
    } // comprovació de la validesa de la contrasenya
    else{
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

    // si no hi ha errors, creem l'usuari cridant la funció crearUsuari
    if (empty($errors)) {
        crearUsuari($usuari, $contrasenya, $correu, $ciutat, $imatge);
    }

    // mostrem tots els errors trobats en el procés de validació
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
    <br>
    <h2>Crear compte de mecànic:</h2>      
    <br><form method="POST">
        <input type="text" name="usuari" placeholder="Usuari" value="<?php echo htmlspecialchars($usuari ?? ''); ?>">
        <input type="text" name="correu" placeholder="Correu" value="<?php echo htmlspecialchars($correu ?? '' ); ?>">
        <input type="text" name="ciutat" placeholder="Ciutat" value="<?php echo htmlspecialchars($ciutat ?? ''); ?>">
        <input type="text" id="imatge" name="imatge" placeholder="Enllaç de imatge (opcional)" value="<?php echo htmlspecialchars($imatge ?? ''); ?>">
        <input type="password" name="contrasenya" placeholder="Contrasenya" value="">
        <input type="password" name="contrasenya2" placeholder="Repeteix la contrasenya" value="">
        <p>La contrasenya ha de tenir almenys 8 caràcters, un número, una majúscula i una minúscula.</p><br>

        <input type="submit" value="Registrar-se">
        Ja tinc un compte: <a href="../Vistes/Login.php"> Iniciar sessió </a>

    </form>

    <br><a href="../Index.php?pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 1; ?>">
        <button>Tornar a inici</button>
    </a><br>
</body>
</html>
