<!--process_create_signup.php-->
<?php
$conn = mysqli_connect('localhost', 'root', '', '');

$filtered = array(
  'UID'=>mysqli_real_escape_string($conn, $_POST['UID']),
  'PW'=>mysqli_real_escape_string($conn, $_POST['PW']),
  'NICKNAME'=>mysqli_real_escape_string($conn, $_POST['NICKNAME']),
  'NAME'=>mysqli_real_escape_string($conn, $_POST['NAME']),
  'BIRTHYEAR'=>mysqli_real_escape_string($conn, $_POST['BIRTHYEAR'])
);

if(!$filtered['UID'] || !$filtered['PW'] || !$filtered['NICKNAME'] || !$filtered['NAME'] || !$filtered['BIRTHYEAR']){ //빈칸이 있을 때
echo "<script>alert('FILL IN ALL THE BLANKS!')</script>";
echo "<script>location.href='create_signup.php'</script>";
}
else{
$sql_UID = "SELECT * FROM users WHERE UID='{$filtered['UID']}'";  //UID 중복 체크
$result_UID = mysqli_query($conn, $sql_UID);
$row_UID = mysqli_fetch_array($result_UID);

$sql_NICKNAME = "SELECT * FROM users WHERE NICKNAME='{$filtered['NICKNAME']}'"; //NICKNAME 중복 체크
$result_NICKNAME = mysqli_query($conn, $sql_NICKNAME);
$row_NICKNAME = mysqli_fetch_array($result_NICKNAME);

if(isset($row_UID['UID'])){  //UID가 중복일 때
    echo "<script>alert('ID ALREADY EXISTS!')</script>";
    echo "<script>location.href='create_signup.php'</script>";
}
else if(isset($row_NICKNAME['NICKNAME'])){  //NICKNAME이 중복일 때
    echo "<script>alert('NICKNAME ALREADY EXISTS!')</script>";
    echo "<script>location.href='create_signup.php'</script>";
}
else{ //UID와 NICKNAME이 모두 중복이 아닐 때, 계정 생성
    $sql = "
    INSERT INTO users(UID, PW, NICKNAME, NAME, BIRTHYEAR)
    VALUES('{$filtered['UID']}', '{$filtered['PW']}', '{$filtered['NICKNAME']}', '{$filtered['NAME']}', '{$filtered['BIRTHYEAR']}')
    ";
    $result = mysqli_query($conn, $sql);
    echo 'ACCOUNT CREATED!<br><a href="index.php">GO TO LOGIN</a>';
}
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>SIGN UP</title>
  </head>
  <body>
  </body>
</html>