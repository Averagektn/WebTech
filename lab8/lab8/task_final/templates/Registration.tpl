<!DOCTYPE html>
<html lang="">

<head>
    <title>Authorization</title>
    <link rel="stylesheet" type="text/css" href="../task_final/styles/Registration.css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>

<body>
    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">

        <div class="signup">
            <form action="../task_final/scripts/Registration_processing.php" method="post">
                <label for="chk" aria-hidden="true">Sign up</label>
                <input type="text" name="name" placeholder="Name" required="">
                <input type="email" name="email" placeholder="Email" required="">
                <input type="password" name="password" placeholder="Password" required="">
                <input type="submit" class="Press" value="Sign up">
            </form>
        </div>

        <div class="login">
            <form action="../task_final/scripts/Authorization_processing.php" method="post">
                <label for="chk" aria-hidden="true">Log in</label>
                <input type="email" name="email" placeholder="Email" required="">
                <input type="password" name="password" placeholder="Password" required="">
                <input type="submit" class="Press" value="Log in">
            </form>
        </div>
    </div>
</body>

</html>