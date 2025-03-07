<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$database = "economiaf";


$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
}
?>