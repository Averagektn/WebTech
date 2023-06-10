<?php

$db_host = "localhost";
$db_name = "lab6";
$db_user = "root";
$db_pass = "Oboev54";
$db = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// authorisation
if (isset($_POST['login']) && isset($_POST['password'])) {
    $login = $_POST['login'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE login = '$login' AND password = '$password'";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) == 1) {
        header("Location: file_manager.php");
        exit();
    } else {
        $error_message = "Incorrect login or password";
    }
}

// registration
if (isset($_POST['new_login']) && isset($_POST['new_password'])) {
    $new_login = $_POST['new_login'];
    $new_password = $_POST['new_password'];

    $query = "SELECT * FROM users WHERE login = '$new_login'";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) == 0) {
        $query = "INSERT INTO users (login, password) VALUES ('$new_login', '$new_password')";
        mysqli_query($db, $query);

        header("Location: file_manager.php");
        exit();
    } else {
        $error_message = "User with such login already exists";
    }
}
?>

<html>
<head>
    <title>Authorisation</title>
</head>
<body>
<h1>Log in</h1>
<form method="post">
    <label>Login:</label>
    <input type="text" name="login"><br>
    <label>Password:</label>
    <input type="password" name="password"><br>
    <input type="submit" value="Log in">
</form>

<h1>Sign up</h1>
<form method="post">
    <label>Login:</label>
    <input type="text" name="new_login"><br>
    <label>Password:</label>
    <input type="password" name="new_password"><br>
    <input type="submit" value="Sign up">
</form>

<?php if (isset($error_message)): ?>
    <p style="color: red"><?= $error_message ?></p>
<?php endif; ?>
</body>
</html>
