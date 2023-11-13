<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];

    // 공백 체크
    if (empty($username)) {
        $response = array('error' => true, 'message' => '아이디를 입력하세요.', 'color' => 'red');
        echo json_encode($response);
        exit; // 코드 실행 종료
    }
    
    // 데이터베이스 연결 설정
    include 'connect.php';
    
    // 아이디 중복 체크
    $query = "SELECT COUNT(*) AS count FROM users WHERE username = '$username'";
    $result = $conn->query($query);
    $data = $result->fetch_assoc();
    
    if ($data['count'] > 0) {
        $response = array('duplicate' => true, 'message' => '사용 중인 아이디입니다.', 'color' => 'red');
    } else {
        $response = array('duplicate' => false, 'message' => '사용 가능한 아이디입니다.', 'color' => 'green');
    }
    
    echo json_encode($response);
    
    $conn->close();
}
?>
