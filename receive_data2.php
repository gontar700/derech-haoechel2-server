<?php
header('Access-Control-Allow-Origin: http://www.delikates.co.il');
header('Access-Control-Allow-Methods: GET, POST');
header("Content-type:application/json; charset=utf-8");

//DB consts
define ('SERVER', 'localhost');
define ('DB', 'gontar_derech');
define ('USER', 'gontar_derech');
define ('PASSWORD', 'DgDgDg11');

$data = file_get_contents("php://input");
$json = json_decode($data);

global $ccustomer;
global $corder;

/*
 * Add order, product , client , order details , terms of patment
 * global numerators of new tables
*/


$mysqli = new mysqli(SERVER, USER, PASSWORD, DB); // tryin to connect to db
if (isset($mysqli->connect_error))
{
    echo 'there is not a connection';
}
else
{
    /* Cleaning the input for products customers*/
    $name = mysqli_real_escape_string($mysqli,$json->userName);
    $email = mysqli_real_escape_string($mysqli,$json->useEmail);
    $phone = mysqli_real_escape_string($mysqli,$json->userPhone);
    $address = mysqli_real_escape_string($mysqli,$json->userAddress);
    $city = mysqli_real_escape_string($mysqli,$json->userCity);

    /* Insert data into customers table*/
    $mysqli->query("SET NAMES 'utf8'");
    $query = "INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `city`, `timeCreate`, `timeUpdate`) VALUES (null ,'".$name."','".$email."','".$phone."','".$address."','".$city."',CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

    if (!$mysqli->query($query, MYSQLI_STORE_RESULT))
    {
        echo "Insertion query didn't succeed";
    }
    else
    {
        echo "A new customer was added successfully ";
        $query = "SELECT COUNT(*) FROM `customers`";
        $ccustomer = $mysqli->query($query)->fetch_row()[0];
    }

    /* Cleaning the input for pots*/
    $type = mysqli_real_escape_string($mysqli,$json->cardType);
    $payments = mysqli_real_escape_string($mysqli,$json->cardPayments);
    $number = mysqli_real_escape_string($mysqli,$json->cardNumber);
    $cvv = mysqli_real_escape_string($mysqli,$json->cardCvv);
    $month = mysqli_real_escape_string($mysqli,$json->cardMonth);
    $year = mysqli_real_escape_string($mysqli,$json->cardYear);

    /* Insert data into pots table*/
    $mysqli->query("SET NAMES 'utf8'");
    $query = "INSERT INTO `pots` (`id`, `type`, `payments`, `number`, `cvv`, `month`, `year`, `customerNumber`, `createTime`, `updateTime`) VALUES (NULL, '".$type."', '".$payments."', '".$number."', '".$cvv."', '".$month."', '".$year."', '".$ccustomer."', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

    if (!$mysqli->query($query, MYSQLI_STORE_RESULT))
    {
        echo "Insertion query didn't succeed";
    }
    else
    {
        echo "A new pot was added successfully ";
    }

    /* Cleaning the input for orders*/
    $totalExpense = mysqli_real_escape_string($mysqli,$json->totalExpance);

    /* Insert data into orders table*/
    $mysqli->query("SET NAMES 'utf8'");
    $query = "INSERT INTO `orders` (`id`, `customerNumber`, `totalExpanse`, `createTime`, `updateTime`) VALUES (NULL, '".$ccustomer."', '".$totalExpense."', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";

    if (!$mysqli->query($query, MYSQLI_STORE_RESULT))
    {
        //echo "Insertion query for order didn't succeed";
        echo $query;
    }
    else
    {
        echo "A new order was added successfully ";
        $query1 = "SELECT COUNT(*) FROM `orders`";
        $corder = $mysqli->query($query1)->fetch_row()[0];

        //adding count number of orders in orders_archive table;
        $query2 = "SELECT COUNT(*) FROM `orders_archive`";
        $corder += $mysqli->query($query2)->fetch_row()[0];
    }

    /* Cleaning the input for order products*/
    $productAmount1 = mysqli_real_escape_string($mysqli,$json->productAmount1);
    $productAmount2 = mysqli_real_escape_string($mysqli,$json->productAmount2);
    $productAmount3 = mysqli_real_escape_string($mysqli,$json->productAmount3);

    /* Insert data into order products table*/
    $mysqli->query("SET NAMES 'utf8'");
    $query1 = "INSERT INTO `productsInOrders` (`id`, `orderNumber`, `productNumber`, `Amount`, `timeCreate`, `timeUpdate`) VALUES (NULL, '".$corder."', '1', '".$productAmount1."', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

    if (!$mysqli->query($query1, MYSQLI_STORE_RESULT))
    {
        echo "Insertion query didn't succeed";
    }
    else
    {
        echo "A new products order raw was added successfully ";
    }

    $query2 = "INSERT INTO `productsInOrders` (`id`, `orderNumber`, `productNumber`, `Amount`, `timeCreate`, `timeUpdate`) VALUES (NULL, '".$corder."', '2', '".$productAmount2."', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

    if (!$mysqli->query($query2, MYSQLI_STORE_RESULT))
    {
        echo "Insertion query didn't succeed";
    }
    else
    {
        echo "A new products order raw was added successfully ";
    }

    $query3 = "INSERT INTO `productsInOrders` (`id`, `orderNumber`, `productNumber`, `Amount`, `timeCreate`, `timeUpdate`) VALUES (NULL, '".$corder."', '3', '".$productAmount3."', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";

    if (!$mysqli->query($query3, MYSQLI_STORE_RESULT))
    {
        echo "Insertion query didn't succeed";
    }
    else
    {
        echo "A new products order raw was added successfully ";
    }

}