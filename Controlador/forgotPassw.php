<!-- Miguel Angel Hornos -->
 
<?php
require "../Model/forgotPassw.php";
require "../Model/connexio.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "../lib/PHPMailer/src/PHPMailer.php";
require "../lib/PHPMailer/src/SMTP.php";
require "../lib/PHPMailer/src/Exception.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $errors = [];
    $correu = $_POST["correu"];
    
    //si existeix el correu crea el token i la expiracio
    if(existeixCorreu($correu, $connexio)){
        $token = bin2hex(random_bytes(16));
        $expiracio = date("Y-m-d H:i:s", strtotime("+1 hour"));

        //si afegeix el nou token correctament envia el correu
        if (actualitzarToken($correu, $token, $expiracio, $connexio)){
            $mail = new PHPMailer(true);
            try{
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'm.hornos@sapalomera.cat';
                $mail->Password = 'utabymkojerikdgf'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('m.hornos@sapalomera.cat', 'Recuperació de password');
                $mail->addAddress($correu);

                $template = file_get_contents("../Vistes/Correu.html");
                $reset_link = "http://localhost/Servidor/Practiques/Pr5/Vistes/RestartPassword.php?token=$token";
                $template = str_replace("{{reset_link}}", $reset_link, $template);

                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = "Recuperar password";
                $mail->Body = $template;

                $mail->send();
            } catch (Exception $e) {
                $errors[] = "no em pogut enviar el correu. Error: {$mail->ErrorInfo} ❌";
            }
        } else{
            $errors[] = "no em pogut actualitzar el token del correu '$correu' ❌";
        }
    } else {
        $errors[] = "el correu '$correu' no està registrat a la nostra base de dades ❌";
    }

    //es mostra els errors o el missatge de tot correcte
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p><span class='error'>$error</p>";
        }
    } else {
        echo "<p>t'hem enviat un correu per recuperar la teva password ✅</p> ";
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