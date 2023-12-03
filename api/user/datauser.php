<?php
require_once '../koneksi.php';
// Set the content type to JSON
header('Content-Type: application/json');
// Handle HTTP methods
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
 case 'GET':
 // Read operation (fetch books)
 $stmt = $pdo->query('SELECT * FROM data_user');
 $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
 echo json_encode($result);
 break;

 case 'POST':
    // Create operation (add a new user)
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if required fields are present
    if (!isset($data['user']) || !isset($data['pass'])) {
        http_response_code(400);
        echo json_encode(['message' => 'Username dan password harus diisi']);
        break;
    }

    $user = $data['user'];
    $nama = isset($data['nama']) ? $data['nama'] : null;
    $email = isset($data['email']) ? $data['email'] : null;
    $nohp = isset($data['nohp']) ? $data['nohp'] : null;
    $pass = $data['pass'];
    $lokasi = isset($data['lokasi']) ? $data['lokasi'] : null;
    $level = isset($data['level']) ? $data['level'] : null;
    
    // Set tanggal_create to current datetime
    $tanggal_create = date('Y-m-d H:i:s');

    $gambar = isset($data['gambar']) ? $data['gambar'] : null;

    $stmt = $pdo->prepare('INSERT INTO data_user (user, nama, email, nohp, pass, lokasi, level, tanggal_create, gambar) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$user, $nama, $email, $nohp, $pass, $lokasi, $level, $tanggal_create, $gambar]);

    echo json_encode(['message' => 'Data User Berhasil Ditambah']);
    break;

//  case 'PUT':
//  // Update operation (edit a book)
//  parse_str(file_get_contents('php://input'), $data);
//  $id = $data['id'];
//  $title = $data['title'];
//  $author = $data['author'];
//  $published_at = $data['published_at'];
 
//  $stmt = $pdo->prepare('UPDATE books SET title=?, author=?, published_at=? WHERE id=?');
//  $stmt->execute([$title, $author, $published_at, $id]);
 
//  echo json_encode(['message' => 'Book updated successfully']);
//  break;

//  case 'DELETE':
//  // Delete operation (remove a book)
//  $id = $_GET['id'];
 
//  $stmt = $pdo->prepare('DELETE FROM books WHERE id=?');
//  $stmt->execute([$id]);
 
//  echo json_encode(['message' => 'Book deleted successfully']);
//  break;
//  default:
//  // Invalid method
//  http_response_code(405);
//  echo json_encode(['error' => 'Method not allowed']);
//  break;
}
?>