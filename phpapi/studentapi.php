<?php
header("Content-Type: application/json");

$host = 'localhost';
$db = 'schoolmanagement';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

$pdo = new PDO($dsn, $user, $pass, $options);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->query("SELECT StudentID, FirstName, LastName, Birthdate, GradeLevel FROM students");
    $students = $stmt->fetchAll();
    echo json_encode($students);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $sql = "INSERT INTO students (FirstName, LastName, Birthdate, GradeLevel) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$input['Firstname'], $input['Lastname'], $input['Birthdate'], $input['Gradelevel']]);
    echo json_encode(['message' => 'Student added successfully']);
}
?>
