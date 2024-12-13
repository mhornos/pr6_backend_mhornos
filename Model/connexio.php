<?php
//Miguel Angel Hornos Granda

require_once __DIR__ . '/../env.php';

$host = DB_VAR['DB_HOST'];
$dbname = DB_VAR['DB_NAME'];
$username = DB_VAR['DB_USER'];
$password = DB_VAR['DB_PASSWORD'];

try{
    $connexio = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $connexio->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch (PDOException $e) {
    echo "error de connexió: " . $e->getMessage() . " ❌";    
}  


?>