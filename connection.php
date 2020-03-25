<?php

$servername = "localhost";
$username = "mysql";
$password = "";
$db = "test";
// Create connection
$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


/*$sql = "CREATE DATABASE IF NOT EXISTS myDB";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}
*/
$sql = "CREATE TABLE IF NOT EXISTS films (_id INT(32) AUTO_INCREMENT PRIMARY KEY,
filmname VARCHAR(256),
imdb_id VARCHAR(256),
poster VARCHAR(256),
trailer VARCHAR(200)
)";
if ($conn->query($sql) !== TRUE) {
    echo "Error creating database: " . $conn->error;
}

?>