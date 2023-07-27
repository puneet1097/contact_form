<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'contact_form';

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    // echo "not";
    die("Connection failed: " . mysqli_connect_error());
} else {
    // echo "done";
}
