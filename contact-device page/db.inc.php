<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection

if(!$conn) {
    die('Could not connect: ' . mysql_error());
}
    // echo 'Connected successfully <br/>';

?>
