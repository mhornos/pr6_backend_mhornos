<!-- Miguel Angel Hornos  -->

<?php

// funció per modificar articles
function modificarArticle($marca, $model, $any, $color, $matricula, $imatge, $id) {
    try {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // obtenim el usuari mediant la sessió
        $usuari = $_SESSION["usuari"] ?? null;

        // array per guardar els errors que es puguin produir durant la validació
        $errors = [];

        // ens connectem amb la base de dades
        require "connexio.php";

        // verifiquem si la nova matrícula ja existeix en un altre article
        $consultaMatricula = $connexio->prepare("SELECT COUNT(*) FROM article WHERE matricula = :matricula AND id != :id");
        $consultaMatricula->bindParam(':matricula', $matricula);
        $consultaMatricula->bindParam(':id', $id);
        $consultaMatricula->execute();
        $matriculaExisteix = $consultaMatricula->fetchColumn();

        // si la matrícula ja existeix en un altre article mostrem error
        if ($matriculaExisteix > 0) {
            $errors[] = "la matrícula '" . htmlspecialchars($matricula) . "' ja existeix en un altre article ❌";
        }

        // comprovem si existeix un article amb aquest id a la base de dades
        $consultaExistencia = $connexio->prepare("SELECT nom_usuari FROM article WHERE id = :id");
        $consultaExistencia->bindParam(':id', $id);
        $consultaExistencia->execute();

        // si no hi ha cap article amb aquest id mostrem un error
        if ($consultaExistencia->rowCount() == 0) {
            $errors[] = "no s'ha trobat cap article amb aquest ID ❌";
        } else {
            // si el troba obtenim l'usuari creador de l'article
            $article = $consultaExistencia->fetch(PDO::FETCH_ASSOC);
            $usuariCreador = $article['nom_usuari'];

            // i comprovem si l'usuari de la sessió és el mateix que el creador de l'article
            if ($usuari !== $usuariCreador) {
                $errors[] = "no tens permís per modificar aquest article ❌";
            }
        }

        // comencem a construir la consulta per modificar l'article
        $modificarDades = "UPDATE article SET ";
        $primeraModificacio = true;

        // si s'omple la marca l'afegim a la consulta
        if (!empty($marca)) {
            if (!$primeraModificacio) {
                $modificarDades .= ", ";
            }
            $modificarDades .= "marca = :marca";
            $primeraModificacio = false;
        }
        
        // si s'omple el model l'afegim a la consulta
        if (!empty($model)) {
            if (!$primeraModificacio) {
                $modificarDades .= ", ";
            }
            $modificarDades .= "model = :model";
            $primeraModificacio = false;
        }

        // si s'omple el any l'afegim a la consulta
        if (!empty($any)) {
            if (!$primeraModificacio) {
                $modificarDades .= ", ";
            }
            $modificarDades .= "any = :any";
            $primeraModificacio = false;
        }
        
        // si s'omple el color l'afegim a la consulta
        if (!empty($color)) {
            if (!$primeraModificacio) {
                $modificarDades .= ", ";
            }
            $modificarDades .= "color = :color";
            $primeraModificacio = false;
        }
        
        // si s'omple la matricula l'afegim a la consulta
        if (!empty($matricula)) {
            if (!$primeraModificacio) {
                $modificarDades .= ", ";
            }
            $modificarDades .= "matricula = :matricula";
            $primeraModificacio = false;
        }
        
        // si s'omple la imatge l'afegim a la consulta
        if (!empty($imatge)) {
            if (!$primeraModificacio) {
                $modificarDades .= ", ";
            }
            $modificarDades .= "imatge = :imatge";
            $primeraModificacio = false;
        }

        // si no hi ha dades per modificar mostrem un missatge d'error
        if ($primeraModificacio) {
            $errors[] = "no s'han proporcionat dades per modificar ❌";
        }

        // si hi ha errors, els mostrem
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
            return; // finalitzem l'execució si hi ha errors
        }

        // finalitzem la consulta afegint la condició where per seleccionar l'id
        $modificarDades .= " WHERE id = :id";
        $consultaModif = $connexio->prepare($modificarDades);
        $consultaModif->bindParam(':id', $id);
        
        // assignem els nous valors als seus corresponents paràmetres
        if (!empty($marca)) {
            $consultaModif->bindParam(':marca', $marca);
        }
        
        if (!empty($model)) {
            $consultaModif->bindParam(':model', $model);
        }

        if (!empty($any)) {
            $consultaModif->bindParam(':any', $any);
        }
        
        if (!empty($color)) {
            $consultaModif->bindParam(':color', $color);
        }
        
        if (!empty($matricula)) {
            $consultaModif->bindParam(':matricula', $matricula);
        }
        
        if (!empty($imatge)) {
            $consultaModif->bindParam(':imatge', $imatge);
        }

        // executem la consulta de modificació i mostrem missatge d'èxit o error
        if ($consultaModif->execute()) {
            echo "article amb ID " . $id . " modificat correctament ✅";
        } else {
            echo "error al modificar article ❌";
        }

    } catch (PDOException $e) {
        echo "error de connexió: " . $e->getMessage() . " ❌";
    }
}

?>
