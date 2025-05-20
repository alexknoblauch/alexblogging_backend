<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Access-Control-Allow-Origin: *');  // Allows all domains, adjust for production
header('Access-Control-Allow-Headers: Content-Type');  // Allow Content-Type header
header('Content-Type: application/json');  // Specify that the response is in JSON format

session_start();

unset($_SESSION['user']);

echo json_encode(['message' => 'Logged out successfully']);

session_destroy();  // Destroy the session data completely