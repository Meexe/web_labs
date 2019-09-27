<html>
<head>
<title>Login page</title>
</head>
<body>
<div class="header">
      <h2>Login</h2>
</div>
<form method="post" action="login.php">
      <div class="input-group">
        <label>Username</label>
        <input type="text" name="username" value="">
      </div>
        <div class="input-group">
        <label>Password</label>
        <input type="password" name="password">
      </div>
      <div class="input-group">
        <button type="submit" class="btn" name="login">Login</button>
      </div>
</form>
</body>
</html>
<?php
function getRandomString($length = 16) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    return $string;
} // Просто функция, не берите в голову
function isUserLogined() {
    $db = new SQLite3('db.sqlite');
    $cookie_id = $_COOKIE["custom_session"];
    $is_logined = $db->querySingle("SELECT 1 FROM Sessions WHERE session='".$cookie_id."'");
    if($is_logined) {
        $res = true;
    }
    else {
        $res = false;
    }
    return $res;
}
function getUserID($username, $password) {
    $db = new SQLite3('db.sqlite');
    $user_valid = $db->querySingle("SELECT 1 FROM Users WHERE login='".$username."' AND pass='".$password."'");
    if($user_valid) {
        return true;
    }
    return false;
}
if (!empty($_POST)) { //Если нам пришел POST запрос (запрос на аутентификацию)
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_id = getUserID($username, $password);
    if($user_id) {
	$session_id = getRandomString();
	$db = new SQLite3('db.sqlite');
        $db->exec("INSERT INTO Sessions(user_id, session) VALUES ('".$user_id."','".$session_id."')");
	header('Set-Cookie: custom_session='.$session_id.';Path=/;', false);
	header('Set-Cookie: username='.$username.';Path=/;', false);
	header("Location: /upload.php");
    }
    else {
        echo "Invalid username or password";
    }
}
else {
    if(isUserLogined()) {
        echo "user_already_logined";
        header("Location: /upload.php");
    }
    else {
        echo "Login HERE!!!";
    }
}
?>
