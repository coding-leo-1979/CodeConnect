<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include 'connect.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

        $category_id = $row['category_id'];        
        $title = $row['title'];        
        $content = $row['content'];
        
    } else {
        // 해당 글이 없을 경우 처리
        header('Location: mainboard.php');
        exit();
    }
}

// 카테고리 가져오기
$categories = array();
$sql = "SELECT id, name FROM categories";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = array('id' => $row['id'], 'name' => $row['name']);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>글 수정하기</title>
    <link rel="stylesheet" href="write.css">
</head>
<body>
    <form method="POST" action="edit_process.php">
        <select name="category">
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="title" placeholder="글의 제목" value="<?=$title?>" required>
        <textarea name="content" placeholder="글의 내용" required><?=$content?></textarea>
        <input type="hidden" name="post_id" value="<?=$post_id?>">
        <button type="submit">글 수정하기</button>
    </form>
</body>
</html>