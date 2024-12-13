<!-- Miguel Angel Hornos  -->

<?php
// funció per registrar usuaris
function crearUsuari($usuari, $contrasenya, $correu, $ciutat, $imatge) {
    try {
        $errors = [];

        // ens connectem amb la base de dades
        require "connexio.php";

        // comprovem si el nom d'usuari ja existeix
        $consultaExistenciaUsuari = $connexio->prepare("SELECT * FROM usuaris WHERE nombreUsuario = :usuari");
        $consultaExistenciaUsuari->bindParam(':usuari', $usuari);
        $consultaExistenciaUsuari->execute();
        if ($consultaExistenciaUsuari->rowCount() > 0) {
            $errors[] = "el nom d'usuari ja existeix ❌";
        }

        // comprovem si el correu ja existeix
        $consultaExistenciaCorreu = $connexio->prepare("SELECT * FROM usuaris WHERE correo = :correu");
        $consultaExistenciaCorreu->bindParam(':correu', $correu);
        $consultaExistenciaCorreu->execute();
        if ($consultaExistenciaCorreu->rowCount() > 0) {
            $errors[] = "ja hi ha un usuari vinculat a aquest correu ❌";
        }

        // si hi ha errors, els mostrem
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
            return;
        }

        // si no existeix, creem el nou usuari
        $contrasenyaEncriptada = password_hash($contrasenya, PASSWORD_DEFAULT); 

        $insert = $connexio->prepare("INSERT INTO usuaris (nombreUsuario, contrasenya, correo, ciutat, imatge) VALUES (:usuari, :contrasenya, :correu, :ciutat, :imatge)");
        $insert->bindParam(':usuari', $usuari);
        $insert->bindParam(':contrasenya', $contrasenyaEncriptada); 
        $insert->bindParam(':ciutat', $ciutat);
        $insert->bindParam(':correu', $correu);
        $insert->bindParam(':imatge', $imatge);

        $insert->execute();

        echo "usuari creat correctament! ✅";
    } catch (PDOException $e) {
        echo "error de connexió: " . $e->getMessage() . " ❌";
    }
}

// funció per comprovar si un usuari existeix a la bd
function usuariExisteix($usuari) {
    try {
        require "connexio.php";

        $consulta = $connexio->prepare("SELECT * FROM usuaris WHERE nombreUsuario = :usuari");
        $consulta->bindParam(':usuari', $usuari);
        $consulta->execute();

        if ($consulta->rowCount() > 0) {
            return true;  
        } else {
            return false;
        }

    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
        return false;  
    }
}

//crea el usuari admin si no existeix
function crearAdmin() {
    try {
        require "connexio.php";

        $usuari = "admin";
        $contrasenyaEncriptada = password_hash("Admin1234_", PASSWORD_DEFAULT); 
        $correu = "admin@gmail.com";
        $ciutat = "admin";
        $imatge = "";

        $insert = $connexio->prepare("INSERT INTO usuaris (nombreUsuario, contrasenya, correo, ciutat, imatge) VALUES (:usuari, :contrasenya, :correu, :ciutat, :imatge)");
        $insert->bindParam(':usuari', $usuari);
        $insert->bindParam(':contrasenya', $contrasenyaEncriptada); 
        $insert->bindParam(':ciutat', $ciutat);
        $insert->bindParam(':correu', $correu);
        $insert->bindParam(':imatge', $imatge);

        $insert->execute();

    } catch (PDOException $e) {
        echo "error de connexió: " . $e->getMessage() . " ❌";
    }
}
?>
