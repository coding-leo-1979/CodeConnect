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
?>

<!DOCTYPE html>
<html>
<head>
    <title>글 작성하기</title>
    <link rel="stylesheet" href="/CodeConnect/css/write.css">
</head>
<body>
    <form method="POST" action="write_process.php">
        <select name="category">
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="text" name="title" placeholder="글의 제목" required>
        <textarea name="content" placeholder="글의 내용" required></textarea>
        <button type="submit">글 작성하기</button>
    </form>
</body>
</html>