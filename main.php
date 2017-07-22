<?php

header('content-type:text/html charset: utf-8');
session_start();

$_SESSION['offset']=0;
$_SESSION['offset_order']=0;


//$username = $_POST['username'];
$username = (isset($_POST['username'])?$_POST['username']:$_SESSION['username']);
$password = $_POST['password'];
$checkbox = $_POST['checkbox'];


define ('SERVER', 'localhost');
define ('DB', 'gontar_derech');
define ('USER', 'gontar_derech');
define ('PASSWORD', 'DgDgDg11');


$mysqli = new mysqli(SERVER, USER, PASSWORD, DB); // tryin to connect to db
if (isset($mysqli->connect_error))
{
    echo 'there is not a connection';
}
else
{
    $query = 'SELECT * FROM `admin` WHERE `id` = 1';
    $result = $mysqli->query($query);
    $row = $result->fetch_row();

    $user_array = explode('@',$username);
    $db_array = explode('@', $row[1]);

    $user_array2 = explode('.',$user_array[1]);
    $db_array2 = explode('.',$db_array[1]);

    $html = '
    <html>
        <head>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
            <link rel="stylesheet" href="css/main.css">
            <!--bootstrap scripts -->
            <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
            <!--regular scripts -->
            <script src="https://www.gstatic.com/charts/loader.js"></script>
            <script> google.charts.load(\'current\', {\'packages\':[\'corechart\']}); </script>
            <script src="js/functions.js"></script>
        </head>
        <body>
            <div class="header col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="right col-lg-6 col-md-6 col-sm-4 col-xs-4"></div>
                <div class="left col-lg-6 col-md-6 col-sm-8 col-xs-8">
                    <div class="hello">
                        שלום,
                        '.$user_array[0].'
                    </div>
                    <div class="logout">
                        <a onclick="logout()"><span>התנתק</span></a>
                    </div>
                </div>
            </div>
            <div class="main col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="sidebar col-lg-2 col-md-3 col-sm-3 col-xs-3">
                    <div class="graph section">
                            <a onclick="print_graph()">גרפים</a>
                    </div>
                    <div class="orders section">
                            <a onclick="display_orders()">הזמנות שלא טופלו</a>
                    </div>
                    <div class="history section">
                        <a onclick="display_orders_archive()">
                                הזמנות שטופלו
                        </a>
                    </div>
                    <div class="leads section">
                        <a onclick="print_lead()">לידים</a>
                    </div>
                    <div class="leads_arch section">
                        <a onclick="print_arch_lead()">לידים בארכיון</a>
                    </div>
                </div>
                <div class ="page col-lg-10 col-md-9 col-sm-9 col-xs-9" id="page">
                    <div id="welcome_msg">
                        <img src="./assets/logo_header.png">
                    </div>
               </div>
            </div>
        </body>
        </html>
';

    if(!isset($_SESSION['username']) ) // the user enters to the admin pannel for the first time
    {
        if ($user_array[0]===$db_array[0] && $user_array2[0] === $db_array2[0] && $user_array2[1][0] === $db_array2[1][0] && $user_array2[1][1] === $db_array2[1][1] && $user_array2[1][2] === $db_array2[1][2])
        {
            if (password_verify($password,$row[2]))
            {
                $_SESSION['username']=$username;
                if (isset($checkbox))
                {
                    setcookie("username", $username, time()+31536000);
                    setcookie("password", $password, time()+31536000);
                }
                echo $html;
            }
            else
            {
                echo '<script>window.location.assign("http://backend.delikates.co.il/index.php")</script>';
            }
        }
        else
        {
            echo '<script>window.location.assign("http://backend.delikates.co.il/index.php")</script>';
        }
    }
    else // returning user
    {
        echo $html;
    }
}
?>