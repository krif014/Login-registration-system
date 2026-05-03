<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$host = 'localhost';
$db = '';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed"]));
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    /* ---------------- GET USERS ---------------- */
    case 'GET':

        if (isset($_GET['id'])) {
            $stmt = $conn->prepare("SELECT id, username, email FROM users WHERE id = ?");
            $stmt->bind_param("i", $_GET['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            echo json_encode($result->fetch_assoc());
        } else {
            $result = $conn->query("SELECT id, username, email FROM users ORDER BY id DESC");

            $users = [];
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }

            echo json_encode($users);
        }
        break;

    /* ---------------- CREATE USER ---------------- */
    case 'POST':

        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['username'], $data['email'], $data['password'])) {
            echo json_encode(["error" => "Missing fields"]);
            exit;
        }

        $username = $conn->real_escape_string($data['username']);
        $email = $conn->real_escape_string($data['email']);
        $password = password_hash($data['password'], PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        $stmt->execute();

        echo json_encode(["message" => "User created"]);
        break;

    /* ---------------- UPDATE USER ---------------- */
    case 'PUT':

        $data = json_decode(file_get_contents("php://input"), true);

        $id = $data['id'];
        $username = $data['username'];
        $email = $data['email'];

        $stmt = $conn->prepare("UPDATE users SET username=?, email=? WHERE id=?");
        $stmt->bind_param("ssi", $username, $email, $id);
        $stmt->execute();

        echo json_encode(["message" => "User updated"]);
        break;

    /* ---------------- DELETE USER ---------------- */
    case 'DELETE':

        $id = $_GET['id'];

        $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        echo json_encode(["message" => "User deleted"]);
        break;

    default:
        echo json_encode(["error" => "Invalid method"]);
        break;
}

$conn->close();
