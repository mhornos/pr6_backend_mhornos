
<?php
// Miguel Angel Hornos Granda

define('DB_VAR', [
    'DB_HOST' => 'localhost',
    'DB_NAME' => 'pt05_miguel_hornos',
    'DB_USER' => 'root',
    'DB_PASSWORD' => '',
]);

define('BASE_PATH', dirname(__DIR__) . '/');
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/');

//recaptcha
define("clauSecreta", "");

//oauth
define("oAuthClientID", "678152750720-upk97acgc98geu7nnrcuekug98v2ht92.apps.googleusercontent.com");
define("oAuthClientSecret","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");
?>