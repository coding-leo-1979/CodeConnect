<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}
include 'connect.php';

if(isset($_GET['post_id'])){
    $post_id = $_GET['post_id'];

    $query = "SELECT author_id, likes FROM posts WHERE id = $post_id";

    $post_result = $conn->query($query);

    if ($post_result->num_rows == 1) {
        $row = $post_result->fetch_assoc();

        $author_id = $row['author_id'];
        $likes = $row['likes'];
        // 본인이 작성한 글일 경우
        if ($author_id == $_SESSION['id']) {
            echo "<script>alert('자신의 게시글입니다!');";
            echo "window.history.back()</script>";
            exit();
        }else{
            $likes += 1; //likes +1 하여 UPDATE
            $update_like_query = "UPDATE posts SET likes = '$likes' WHERE id = $post_id ";
            if ($conn->query($update_like_query) === TRUE) {
                echo "<script>alert('게시글에 좋아요를 눌렀습니다!');";
                echo "window.history.back()</script>"; //이전 페이지로 돌아가기
                exit();
            } else {
                echo "오류: " . $conn->error;
            }

            $conn->close();
        }

    }

}

?>
