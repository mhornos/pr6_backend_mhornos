<!-- Miguel Angel Hornos  -->

<?php
// funció per inserir articles
function insertArticle($marca, $model, $any, $color, $matricula, $imatge, $usuari) {
    try {
        // array per guardar els errors que es puguin produir durant la validació
        $errors = [];

        // ens connectem amb la base de dades
        require "connexio.php";

        // verifiquem si la matrícula ja existeix a la base de dades
        $consultaMatricula = $connexio->prepare("SELECT COUNT(*) FROM article WHERE matricula = :matricula");
        $consultaMatricula->bindParam(':matricula', $matricula);
        $consultaMatricula->execute();
        $matriculaExisteix = $consultaMatricula->fetchColumn();
            
        if ($matriculaExisteix > 0) {
            $errors[] = "la matrícula '" . htmlspecialchars($matricula) . "' ja existeix ❌";
        }

        // si hi ha errors, els mostrem
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
            return; // finalitzem l'execució si hi ha errors
        }
        
        // preparem la consulta per inserir l'article a la base de dades
        $consultaInsert = $connexio->prepare("INSERT INTO article (marca, model, any, color, matricula, nom_usuari, imatge) 
                                                VALUES (:marca, :model, :any, :color, :matricula, :nom_usuari, :imatge)");
        $consultaInsert->bindParam(':marca', $marca);
        $consultaInsert->bindParam(':model', $model);
        $consultaInsert->bindParam(':any', $any);
        $consultaInsert->bindParam(':color', $color);
        $consultaInsert->bindParam(':matricula', $matricula);
        $consultaInsert->bindParam(':nom_usuari', $usuari);
        $consultaInsert->bindParam(':imatge', $imatge);

        // si tot està correcte executem la consulta i mostrem un missatge d'èxit
        if ($consultaInsert->execute()) {
            $ultimId = $connexio->lastInsertId();
            echo "article amb ID " . $ultimId . " inserit correctament ✅";
        } else {
            echo "error al inserir article ❌";
        }
        
    } catch (PDOException $e) {
    echo "error de connexió: " . $e->getMessage() . " ❌";
    }
}

?>
