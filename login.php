<!DOCTYPE html>
<html>
<head>
    <title>로그인</title>
    <link rel="stylesheet" href="/CodeConnect/css/login.css">
</head>
<body class="login-body">
    <h1>FORZA BLOG</h1>
    <div class="login-container">
        <form method="POST" action="login_process.php">
            <div class="input-grid">
                <label for="username" class="ID-container">ID:</label>
                <input type="text" name="username" placeholder="아이디" class="ID-input-container" required>
                <label for="password" class="PW-container">PW:</label>
                <input type="password" name="password" placeholder="비밀번호" class="PW-input-container" required>
            </div>
            <div class="button-grid">
                <button type="submit" class="login-button">로그인</button>
                <button onclick="window.location.href='register.php'" class="register-button">회원가입</button>
            </div>
        </form>

        <!--로그인 에러가 났을 때만 출력되는 메시지-->
        <div class="error-container">
            <?php
                if (isset($_GET['error'])) {
                    echo "<p class='error-message'>잘못된 정보입니다.</p>";
                }
            ?>
        </div>
    </div>
</body>
</html>
