<?php

//Miguel Angel Hornos Granda

// endpoint para obtener el primer token jwt para el usuario autenticado en la sesion

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

try {
    require_once __DIR__ . '/../Model/connexio.php';
    require_once __DIR__ . '/../lib/jwt_helper.php';

    if (!isset($_SESSION['usuari'])) {
        http_response_code(401);
        echo json_encode([
            'error' => 'has d iniciar sessio abans de demanar el token❌'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $usuari = obtenirUsuariPerNom($connexio, $_SESSION['usuari']);

    if (!$usuari) {
        http_response_code(404);
        echo json_encode([
            'error' => 'usuari no trobat❌'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $nouToken = rotarJwt($connexio, $usuari);

    echo json_encode([
        'status' => 'ok',
        'token' => $nouToken['token'],
        'expira' => $nouToken['expiracio_mysql']
    ], JSON_UNESCAPED_UNICODE);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'error intern❌',
        'details' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}