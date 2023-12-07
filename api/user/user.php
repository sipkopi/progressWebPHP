<?php

$host = "localhost";
$username = "sipkopic_team";
$password = "sipkopiteam@2";
$database = "sipkopic_team2";

// Function to handle database connection
function connectToDatabase($host, $username, $password, $database)
{
    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        return null;
    }

    return $conn;
}

// Function to handle JSON response
function jsonResponse($code, $status)
{
    $response = array(
        'code' => $code,
        'status' => $status
    );

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}

// Connect to the database
$conn = connectToDatabase($host, $username, $password, $database);

if (!$conn) {
    jsonResponse(500, 'Connection to database failed');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Read JSON from the client
    $json = file_get_contents('php://input');
    $obj = json_decode($json);

    // Get data from JSON object
    $user = $obj->user;
    $nama = $obj->nama;
    $email = $obj->email;
    $nohp = $obj->nohp;
    $pass = $obj->pass;
    $lokasi = $obj->lokasi;
    $level = $obj->level;
    $tanggal_create = date('Y-m-d H:i:s');
    $gambar = $obj->gambar;

    // Generate a unique ID for the image
    $gambarNamaUnik = uniqid() . '.png';
    $imagePath = 'https://sipkopi.com/assets/datagambar/' . $gambarNamaUnik;

    // Check if the user already exists using prepared statement
    $query_check = "SELECT * FROM data_user WHERE user = ?";
    $stmt_check = mysqli_prepare($conn, $query_check);
    mysqli_stmt_bind_param($stmt_check, "s", $user);
    mysqli_stmt_execute($stmt_check);
    $check = mysqli_stmt_fetch($stmt_check);
    mysqli_stmt_close($stmt_check);

    if ($check) {
        jsonResponse(406, 'User has been registered');
    } else {
        // Insert new user using prepared statement
        $query_insert = "INSERT INTO `data_user` (`user`, `nama`, `email`, `nohp`, `pass`, `lokasi`, `level`, `tanggal_create`, `gambar`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $query_insert);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sssssssss", $user, $nama, $email, $nohp, $pass, $lokasi, $level, $tanggal_create, $imagePath);

            if (mysqli_stmt_execute($stmt)) {
                // Save image to server as PNG
                $decoded_image = base64_decode($gambar);
                $save_path = "../../assets/datagambar/" . $gambarNamaUnik;

                // Ensure the directory exists before saving the file
                if (!is_dir("../../assets/datagambar/")) {
                    mkdir("../../assets/datagambar/");
                }

                if (file_put_contents($save_path, $decoded_image)) {
                    jsonResponse(200, 'User Registered');
                } else {
                    jsonResponse(500, 'Error saving image');
                }
            } else {
                jsonResponse(405, 'Registered Error');
            }

            mysqli_stmt_close($stmt);
        } else {
            jsonResponse(500, 'Error preparing statement');
        }
    }
}

mysqli_close($conn);
?>
