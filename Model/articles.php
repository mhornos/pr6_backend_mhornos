<?php
//Miguel Angel Hornos Granda

//retorna la llista de vehicles de l'usuari actual amb la ciutat
function obtenirVehicles($usuari) {
    try {
        require "connexio.php";

        $consulta = $connexio->prepare("SELECT article.ID, article.marca, article.model, article.any, 
        article.color, article.matricula, article.nom_usuari, article.imatge, usuaris.ciutat FROM article
        JOIN usuaris ON article.nom_usuari = usuaris.nombreUsuario WHERE article.nom_usuari = :usuari");

        $consulta->bindParam(":usuari", $usuari);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "error de connexió: " . $e->getMessage() . " ❌";
    }
}

//elimina un vehicle de la bd amb confirmació
function eliminarVehicle($id){
    try {
        require "connexio.php";
        
         // si aún no ha confirmado, solo mostramos confirmación y salimos
        if (!isset($_POST['confirmar'])) {
            include_once "../Vistes/confirmEsborrar.php";
            return;
        }

    if (isset($_POST['confirmar'])) {
        if ($_POST['confirmar'] === 'Si') {
            $consultaEliminar = $connexio->prepare("DELETE FROM article WHERE id = :id");
            $consultaEliminar->bindParam(':id', $id);

            if ($consultaEliminar->execute()) {
                return "article amb ID " . htmlspecialchars($id) . " eliminat correctament ✅";
            } else {
                echo "error al eliminar article ❌";
            }
        } else {
            echo "eliminació cancel·lada ✅";
        }
    }

    } catch (PDOException $e) {
        echo "error de conexió: " . $e->getMessage() . " ❌";
    }
}


?>
