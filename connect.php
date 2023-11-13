<?php
    $conn = new mysqli('localhost', 'root', '021103', 'FORZA_blog');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>