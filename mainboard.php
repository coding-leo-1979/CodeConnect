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

// 초기 카테고리 ID 설정
$category_id = 1; // 초기에는 1로 설정

// 카테고리 변경 요청이 있을 경우
if (isset($_GET['category'])) {
    $category_id = $_GET['category']; // 선택한 카테고리 ID로 변경
    
}

// 게시물 조회 쿼리 조건 설정
$whereCondition = ($category_id == 1) ? "" : "WHERE category_id = $category_id";

$itemsPerPage = 10;
$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($currentPage - 1) * $itemsPerPage;

$query = "SELECT id, title, content, created_at, views, likes, dislikes
        FROM posts
        $whereCondition
        ORDER BY created_at DESC
        LIMIT $offset, $itemsPerPage";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>FORZA Main Board</title>
    <link rel="stylesheet" href="/CodeConnect/css/mainboard.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.table_title').click(function() {
                var postId = $(this).data('post-id');
                window.location.href = 'post.php?post_id=' + postId;
            });
        });
    </script>
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

    <div class="main">
        <h2>POST</h2>
        <table>
            <tr>
                <th>No.</th>
                <th>Title</th>
                <th>Date</th>
                <th>View</th>
                <th>Like</th>
                <th>Dislike</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td class="table_no"><?php echo $row['id']; ?></td>
                    <td class="table_title" data-post-id="<?php echo $row['id']; ?>">
                        <span class="title_cursor"><?php echo $row['title'];?></span>
                    </td>
                    <td class="table_date">
                        <?php
                        date_default_timezone_set('Asia/Seoul');
                        $createdAt = new DateTime($row['created_at']);
                        $currentDate = new DateTime();
                        if ($createdAt->format('Y-m-d') === $currentDate->format('Y-m-d')) {
                            echo $createdAt->format('H:i:s');
                        } else {
                            echo $createdAt->format('Y-m-d');
                        }
                        ?>
                    </td>
                    <td class="table_etc"><?php echo $row['views']; ?></td>
                    <td class="table_etc"><?php echo $row['likes']; ?></td>
                    <td class="table_etc"><?php echo $row['dislikes']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>

        <div class="pagination">
            <?php if ($currentPage > 1) : ?>
                <a href="?page=<?php echo ($currentPage - 1); ?>">Prev Page</a>
            <?php endif; ?>

            <?php if ($result->num_rows >= $itemsPerPage) : ?>
                <a href="?page=<?php echo ($currentPage + 1); ?>">Next Page</a>
            <?php endif; ?>
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