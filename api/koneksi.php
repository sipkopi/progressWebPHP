
<?php
$host = 'localhost';
$dbname = 'sipkopic_team2';
$username = 'sipkopic_team';
$password = 'sipkopiteam@2';
try {
 $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
 die("Database connection failed: " . $e->getMessage());
}
?>
