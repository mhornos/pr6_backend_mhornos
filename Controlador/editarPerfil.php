<?php
//Miguel Angel Hornos Granda

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "../Model/editarPerfil.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuari = $_POST["usuari"] ?? null;
    $correu = $_POST["correu"] ?? null;
    $ciutat = $_POST["ciutat"] ?? null;
    $imatge = $_POST["imatge"] ?? null;

    $usuariActual = $_SESSION['usuari'];
    $correuActual = obtenirCorreu($usuariActual); 
    $ciutatActual = obtenirCiutat($usuariActual); 
    $imatgeActual = obtenirImatge($usuariActual);

    $errors = [];

    if ($usuari == $usuariActual && $correu == $correuActual && $ciutat == $ciutatActual && $imatge == $imatgeActual) {
        $errors[] = "no has modificat cap dada ❌";
    }

    if (empty($usuari)) {
        $errors[] = "el nom d'usuari està buit ❌";
    } elseif (strlen($usuari) > 20) {
        $errors[] = "el nom no pot tenir més de 20 caràcters ❌";
    }

    if (empty($correu)) {
        $errors[] = "el correu està buit ❌";
    } elseif (!filter_var($correu, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "el correu no és vàlid ❌";
    }

    if (empty($ciutat)) {
        $errors[] = "la ciutat està buida ❌";
    }
    
    if (!empty($imatge)) {
        if (!filter_var($imatge, FILTER_VALIDATE_URL)) {
            $errors[] = "l'enllaç de la imatge no és una URL vàlida ❌";
        } 
    }

    if (empty($errors)) {
        editarUsuari($usuari, $correu, $ciutat, $imatge);

    }

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
    <link rel="stylesheet" href="..\Estils\estils.css">
    <title>mhornos</title>
</head>
<body>
    <h2>Editar perfil:</h2><br>
    <form action="../Controlador/editarPerfil.php" method="post">
    <div class="imatge-editar">
        <img src="<?php echo htmlspecialchars(obtenirImatgeEdicio($_SESSION['usuari'])); ?>" alt="Imatge de perfil">
    </div><br>

    <label for="usuari">Editar nom d'usuari:</label>
    <input type="text" id="usuari" name="usuari" placeholder="Nom d'usuari" value="<?php echo htmlspecialchars($usuari ?? ''); ?>">

    <label for="correu">Editar correu electronic:</label>
    <input type="email" id="correu" name="correu" placeholder="Correu" value="<?php echo htmlspecialchars($correu ?? ''); ?>">

    <label for="ciutat">Editar ciutat:</label>
    <input type="text" id="ciutat" name="ciutat" placeholder="Ciutat" value="<?php echo htmlspecialchars($ciutat ?? ''); ?>">

    <label for="imatge">Editar imatge:</label>
    <input type="text" id="imatge" name="imatge" placeholder="Enllaç d'imatge" value="<?php echo htmlspecialchars($imatge ?? ''); ?>">

    <input type="submit" name="Editar" value="Editar">
</form>


    <a href="../Index.php?pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 1; ?>">
            <button>Tornar a inici</button>
        </a>
</body>
</html>
