<?php
/*Archiving leads */
define ('SERVER', 'localhost');
define ('DB', 'gontar_derech');
define ('USER', 'gontar_derech');
define ('PASSWORD', 'DgDgDg11');


$mysqli = new mysqli(SERVER, USER, PASSWORD, DB); // trying to connect to db
$mysqli->set_charset("utf8");


if (isset($_GET['lead']))
{
    $lead_id = $_GET['lead'];
    if (isset($mysqli->connect_error))
    {
        echo 'there is not a connection';
    }
    else
    {
        $query1 = "SELECT `name`,`email`,`mobile` FROM `leads` WHERE `id` = ".$lead_id;
        $result = $mysqli->query($query1);
        list($name, $email, $mobile) = $result->fetch_row();


        $query2 ="INSERT INTO `leads_archive` (`id`, `name`, `email`, `mobile`, `createTime`, `updateTime`) VALUES (NULL, '".$name."', '".$email."', '".$mobile."', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
        $result = $mysqli->query($query2);

        $query3 = "DELETE FROM `leads` WHERE `id` =".$lead_id;
        $result = $mysqli->query($query3);
        echo $result;
    }
}
elseif (isset($_GET['order']))
{
    $order_id = $_GET['order'];
    if (isset($mysqli->connect_error))
    {
        echo 'there is not a connection';
    }
    else
    {
        $query1 = "SELECT `customerNumber`,`totalExpanse` FROM `orders` WHERE `id` = ".$order_id;
        $result1 = $mysqli->query($query1);
        list($customerNumber, $totalExpanse) = $result1->fetch_row();


        $query2 ="INSERT INTO `orders_archive` (`id`, `orderNumber`,`customerNumber` , `totalExpanse` ,`createTime`, `updateTime`) VALUES (NULL, '".$order_id."', '".$customerNumber."', '".$totalExpanse."', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
        $result2 = $mysqli->query($query2);
        echo $result2;

        $query3 = "DELETE FROM `orders` WHERE `id` =".$order_id;
        $result3 = $mysqli->query($query3);
        echo $result3;
    }
}
?>