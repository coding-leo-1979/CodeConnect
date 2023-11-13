<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include 'connect.php';

// 카테고리 가져오기
$categories = array();
$sql = "SELECT id, name FROM categories";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = array('id' => $row['id'], 'name' => $row['name']);
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>글 작성하기</title>
    <link rel="stylesheet" href="mainboard.css">
</head>
<body>
    <div class="add-post-form">
        <h2>글 작성하기</h2>
        <form action="addPost_process.php" method="post">
            <label for="category">카테고리:</label>
            <select name="category" id="category">
                <?php foreach ($categories as $category) : ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <br>
            <label for="title">제목:</label>
            <input type="text" name="title" id="title" required>
            <br>
            <label for="content">내용:</label>
            <textarea name="content" id="content" rows="5" required></textarea>
            <br>
            <button type="submit">글 작성하기</button>
        </form>
    </div>
</body>
</html>
