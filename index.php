<?php


?>

<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="logo">
                <img src="http://backend.delikates.co.il/assets/logo.png" class="img">
            </div>
            <div class="login">
                <form action="main.php" method="post">
                    <label for="username" class="label" id="label1">
                        הזן מייל
                    </label>
                    <input type="email" id="username" name="username" class="input" value="<?php echo $_COOKIE['username']?>">
                    <label for="username" class="label" id="label2">
                        הזן סיסמא
                    </label>
                    <input type="password" id="password" name="password" class="input" required value="<?php echo $_COOKIE['password']?>">
                    <label for="checkbox" class="label" id="label3">
                        זכור אותי
                    </label>
                    <input type="checkbox" id="checkbox" name="checkbox">
                    <input type="submit" value="היכנס" class="submit">
                </form>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
    </div>
</body>
</html>
