<?php
//Miguel Angel Hornos Granda

//retorna la llista de usuaris registrats
function obtenirUsuaris() {
    try {
        require "connexio.php";

        $consulta = $connexio->prepare("SELECT ID, nombreUsuario, correo FROM usuaris WHERE nombreUsuario != 'admin'");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "error de connexió: " . $e->getMessage() . " ❌";
    }
}

//elimina el usuari seleccionat de la bd
function esborrarUsuari($id) {
    try {
        require "connexio.php";
        
        if (!isset($_POST['confirmar'])) {
            include_once "../Vistes/confirmEliminarusuari.php";
        }

        if (isset($_POST['confirmar'])) {
            if ($_POST['confirmar'] === 'Si') {
                $consultaEliminar = $connexio->prepare("DELETE FROM usuaris WHERE id = :id");
                $consultaEliminar->bindParam(':id', $id);

                if ($consultaEliminar->execute()) {
                    echo "usuario amb ID " . htmlspecialchars($id) . " eliminat correctament ✅";
                } else {
                    echo "error al eliminar l'usuari ❌";
                }
            } else {
                echo "eliminació cancelada ✅";
            }
        }

    } catch (PDOException $e) {
        echo "error de conexió: " . $e->getMessage() . " ❌";
    }
}
?>
