<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = $_POST['category'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $views = 0;
    $likes = 0;
    $dislikes = 0;

    // 글 정보 저장
    $query = "INSERT INTO posts (category_id, title, content, views, likes, dislikes) VALUES ('$category', '$title', '$content', '$views', '$likes', '$dislikes')";
    
    if ($conn->query($query) === TRUE) {
        header('Location: mainboard.php');
        exit();
    } else {
        echo "오류: " . $conn->error;
    }
}

$conn->close();
?>
