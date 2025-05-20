<?php

include_once './dbHandler.inc.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['email']) && isset($data['password'])) {
    $email = $data['email'];
    $password = $data['password'];

    $hashedpw = password_hash($password, PASSWORD_DEFAULT);

    try {
    $stmt = $pdo->prepare('INSERT INTO users (email, password) VALUES (:email, :password)');
    $stmt->execute([
        ':email' => $email,
        ':password' => $hashedpw
    ]);

    $stmt->fetch(PDO::FETCH_ASSOC);
} catch(PDOException $e){
        echo 'error' . $e->getMessage();
    }
}