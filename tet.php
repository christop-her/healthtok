<?php
// Connect to PostgreSQL
$host = 'oregon-postgres.render.com';  // Or use the hard-coded value if not using environment variables
$dbname = 'test_yvhj';
$user = 'root';
$pass = 'pB8U8bTRKMDUaBs600vj774gcSHvTFoE';
$port = '5432';

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
try {
    // Create a PDO connection
    $pdo = new PDO($dsn, $user, $pass);

    // Query to get all tables in the database
    $query = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public'");

    // Fetch the table names
    $tables = $query->fetchAll(PDO::FETCH_COLUMN);

    // Display the tables
    if ($tables) {
        echo "Tables in the database:\n";
        foreach ($tables as $table) {
            echo $table . "\n";
        }
    } else {
        echo "No tables found in the database.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
