<?php
header('Access-Control-Allow-Origin: *');  // Allows all domains, adjust for production
header('Access-Control-Allow-Headers: Content-Type');  // Allow Content-Type header
header('Content-Type: application/json');  // Specify that the response is in JSON format

$dsn = 'mysql:host=localhost;dbname=alex_blogging'; 
$user = 'root';
$password = '';



try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit; 
}
try {
    $stmt = $pdo->prepare("SELECT * FROM blogs WHERE id = :id");
    $stmt->execute([':id' => $id]);  // Assuming $id contains the value
    $blogPost = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($blogPost);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}