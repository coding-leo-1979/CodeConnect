<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nickname = $_POST['nickname'];

    // 공백 체크
    if (empty($nickname)) {
        $response = array('error' => true, 'message' => '닉네임을 입력하세요.', 'color' => 'red');
        echo json_encode($response);
        exit; // 코드 실행 종료
    }

    // 데이터베이스 연결 설정
    include 'connect.php';

    // 닉네임 중복 체크
    $query = "SELECT COUNT(*) AS count FROM users WHERE nickname = '$nickname'";
    $result = $conn->query($query);
    $data = $result->fetch_assoc();

    if ($data['count'] > 0) {
        $response = array('duplicate' => true, 'message' => '사용 중인 닉네임입니다.', 'color' => 'red');
    } else {
        $response = array('duplicate' => false, 'message' => '사용 가능한 닉네임입니다.', 'color' => 'green');
    }

    echo json_encode($response);

    $conn->close();
}
?>