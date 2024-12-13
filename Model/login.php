<!-- Miguel Angel Hornos  -->

<?php
// funcio per comprobar que l'usuari existeix
function iniciarSesio($usuari,$contrasenya){
    try{
        // ens connectem amb la base de dades
        require "connexio.php";

        //comprobem si l'usuari existeix
        $existeixUsuari = $connexio->prepare("SELECT * FROM usuaris WHERE nombreUsuario = :usuari");
        $existeixUsuari->bindParam(":usuari",$usuari);
        $existeixUsuari->execute();
        
        //si existeix, comprobem que la password es correcta
        if ($existeixUsuari->rowCount() > 0){
            $usuariDades = $existeixUsuari->fetch(PDO::FETCH_ASSOC);
            $contrasenyaBD = $usuariDades["contrasenya"];

            // comprovem la contrasenya utilitzant password_verify
            if (password_verify($contrasenya, $contrasenyaBD)) {
                return $usuariDades; // retornem les dades de l'usuari si l'inici de sessió és correcte
            } else {
                return false; // la contrasenya no coincideix
            }
        } else {
            return false; // l'usuari no existeix
        }

    } catch (PDOException $e) {
        echo "Error de connexió: " . $e->getMessage() . " ❌";
        
    }
}

?>

