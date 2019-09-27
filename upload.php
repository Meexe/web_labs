<!DOCTYPE html>
<html>
<head>
  <title>Upload your files</title>
</head>
<body>
  <form enctype="multipart/form-data" action="upload.php" method="POST">
    <p>Upload your file</p>
    <input type="file" name="uploaded_file"></input><br />
    <input type="submit" value="Upload"></input>
  </form>
</body>
</html>
<?PHP
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
if (!isUserLogined()) {
    header('Location: /login.php');
}
if(!empty($_FILES['uploaded_file'])) {
    $username = $_COOKIE["username"];
    $path = "uploads/".$username."/";
    // echo $path;
    if (!file_exists($path)) {
    // echo "Good";
        system('mkdir '.$path);
    }
    $path = $path.basename($_FILES['uploaded_file']['name']);
    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
        echo "The file ".basename($_FILES['uploaded_file']['name'])." has been uploaded";
    }
    else {
        echo "There was an error uploading the file, please try again!";
    }
}
?>
