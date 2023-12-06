<?php
require_once '../koneksi.php';
// Set the content type to JSON
header('Content-Type: application/json');
// Handle HTTP methods
$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
 case 'GET':
 // Read operation (fetch books)
 $stmt = $pdo->query('SELECT * FROM data_peremajaan');
 $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
 echo json_encode($result);
 break;

//  case 'POST':
//  // Create operation (add a new book)
//  $data = json_decode(file_get_contents('php://input'), true);
//  $kode_peremajaan = $data['kode_peremajaan'];
//  $kode_lahan = $data['kode_lahan'];
//  $perlakuan = $data['perlakuan'];
//  $tanggal = $data['tanggal'];
//  $kebutuhan = $data['kebutuhan'];
//  $pupuk = $data['pupuk'];

// //  INSERT INTO `data_peremajaan` (`kode_peremajaan`, `kode_lahan`, `perlakuan`, `tanggal`, `kebutuhan`, `pupuk`) VALUES ('$kode_peremajaan', '$kode_lahan', '$perlakuan', '$tanggal', '$kebutuhan', '$pupuk');

//  $stmt = $pdo->prepare('INSERT INTO `data_peremajaan` (kode_peremajaan, kode_lahan, perlakuan, tanggal, kebutuhan, pupuk) VALUES (?, ?, ?, ?, ?, ?)');
//  $stmt->execute([$kode_peremajaan, $kode_lahan, $perlakuan, $tanggal, $kebutuhan, $pupuk]);
 
//  echo json_encode(['message' => 'Book added successfully']);
//  break;

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


