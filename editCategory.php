<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

include 'connect.php';

// 카테고리 정보 가져오기
$query = "SELECT * FROM categories WHERE id <> 1"; // id가 1번인 카테고리를 제외하고 가져옴
$result = $conn->query($query);
$categories = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

// 카테고리 정보 수정 또는 삭제
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($categories as $category) {
        $categoryId = $category['id'];
        $newName = $_POST["category_name_$categoryId"];
        $delete = isset($_POST["delete_$categoryId"]);

        if ($delete) {
            $deleteQuery = "DELETE FROM categories WHERE id = $categoryId";
            $conn->query($deleteQuery);
        } else {
            $updateQuery = "UPDATE categories SET name = '$newName' WHERE id = $categoryId";
            $conn->query($updateQuery);
        }
    }

    header('Location: mainboard.php');
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>카테고리 수정하기</title>
    <link rel="stylesheet" href="/CodeConnect/css/editCategory.css">
</head>
<body>
    <div class="container">
        <h1>카테고리 수정하기</h1>
        <form method="POST">
            <?php foreach ($categories as $category) : ?>
                <div>
                    <input type="text" name="category_name_<?php echo $category['id']; ?>" value="<?php echo $category['name']; ?>">
                    <input type="checkbox" name="delete_<?php echo $category['id']; ?>"> 삭제하기
                </div>
            <?php endforeach; ?>
            <button type="submit">저장하기</button>
    </form>
    </div>
</body>
</html>
