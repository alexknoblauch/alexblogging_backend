<?php
header('Access-Control-Allow-Origin: http://localhost:3000');  
header('Access-Control-Allow-Headers: Content-Type'); 
header('Content-Type: application/json');  
header('Access-Control-Allow-Credentials: true');           


$dsn = 'mysql:host=localhost;dbname=alex_blogging'; 
$user = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;   

}
try {
    $stmt = $pdo->query("SELECT blogs.id, blogs.title, blogs.text, blogs.date, users.email AS author_name
    FROM blogs
    JOIN users ON blogs.user_id = users.id");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($data);

} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}