<?php
require_once '../koneksi.php';
// Set the content type to JSON
header('Content-Type: application/json');
// Handle HTTP methods
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
 case 'GET':
 // Read operation (fetch books)
 $stmt = $pdo->query('SELECT * FROM data_lahan');
 $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
 echo json_encode($result);
 break;


case 'POST':
    // Create operation (add a new user)
    $data = json_decode(file_get_contents('php://input'), true);

    // Kode untuk menghasilkan kode lahan otomatis
    $queryy = "SELECT kode_lahan FROM data_lahan ORDER BY kode_lahan DESC LIMIT 1";
    $resultt = mysqli_query($koneksi, $queryy);

    if ($resultt) {
        $row = mysqli_fetch_assoc($resultt);
        if ($row) {
            $lastCode = $row['kode_lahan'];
            $lastNumber = (int)substr($lastCode, 2);
            $newNumber = $lastNumber + 1;

            if ($newNumber < 10) {
                $newCode = "KL000" . $newNumber;
            } elseif ($newNumber < 100) {
                $newCode = "KL00" . $newNumber;
            } else {
                $newCode = "KL0" . $newNumber;
            }
        } else {
            $newCode = "KL0001";
        }
    } else {
        $newCode = "KL0001";
    }

    // Assign generated kode_lahan to the data
    $data['kode_lahan'] = $newCode;

    // Insert data into the database
    $stmt = $pdo->prepare('INSERT INTO data_lahan (kode_lahan, user, varietas_pohon, total_bibit, luas_lahan, tanggal, ketinggian_tanam, lokasi_lahan, longtitude, latitude) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$data['kode_lahan'], $data['user'], $data['varietas_pohon'], $data['total_bibit'], $data['luas_lahan'], $data['tanggal'], $data['ketinggian_tanam'], $data['lokasi_lahan'], $data['longtitude'], $data['latitude']]);

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