<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // 데이터베이스 연결 설정
    include 'connect.php';
    
    // 입력받은 아이디로 사용자 정보 조회
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $conn->query($query);
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // 입력받은 비밀번호와 데이터베이스의 비밀번호 비교
        if ($password === $user['password']) {
            // 로그인 성공
            session_start();
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['password'] = $user['password'];
            $_SESSION['nickname'] = $user['nickname'];
            header('Location: mainboard.php');
            exit();
        }
    }
    
    // 로그인 실패
    header('Location: login.php?error=true');
    exit();
}
?>
