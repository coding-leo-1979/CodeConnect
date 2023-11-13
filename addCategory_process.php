<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryName = $_POST['categoryName'];

    if (!empty($categoryName)) {
        // 데이터베이스 연결 설정
        include 'connect.php';

        // 카테고리 추가
        $query = "INSERT INTO categories (name) VALUES ('$categoryName')";

        if ($conn->query($query) === TRUE) {
            header('Location: mainboard.php');
            exit();
        } else {
            echo "오류: " . $conn->error;
        }

        $conn->close();
    }
}
?>
