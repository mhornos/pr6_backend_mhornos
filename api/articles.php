<?php

// api rest: proveir api propia per consultar els meus articles en format json amb jwt rotatiu

declare(strict_types=1);

// indica que la resposta sera json
header('Content-Type: application/json; charset=utf-8');

try {
    // carrega la connexio a la base de dades i el helper del jwt
    require_once __DIR__ . '/../Model/connexio.php';
    require_once __DIR__ . '/../lib/jwt_helper.php';

    // llegeix el bearer token de la capcalera authorization
    $token = obtenirBearerToken();

    // si no arriba cap token, retorna error
    if (!$token) {
        http_response_code(401);
        echo json_encode([
            'error' => 'falta el bearer token❌'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // valida el token rebut
    $usuariValid = validarJwt($connexio, $token);

    // si el token no es valid o ha expirat, retorna error
    if (!$usuariValid) {
        http_response_code(401);
        echo json_encode([
            'error' => 'token invalid o expirat❌'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // guarda l'usuari validat i comprova si es admin
    $usuariSessio = $usuariValid['nombreUsuario'];
    $esAdmin = ($usuariSessio === 'admin');

    // recull els parametres de la url
    $id = isset($_GET['id']) ? (int) $_GET['id'] : null;
    $q = trim($_GET['q'] ?? '');
    $limit = (int) ($_GET['limit'] ?? 20);

    // limita el minim i maxim de resultats
    if ($limit < 1) {
        $limit = 20;
    }

    if ($limit > 100) {
        $limit = 100;
    }

    // si arriba un id, retorna nomes un article
    if ($id) {
        if ($esAdmin) {
            $stmt = $connexio->prepare("SELECT * FROM article WHERE ID = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        } else {
            $stmt = $connexio->prepare("SELECT * FROM article WHERE ID = :id AND nom_usuari = :usuari");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':usuari', $usuariSessio, PDO::PARAM_STR);
        }

        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // si no existeix o no te permis, retorna error 404
        if (!$row) {
            http_response_code(404);
            echo json_encode([
                'error' => 'no trobat❌'
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }

        // genera un nou token i invalida l'anterior
        $nouToken = rotarJwt($connexio, $usuariValid);

        // envia l'article i el nou token
        echo json_encode([
            'data' => $row,
            'next_token' => $nouToken['token'],
            'token_expira' => $nouToken['expiracio_mysql']
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // prepara la consulta general de llistat
    $sql = "SELECT * FROM article";
    $params = [];

    // si no es admin, nomes pot veure els seus articles
    if (!$esAdmin) {
        $sql .= " WHERE nom_usuari = :usuari";
        $params[':usuari'] = $usuariSessio;
    }

    // si hi ha text de cerca, afegeix condicions
    if ($q !== '') {
        if ($esAdmin) {
            $sql .= " WHERE (
                marca LIKE :q
                OR model LIKE :q
                OR matricula LIKE :q
                OR nom_usuari LIKE :q
            )";
        } else {
            $sql .= " AND (
                marca LIKE :q
                OR model LIKE :q
                OR matricula LIKE :q
                OR nom_usuari LIKE :q
            )";
        }

        $params[':q'] = "%{$q}%";
    }

    // ordena per id descendent i limita resultats
    $sql .= " ORDER BY ID DESC LIMIT {$limit}";

    // prepara i executa la consulta
    $stmt = $connexio->prepare($sql);
    foreach ($params as $clave => $valor) {
        $stmt->bindValue($clave, $valor, PDO::PARAM_STR);
    }
    $stmt->execute();

    // obte tots els registres trobats
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // genera un nou token i invalida l'anterior
    $nouToken = rotarJwt($connexio, $usuariValid);

    // envia el recompte, les dades i el nou token
    echo json_encode([
        'count' => count($rows),
        'data' => $rows,
        'next_token' => $nouToken['token'],
        'token_expira' => $nouToken['expiracio_mysql']
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    // captura errors interns del servidor
    http_response_code(500);
    echo json_encode([
        'error' => 'error intern❌',
        'details' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}