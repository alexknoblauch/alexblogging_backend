<?php
header('Access-Control-Allow-Origin: http://localhost:3000'); 
header('Access-Control-Allow-Headers: Content-Type');  
header('Access-Control-Allow-Credentials: true');           
session_start();


$dsn = 'mysql:host=localhost;dbname=alex_blogging';  
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

if (empty(trim($data['email'])) || empty(($data['password']))) {
     exit; 
}

$email = $data['email'];
$password = $data['password'];

$stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
$stmt->execute(['email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);


if ($user) {
    try {
    
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email'],
            ];
            echo json_encode(['success' => true, 'message' => 'User logged in'   ,      'session' => $_SESSION // This will include the entire session data in the response
        ]);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
            exit; 
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        exit; 
    }
} else {
    echo json_encode(['success' => false, 'message' => 'User not found']);
    exit; 
};

