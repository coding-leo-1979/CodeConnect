<!DOCTYPE html>
<html>
<head>
    <title>글 삭제하기 결과</title>
    <link rel="stylesheet" href="/CodeConnect/css/delete.css">
</head>
<body>
    <div class="container">
    <?php
        session_start();
        if (!isset($_SESSION['username'])) {
            header('Location: login.php');
            exit();
        }
        include 'connect.php';

        if (isset($_GET['post_id'])) {
            $post_id = $_GET['post_id'];

            $query = "SELECT category_id, author_id, title, content FROM posts WHERE id = $post_id";
            $result = $conn->query($query);

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();

                $author_id = $row['author_id'];

                // 본인 글이 아닐 경우
                if ($author_id !== $_SESSION['id']) {
                    header('Location: mainboard.php');
                    exit();
                }
            }

            $delete_query = "DELETE FROM posts WHERE id = $post_id";

            if ($conn->query($delete_query) === TRUE) {
                echo "<p>글 삭제가 완료되었습니다.</p>";
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