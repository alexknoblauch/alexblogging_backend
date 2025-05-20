<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

$dsn = 'mysql:host=localhost;dbname=alex_blogging';  // Adjust to match your database details
$username = 'root';
$password = '';

try{
    $pdo = new PDO($dsn, $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo json_encode(['status' => 'success', 'message' => 'Server is connected']);

} catch(PDOException $e){
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $e->getMessage()]);

};