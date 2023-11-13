<!DOCTYPE html>
<html>
<head>
    <title>회원가입</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="/CodeConnect/css/register.css">
</head>
<body>
    <form method="POST" action="register_process.php" onsubmit="return validateForm();">
        <div class="input-container">
            <input type="text" name="username" placeholder="아이디" required>
            <button type="button" onclick="checkUsername()">아이디 중복체크</button>
            <span id="usernameMessage" class="msg"></span>
        </div>
        
        <div class="input-container">
            <input type="password" name="password" placeholder="비밀번호" required>
        </div>
        
        <div class="input-container">
            <input type="password" name="confirm_password" placeholder="비밀번호 확인" required onkeyup="checkPasswordMatch()">
            <span id="passwordMatchIcon"></span>
        </div>
        
        <div class="input-container">
            <input type="text" name="name" placeholder="이름" required>
        </div>
        
        <div class="input-container">
            <input type="date" name="birthdate" required>
            <span class="msg" style="color: #7286D3; width: 150px">생년월일</span>
        </div>
        
        <div class="input-container">
            <input type="text" name="nickname" placeholder="닉네임" required>
            <button type="button" onclick="checkNickname()">닉네임 중복체크</button>
            <span id="nicknameMessage" class="msg"></span>
        </div>
        
        <div class="button-container">
            <button type="submit" id="submitBtn" disabled>회원가입</button>
            <button type="reset" id="resetBtn">리셋하기</button>
        </div>
    </form>

    <script>
        function validateForm() {
            var username = $('input[name="username"]').val();
            var nickname = $('input[name="nickname"]').val();
            var password = $('input[name="password"]').val();
            var confirmPassword = $('input[name="confirm_password"]').val();

            var isFormValid = true;

            if (username === '' || nickname === '' || password === '' || confirmPassword === '') {
                isFormValid = false;
            }

            if (password !== confirmPassword) {
                isFormValid = false;
            }

            return isFormValid;
        }

        function checkUsername() {
            var username = $('input[name="username"]').val();
            $.post('check_username.php', { username: username }, function(data) {
                $('#usernameMessage').text(data.message);
                $('#usernameMessage').css('color', data.color);
                $('#submitBtn').prop('disabled', data.duplicate || !validateForm());
            }, 'json');
        }

        function checkNickname() {
            var nickname = $('input[name="nickname"]').val();
            $.post('check_nickname.php', { nickname: nickname }, function(data) {
                $('#nicknameMessage').text(data.message);
                $('#nicknameMessage').css('color', data.color);
                $('#submitBtn').prop('disabled', data.duplicate || !validateForm());
            }, 'json');
        }

        function checkPasswordMatch() {
            var password = $('input[name="password"]').val();
            var confirmPassword = $('input[name="confirm_password"]').val();

            var icon = $('#passwordMatchIcon');

            if (password === confirmPassword) {
                icon.removeClass('red').addClass('green');
            } else {
                icon.removeClass('green').addClass('red');
            }

            $('#submitBtn').prop('disabled', !validateForm());
        }
    </script>
</body>
</html>
