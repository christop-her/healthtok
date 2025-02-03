<?php
$db_host = 'oregon-postgres.render.com';  // e.g., 'db.example.com' or 'localhost'
$db_port = '5432';  // Default PostgreSQL port
$db_name = 'expire_db_qrqg';  // Your database name
$user_name = 'root';  // Your PostgreSQL username
$user_password = 'JEe1piCBZMcqtNMs9xCgi51uYArDHSRt';  // Your PostgreSQL password

try {
    // Connection string for PostgreSQL
    $conn = new PDO("pgsql:host=$db_host;port=$db_port;dbname=$db_name", $user_name, $user_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>
