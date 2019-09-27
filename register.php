<html>
<head>
<title>Registration</title>
</head>
<body>
<div class="header">
    <h2>Register</h2>
</div>
<form method="post" action="register.php">
    <div class="input-group">
        <label>Username</label>
        <input type="text" name="username" value="">
    </div>
    <div class="input-group">
        <label>Password</label>
        <input type="password" name="password">
    </div>
    <div class="input-group">
        <button type="submit" class="btn" name="reg_user">Register</button>
    </div>
    <p>
        Already registered? <a href="login.php">Sign in</a>
    </p>
</form>
</body>
</html>
<?php
if (!empty($_POST)) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    if(empty($username) or empty($password)) {
        echo "Please fill the fields";
    }
    else {
        $db = new SQLite3('db.sqlite');
        $user_exist = $db->querySingle("SELECT login from Users WHERE
login='".$username."'");
        if($user_exist) {
            echo "User already exists";
        }
        else {
            $db->exec("INSERT INTO Users(login,pass) VALUES
('".$username."','".$password."')");
        header("Location: /login.php");
        }
    }
}
?>
