<?php
// PONT ENDPOINT: obtenir els models d'un fabricant de vehicles a partir de l'api publica (modelsByMake)

declare(strict_types=1);

// indica que la resposta sera json
header('Content-Type: application/json; charset=utf-8');

try {
    // recull la marca enviada per url
    $make = trim($_GET['make'] ?? '');

    // valida que arribi la marca
    if ($make === '') {
        echo json_encode([
            'error' => 'falta el parametre make❌'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // construeix la url de l'api externa
    $url = 'https://vpic.nhtsa.dot.gov/api/vehicles/GetModelsForMake/' . rawurlencode($make) . '?format=json';

    // consulta l'api externa
    $response = @file_get_contents($url);

    // controla si la consulta falla
    if ($response === false) {
        echo json_encode([
            'error' => 'no s\'ha pogut consultar l\'API externa❌'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // converteix la resposta json a array
    $data = json_decode($response, true);

    // comprova que la resposta sigui valida
    if (!is_array($data)) {
        echo json_encode([
            'error' => 'resposta JSON invalida de l\'API externa❌'
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // array on es guardaran els models
    $models = [];

    // recorre els resultats i extreu els noms dels models
    if (!empty($data['Results']) && is_array($data['Results'])) {
        foreach ($data['Results'] as $item) {
            if (!empty($item['Model_Name'])) {
                $models[] = $item['Model_Name'];
            }
        }
    }

    // elimina duplicats i ordena alfabeticament
    $models = array_values(array_unique($models));
    sort($models);

    // envia la resposta final
    echo json_encode([
        'make' => $make,
        'count' => count($models),
        'models' => $models
    ], JSON_UNESCAPED_UNICODE);

} catch (Throwable $e) {
    // captura errors interns del servidor
    echo json_encode([
        'error' => 'error intern❌',
        'details' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}   