<!DOCTYPE html>
<html>
<head>
    <title>카테고리 추가하기</title>
    <link rel="stylesheet" href="/CodeConnect/css/addCategory.css">
</head>
<body>
    <div class="container">
        <h1>카테고리 추가하기</h1>
        <form method="post" action="addCategory_process.php">
            <input type="text" name="categoryName" placeholder="카테고리 이름" required>
            <button type="submit">카테고리 만들기</button>
        </form>
        <a href="mainboard.php">뒤로 가기</a>
    </div>
</body>
</html>