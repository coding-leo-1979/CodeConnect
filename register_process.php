<!DOCTYPE html>
<html>
<head>
    <title>회원가입 결과</title>
    <link rel="stylesheet" href="/CodeConnect/css/register_process.css">
</head>
<body>
    <div class="container">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = htmlspecialchars($_POST['password']);
            $name = $_POST['name'];
            $birthdate = $_POST['birthdate'];
            $nickname = $_POST['nickname'];

            // 데이터베이스 연결 설정
            include 'connect.php';

            // 실제 회원 정보 저장
            $query = "INSERT INTO users (username, password, name, birthdate, nickname) VALUES ('$username', '$password', '$name', '$birthdate', '$nickname')";

            if ($conn->query($query) === TRUE) {
                echo "<p>회원가입이 완료되었습니다.</p>";
                echo '<button onclick="window.location.href=\'login.php\'">로그인 페이지로 돌아가기</button>';
            } else {
                echo "<p>오류: " . $conn->error . "</p>";
            }

            $conn->close();
        }
        ?>
    </div>
</body>
</html>