<?php
//Miguel Angel Hornos Granda

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require "../Model/login.php";
require "cookies.php";
require_once "../env.php";

// procesem el formulari de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuari = $_POST["usuari"] ?? null;
    $contrasenya = $_POST["contrasenya"] ?? null;
    $rememberMe = isset($_POST["remember_me"]) && $_POST["remember_me"] == "1";
    $recaptcha = $_POST["g-recaptcha-response"] ?? null;

    $errors = [];


    if (empty($usuari)){
        $errors[] = "falta el nom d'usuari ❌";
    }
    if (empty($contrasenya)){
        $errors[] = "falta la contrasenya ❌";
    }


    //si no omplim el recaptcha salta error
    if (isset($_SESSION["intentsFallats"]) && $_SESSION["intentsFallats"] >= 3 && empty($recaptcha)){
        $errors[] = "has de completar el reCAPTCHA ❌";
    }

    //si no hi ha errors inicia sessió, sino s'activa el recaptcha 
    if(empty($errors)){
        if (isset($_SESSION["intentsFallats"]) && $_SESSION["intentsFallats"] >= 3){
            $clauSecreta = clauSecreta;

            $resposta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$clauSecreta&response=$recaptcha");
            $respostaClau = json_decode($resposta,true);

            if($respostaClau["success"] != 1){
                $errors[] = "el reCAPTCHA no es vàlid❌";
            }
        }
    }

    // si no hi ha errors intentem iniciar sessió, si n'hi ha aumenta els intents
    if ($usuariDades = iniciarSesio($usuari, $contrasenya)){
        if (empty($errors)){
            $_SESSION["usuari"] = $usuari; 
            crearCookie("salutacio", $usuari); 
            if ($rememberMe) {
                crearCookie("usuari", $usuari);
                crearCookie("contrasenya", $contrasenya);
            } else {
                eliminarCookie("usuari");
                eliminarCookie("contrasenya");
            }
            $_SESSION["intentsFallats"] = 0;
            header("Location: ../Index.php");
            exit;
        } 
    } else {
        $errors[] = "usuari o contrasenya incorrectes❌";
        $_SESSION["intentsFallats"] = ($_SESSION["intentsFallats"] ?? 0) + 1;
    }

    foreach ($errors as $error) {
        echo "<p>$error</p>";
    }
}
?>

<!-- tornem a mostrar el formulari amb les dades ja introduides per agilitzar el proces de repetir l'accio -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mhornos</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <link rel="stylesheet" href="..\Estils\estils.css">
</head>
<body>
    <br><h2>Inicia sessió:</h2>
    <br>
    <form method="POST">
        <label for="usuari">Usuari</label>
        <input type="text" name="usuari" id="usuari" placeholder="Introudeix l'usuari" value="<?php echo htmlspecialchars($usuari ?? ''); ?>">
        
        <label for="contrasenya">Contrasenya</label>
        <input type="password" name="contrasenya" id="contrasenya" placeholder="Introudeix la contrasenya" value="<?php echo htmlspecialchars($contrasenya ?? ''); ?>">
        
        <?php if (isset($_SESSION['intentsFallats']) && $_SESSION['intentsFallats'] >= 3) { ?>
            <div class="g-recaptcha" data-sitekey="6LeX8Y0qAAAAAN_VXumrgWfMGgoTqfD5XvZ4NZp0"></div>
        <?php } ?>
        
        <br>
        
        <input type="submit" name="Login" value="Login">
        
        <label for="remember_me">
            <input type="checkbox" name="remember_me" id="remember_me" value="1" <?php echo isset($_COOKIE["usuari"]) ? "checked" : ""; ?>> 
            Recordar-me
        </label>
        
        <br>
        No tinc compte: <a href="../Vistes/Register.php"> Crea un compte </a><br>
        He oblidat la contrasenya: <a href="../Vistes/forgotPassw.php"> Recuperar-la </a><br><br>
    </form>

    
    <br><a href="../Index.php?pagina=<?php echo isset($_GET['pagina']) ? $_GET['pagina'] : 1; ?>">
        <button>Tornar a inici</button>
    </a><br>
</body>
</html>
