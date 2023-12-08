<?php
$host = '172.31.22.43';
$username = 'Agnel200555888';
$password = '0ls-0ahZnU';
$database = 'Agnel200555888';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>