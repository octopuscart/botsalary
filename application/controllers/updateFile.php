<?php
require('../config/configuration_db.php');
$servername = "localhost";
$activedb = "j2k5e6r5_salary";
$activedbusername = "j2k5e6r5_octopus";
$activedbpassword = "India$2017";


// Create connection
$conn = new mysqli($servername, $activedbusername, $activedbpassword, $activedb);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$title = $_POST["title"];
$content = $_POST["content"];
$id = $_POST["page_id"];
$sql = "UPDATE content_pages SET content='$content', title='$title' WHERE id=$id";

if ($conn->query($sql) === TRUE) {
  echo "Record updated successfully";
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();
?>