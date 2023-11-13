<!DOCTYPE html>
<html>
<head>
    <title>글 작성하기 결과</title>
    <link rel="stylesheet" href="/CodeConnect/css/write_process.css">
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

            // 데이터베이스 연결 설정
            include 'connect.php';

            // 현재 사용자의 username을 기반으로 author_id 가져오기
            $username = $_SESSION['username'];
            $query = "SELECT id FROM users WHERE username = '$username'";
            $result = $conn->query($query);
            $user = $result->fetch_assoc();
            $author_id = $user['id'];

            // 글 삽입 쿼리
            $insert_query = "INSERT INTO posts (category_id, author_id, title, content) VALUES ('$category_id', '$author_id', '$title', '$content')";

            if ($conn->query($insert_query) === TRUE) {
                echo "<p>글 작성이 완료되었습니다.</p>";
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
