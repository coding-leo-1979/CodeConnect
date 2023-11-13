<!DOCTYPE html>
<html>
<head>
    <title>글 수정하기 결과</title>
    <link rel="stylesheet" href="/CodeConnect/css/edit_process.css">
</head>
<body>
    <div class="container">
    <?php
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['username'])) {
                header('Location: login.php');
                exit();
            }

            $category_id = $_POST['category'];
            $title = $_POST['title'];
            $content = $_POST['content'];
            $post_id = $_POST['post_id'];

            // 데이터베이스 연결 설정
            include 'connect.php';

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // 글 업데이트 쿼리
            $update_query = "UPDATE posts SET category_id = '$category_id', title = '$title', content = '$content' WHERE id = $post_id";

            if ($conn->query($update_query) === TRUE) {
                echo "<p>글 수정이 완료되었습니다.</p>";
                echo '<button onclick="window.location.href=\'mainboard.php\'">메인보드로 돌아가기</button>';
            } else {
                echo "오류: " . $conn->error;
            }

            $conn->close();
        }
    ?>
    </div>
</body>
</html>