<?php
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Headers: Content-Type');  // Allow Content-Type header
header('Content-Type: application/json');  // Specify that the response is in JSON format
header('Access-Control-Allow-Credentials: true');              // ✅ IMPORTANT

session_start();


if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'User is not logged in'
    ]);
    
    exit;
}


$dsn = 'mysql:host=localhost;dbname=alex_blogging';  // Adjust to match your database details
$username = 'root';
$password = '';

try{
    $pdo = new PDO($dsn, $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e){
    echo json_encode([
        'success' => false,
        'message' => 'Connection failed: ' . $e->getMessage()
    ]);
    exit;
};


$data = json_decode(file_get_contents("php://input"), true);



if (empty($data['title']) || empty($data['text'])) {
    exit;
}


$title = $data['title'];
$text = $data['text'];
$user_id = $_SESSION['user']['id'];
$date = date('Y-m-d H:i:s');


$stmt = $pdo->prepare('INSERT INTO blogs (user_id, title, text, date) VALUES (:user_id, :title, :text, :date)');
$result = $stmt->execute([
  ':user_id' => $user_id,
  ':title' => $title,
  ':text' => $text,
  ':date' => $date,
]);


if (!$result) {
  // Log or display an error message if the query failed
  echo json_encode(['success' => false, 'message' => 'Database insert failed']);
  exit;
}