<?php 

session_start();

$db_server = getenv('DB_SERVER') ?: 'localhost';
$db_port   = getenv('DB_PORT') ?: '3306';
$db_user   = getenv('DB_USER') ?: 'root';
$db_pass   = getenv('DB_PASS') ?: '';
$db        = getenv('DB_NAME') ?: 'portfolio_db';
$db_ssl_ca = getenv('DB_SSL_CA') ?: null;

try {
    $dsn = "mysql:host=$db_server;port=$db_port;dbname=$db";

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ];

    if ($db_ssl_ca) {
        $options[PDO::MYSQL_ATTR_SSL_CA] = $db_ssl_ca;
        $options[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = true;
    }

    $pdo = new PDO($dsn, $db_user, $db_pass, $options);

} catch (PDOException $e) {
    die('connection failed: ' . $e->getMessage());
}

?>