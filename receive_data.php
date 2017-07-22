<?php
header('Access-Control-Allow-Origin: http://www.delikates.co.il');
header('Access-Control-Allow-Methods: GET, POST');
header("Content-type:application/json; charset=utf-8");

//GET LEAD
$name = $_GET['name'];
$name = htmlspecialchars_decode($name);
$email = $_GET['email'];
$mobile = $_GET['mobile'];


//DB consts
define ('SERVER', 'localhost');
define ('DB', 'gontar_derech');
define ('USER', 'gontar_derech');
define ('PASSWORD', 'DgDgDg11');


//Add new lead
$mysqli = new mysqli(SERVER, USER, PASSWORD, DB); // tryin to connect to db
if (isset($mysqli->connect_error))
{
    echo 'there is not a connection';
}
else
{
    /* Cleaning the input */
    $name = mysqli_real_escape_string($mysqli,$name);
    $email = mysqli_real_escape_string($mysqli,$email);
    $mobile = mysqli_real_escape_string($mysqli,$mobile);


    $mysqli->query("SET NAMES 'utf8'");
    $query = "INSERT INTO `leads` (`id`, `name`, `email`, `mobile`, `createTime`, `updateTime`) VALUES (NULL, '".$name."', '".$email."', '".$mobile."', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
    if (!$mysqli->query($query, MYSQLI_STORE_RESULT))
    {
        echo "Insertion query didn't succeed";
    }
    else
    {
        echo "A lead was added successfully ";
    }
}

?>