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

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    // 조회수 증가 처리
    $updateViewsQuery = "UPDATE posts SET views = views + 1 WHERE id = $post_id";
    $conn->query($updateViewsQuery);
    
    // 선택한 글의 내용 가져오기
    $query = "SELECT * FROM posts WHERE id = $post_id";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $id = $row['id'];
        $category_id = $row['category_id'];
        $author_id = $row['author_id'];
        $title = $row['title'];
        $content = $row['content'];   
        $created_at = $row['created_at'];
        $views = $row['views'];
        $likes = $row['likes'];
        $dislikes = $row['dislikes'];
    } else {
        // 해당 글이 없을 경우 처리
        header('Location: mainboard.php');
        exit();
    }    
} else {
    // post_id가 전달되지 않았을 경우 처리
    header('Location: mainboard.php');
    exit();
}

// 카테고리 이름 가져오기
$sql1 = "SELECT name FROM categories WHERE id = $category_id";
$result = $conn->query($sql1);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $post_category = $row['name'];
    }
}

// 닉네임 가져오기
$sql2 = "SELECT nickname FROM users WHERE id = $author_id";
$result = $conn->query($sql2);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $nickname = $row['nickname'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="/CodeConnect/css/mainboard.css">
    <link rel="stylesheet" href="/CodeConnect/css/post.css">
</head>
<body>
    <div class="banner">
        <h1><a href="mainboard.php">FORZA BLOG</a></h1>
    </div>

    <div class="category">
        <h2>CATEGORY</h2>
        <ul>
            <?php foreach ($categories as $category) : ?>
                <li><a href="?category=<?php echo $category['id']; ?>"><?php echo $category['name']; ?></a></li>
            <?php endforeach; ?>
        </ul>
        
        <button onclick="window.location.href='addCategory.php'">카테고리 추가하기</button>
        <button onclick="window.location.href='editCategory.php'">카테고리 편집하기</button>
    </div>

    <div class="article">
        <table>
            <!--카테고리-->
            <tr>
                <td><a style="color: #7286D3" href="mainboard.php?category=<?php echo $category_id;?>"><?php echo $post_category;?></a></td>
                <td style="text-align: right; padding-right: 0px">
                    <button style="width: 120px;"><a href="edit.php?post_id=<?php echo $id ?>" style="color: white;">수정</a></button>
                </td>
                <td style="text-align: right; padding-right: 0px">
                    
                    <button style="width: 120px;"><a href="delete.php?post_id=<?php echo $id ?>" style="color: white;">삭제</a></button>
                </td>
            </tr>

            <!--제목-->
            <tr><td colspan="3">[제목] <?php echo $title;?></td></tr>

            <!--작성자, 날짜, 조회수-->
            <tr>
                <td style="width: 600px;">[작성자] <?php echo $nickname;?></td>
                <td style="text-align: right;"><?php echo $created_at;?></td>
                <td style="text-align: right; width: 120px;">[조회수] <?php echo $views;?></td>
            </tr>

            <!--내용-->
            <tr style="height: 300px;"><td colspan="3"><?php echo $content;?></td></tr>
        </table>
        <br>
        <!--좋아요, 싫어요-->
        <div class="react-container">        
            <button class="likes"><?php echo $likes;?> 좋아요</button>
            <button class="dislikes"><?php echo $dislikes;?> 싫어요</button>
        </div>
    </div>

    <div class="user">
        <h2>ME</h2>
        <p class="showNickname"><?php echo $_SESSION['nickname'];?></p>
        <button onclick="window.location.href='logout.php'" id="logout">로그아웃</button>
        <br>
        <button onclick="window.location.href='mypost.php'">작성글</button>
        <br>
        <button onclick="window.location.href='mycomment.php'">작성댓글</button>
        <br>
        <button onclick="window.location.href='write.php'" id="write">글쓰기</button>
    </div>
</body>
</html>
