<?php
header("Cache-Control: no-cache, must-revalidate");


define ('SERVER', 'localhost');
define ('DB', 'gontar_derech');
define ('USER', 'gontar_derech');
define ('PASSWORD', 'DgDgDg11');
session_start();


$mysqli = new mysqli(SERVER, USER, PASSWORD, DB); // trying to connect to db
$mysqli->set_charset("utf8");

if (isset($_GET['action']))
{
    $request = $_GET['action'];
    switch ($request)
    {
        case 'lead';
            if (isset($mysqli->connect_error))
            {
                echo 'there is not a connection';
                break;
            }
            else
            {
                $query = "SELECT * FROM `leads` limit 13";
                $result = $mysqli->query($query);
                $response = "
                            <div class='row' id='headline'>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
                                שם
                                </div>
                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>
                                אימייל
                                </div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
נייד
                                </div>
                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>
זמן יצירה
                                </div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
                                
                                </div>
                            </div>";
                while (list($id, $name, $email, $mobile, $createTime, $updateTime) = $result->fetch_row()) {
                    $response .= "
                            <div class='row'>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" . $name. "</div>
                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>" . $email . "</div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" . $mobile . "</div>
                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>".substr($createTime,10,9).' '.substr($createTime,8,2).'/'.substr($createTime,5,2) .'/'.substr($createTime,0,4) ."</div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'><button class='btn btn-danger btn_archive' onclick='archive_lead(".$id.")'>
                                ארכיון 
                                </button></div>
                            </div>";
                }
                $response.= "<button class='btn btn-success btn_next'>הבא</button>";
                echo $response;
                break;
            }
        case 'arch_lead';
            if (isset($mysqli->connect_error))
            {
                echo 'there is not a connection';
                break;
            }
            else
            {
                $_SESSION['offset']=0;
                $query = "SELECT `name`,`email`,`mobile`,`createTime` FROM `leads_archive` ORDER BY `createTime` DESC LIMIT 13 OFFSET 0";
                $result = $mysqli->query($query);
                $response = "
                        <div class='row' id='headline'>
                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>
                                שם
                                </div>
                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>
                                אימייל
                                </div>
                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>
נייד
                                </div>
                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>
זמן יצירה
                                </div>
                            </div>";
                while (list($name, $email, $mobile, $createTime) = $result->fetch_row()) {
                    $response .= "
                                <div class='row'>
                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>" . $name. "</div>
                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>" . $email . "</div>
                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>" . $mobile . "</div>
                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>".substr($createTime,10,9).' '.substr($createTime,8,2).'/'.substr($createTime,5,2) .'/'.substr($createTime,0,4) ."</div>
                                </div>";
                }
                $response.= "<button class='btn btn-success btn_next' onclick='next_print_arch_lead()'>הבא</button>";
                echo $response;
                break;
            }
        case 'arch_lead_next';
            $_SESSION['offset']+=13;
            if (isset($mysqli->connect_error))
            {
                echo 'there is not a connection';
                break;
            }
            else
            {
                $query = "SELECT `name`,`email`,`mobile`,`createTime` FROM `leads_archive` ORDER BY `createTime` DESC LIMIT 13 OFFSET ".$_SESSION['offset'];

                $result = $mysqli->query($query);
                $response = "
                        <div class='row' id='headline'>
                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>
                                שם
                                </div>
                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>
                                אימייל
                                </div>
                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>
נייד
                                </div>
                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>
זמן יצירה
                                </div>
                            </div>";
                while (list($name, $email, $mobile, $createTime) = $result->fetch_row()) {
                    $response .= "
                                <div class='row'>
                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>" . $name. "</div>
                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>" . $email . "</div>
                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>" . $mobile . "</div>
                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>".substr($createTime,1100,9).' '.substr($createTime,8,2).'/'.substr($createTime,5,2) .'/'.substr($createTime,0,4) ."</div>
                                </div>";
                }
                $response.= "<button class='btn btn-success btn_prev' onclick='prev_print_arch_lead()'>הקודם</button>";
                $response.= "<button class='btn btn-success btn_next' onclick='next_print_arch_lead()'>הבא</button>";

                //echo $_SESSION['offset'];
                echo $response;
                break;
            }
        case 'arch_lead_prev';
            // Displaying previous 13 leads
            if (isset($mysqli->connect_error))
            {
                echo 'there is not a connection';
                break;
            }
            else
            {
                if (($_SESSION['offset']>13) || ($_SESSION['offset']==13))
                {
                    $_SESSION['offset']-=13;
                }
                $query = "SELECT `name`,`email`,`mobile`,`createTime` FROM `leads_archive` ORDER BY `createTime` DESC LIMIT 13 OFFSET ".$_SESSION['offset'];
                $result = $mysqli->query($query);
                $response = "
                        <div class='row' id='headline'>
                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>
                                שם
                                </div>
                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>
                                אימייל
                                </div>
                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>
נייד
                                </div>
                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>
זמן יצירה
                                </div>
                            </div>";
                while (list($name, $email, $mobile, $createTime) = $result->fetch_row()) {
                    $response .= "
                                <div class='row'>
                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>" . $name. "</div>
                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>" . $email . "</div>
                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>" . $mobile . "</div>
                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>".substr($createTime,1100,9).' '.substr($createTime,8,2).'/'.substr($createTime,5,2) .'/'.substr($createTime,0,4) ."</div>
                                </div>";
                }
                $response.= "<button class='btn btn-success btn_next' onclick='next_print_arch_lead()'>הבא</button>";
                if (($_SESSION['offset']>13) || ($_SESSION['offset']==13))
                {
                    $response.= "<button class='btn btn-success btn_prev' onclick='prev_print_arch_lead()'>הקודם</button>";
                }
                echo $response;
                break;
            }
        case 'pie_new_lead';
            if (isset($mysqli->connect_error))
            {
                echo 'there is not a connection';
                break;
            }
            else
            {
                $query1 = "SELECT COUNT(DISTINCT `id`) AS `number_of_leads` FROM `leads`";
                $result = $mysqli->query($query1);
                $number_of_leads = $result->fetch_row()[0];

                echo $number_of_leads;
                break;

            }
        // calculating total number of archived leads
        case 'pie_arch_lead';
            if (isset($mysqli->connect_error))
            {
                echo 'there is not a connection';
                break;
            }
            else
            {
                $query2 = "SELECT COUNT(DISTINCT `id`) AS `number_of_leads` FROM `leads_archive`";
                $result = $mysqli->query($query2);
                $number_of_archived_leads = $result->fetch_row()[0];

                echo $number_of_archived_leads;
                break;
            }
            // calculating number of leads last month
        case 'pie_total_amount_month_lead';
            if (isset($mysqli->connect_error))
            {
                echo 'there is not a connection';
                break;
            }
            else
            {
                $toDate = date('Y-m-d',time()+60*60*24);
                $lastMonthDate = date('Y-m-d',time() - 60 * 60 * 24 * 30);

                $query1 = "SELECT COUNT(*) AS `number_of_leads` FROM `leads` WHERE ((`createTime`>'$lastMonthDate') OR (`createTime`='$lastMonthDate')) AND ((`createTime`<'$toDate') OR (`createTime`='$toDate'))";


                $result1 = $mysqli->query($query1);
                $number_of_leads_last_month = $result1->fetch_row()[0];


                $query2 = "SELECT COUNT(*) AS `number_of_leads` FROM `leads_archive` WHERE ((`createTime`>'$lastMonthDate') OR (`createTime`='$lastMonthDate')) AND ((`createTime`<'$toDate') OR (`createTime`='$toDate'))";

                $result2 = $mysqli->query($query2);
                $number_of_arch_leads_last_month = $result2->fetch_row()[0];

                $total_leads_last_month = $number_of_leads_last_month + $number_of_arch_leads_last_month;
                echo $total_leads_last_month;

                break;
            }

        case 'pie_total_amount_month2_lead';
            if (isset($mysqli->connect_error))
            {
                echo 'there is not a connection';
                break;
            }
            else
            {
                $toDate = date('Y-m-d',time() - 60 * 60 * 24 * 30);
                $lastMonthDate = date('Y-m-d',time() -2 * 60 * 60 * 24 * 30 );

                $query1 = "SELECT COUNT(*) AS `number_of_leads` FROM `leads` WHERE ((`createTime`>'$lastMonthDate') OR (`createTime`='$lastMonthDate')) AND ((`createTime`<'$toDate') OR (`createTime`='$toDate'))";
                $result1 = $mysqli->query($query1);
                $number_of_leads_last_month2 = $result1->fetch_row()[0];


                $query2 = "SELECT COUNT(*) AS `number_of_leads` FROM `leads_archive` WHERE ((`createTime`>'$lastMonthDate') OR (`createTime`='$lastMonthDate')) AND ((`createTime`<'$toDate') OR (`createTime`='$toDate'))";
                $result2 = $mysqli->query($query2);
                $number_of_arch_leads_last_month2 = $result2->fetch_row()[0];

                $total_leads_last_month2 = $number_of_leads_last_month2 + $number_of_arch_leads_last_month2;
                echo $total_leads_last_month2;

                break;
            }

        case 'pie_total_amount_month3_lead';
            if (isset($mysqli->connect_error))
            {
                echo 'there is not a connection';
                break;
            }
            else
            {
                $toDate = date('Y-m-d',time() - 2 * 60 * 60 * 24 * 30 );
                $lastMonthDate = date('Y-m-d',time() -3 * 60 * 60 * 24 * 30 - 60 * 60 * 24 * 30);

                $query1 = "SELECT COUNT(*) AS `number_of_leads` FROM `leads` WHERE ((`createTime`>'$lastMonthDate') OR (`createTime`='$lastMonthDate')) AND ((`createTime`<'$toDate') OR (`createTime`='$toDate'))";
                $result1 = $mysqli->query($query1);
                $number_of_leads_last_month3 = $result1->fetch_row()[0];


                $query2 = "SELECT COUNT(*) AS `number_of_leads` FROM `leads_archive` WHERE ((`createTime`>'$lastMonthDate') OR (`createTime`='$lastMonthDate')) AND ((`createTime`<'$toDate') OR (`createTime`='$toDate'))";
                $result2 = $mysqli->query($query2);
                $number_of_arch_leads_last_month3 = $result2->fetch_row()[0];

                $total_leads_last_month3 = $number_of_leads_last_month3 + $number_of_arch_leads_last_month3;
                echo $total_leads_last_month3;

                break;
            }
        case 'order_details':
            if (isset($mysqli->connect_error))
            {
                echo 'there is not a connection';
                break;
            }
            else
            {
                $query="SELECT A.`id` , `name` , `phone` , `address` ,`city` ,`createTime` FROM `orders` AS A JOIN `customers` AS B WHERE A.`customerNumber` = B.`id` ORDER BY `createTime` ASC limit 12";
                $result = $mysqli->query($query);
                $response = "
                        <div class='row' id='headline' style='text-align: center'>
                                <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
     הזמנה
                                </div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
                                שם לקוח
                                </div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
נייד
                                </div>
                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>
כתובת
                                </div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
עיר
                                </div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>

                                </div>
                            </div>";
                while (list($id, $name, $phone, $address, $city) = $result->fetch_row())
                {
                    $response .= "
                                <div class='row' style='text-align: center'>
                                    <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>" . $id. "</div>
                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" . $name . "</div>
                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" . $phone . "</div>
                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>" . $address . "</div>
                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" . $city . "</div> 
                                    <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
                                        <button class='btn btn-info btn-order' onclick='display_orders_more(".$id.")'>
                                        מידע נוסף
                                        </button>
                                    </div>
                                    <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
                                        <button class='btn btn-danger btn-order' onclick='archive_order(".$id.")'>
                                        ארכיון
                                        </button>
                                    </div>
                                </div>";
                }
                $response.= "<button class='btn btn-success btn_next'>הבא</button>";
                echo $response;
                break;
            }
        case 'order_details_more':
            if (isset($mysqli->connect_error))
            {
                echo 'there is not a connection';
                break;
            }
            else
            {
                $orderNumber = $_GET['orderNumber'];
                $query="SELECT A.`id` , A.`name`, B.`Amount` , A.`price` FROM `products` AS A 
                        JOIN `productsInOrders` AS B ON A.`id` = B.`productNumber` 
                        WHERE `orderNumber` = '$orderNumber'";
                $result = $mysqli->query($query);
                $response = "
                        <div class='row' id='headline' style='text-align: center'>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
מספר מנה
                                </div>
                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>
שם מנה
                                </div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
                                כמות
                                </div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
מחיר
                                </div>
                       </div>";
                while (list($id, $name, $amount, $price) = $result->fetch_row())
                {
                    $response .= "
                                <div class='row' style='text-align: center'>
                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" . $id. "</div>
                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>" . $name . "</div>
                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" . $amount . "</div>
                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" . $price . "</div>
                                </div>";
                }

                //second query

                $query="SELECT B.`type`, B.`number`, B.`year`,B.`month`, B.`payments`, A.`totalExpanse` FROM `orders` AS A JOIN `pots` AS B 
                        WHERE A.`id` = B.`customerNumber` AND A.`id` = '$orderNumber'";
                $result = $mysqli->query($query);


                $response .= "
                        <div class='row' id='headline2' style='text-align: center; background-color: aquamarine'>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
סוג כרטיס
                                </div>
                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>
מספר כרטיס
                                </div>
                                <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
                                שנה
                                </div>
                                <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
חודש
                                </div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
עלות כוללת
                                </div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
                                מספר תשלומים
                                </div>
                                <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
                                
                                </div>
                       </div>";
                while (list($type, $number, $year, $month, $payments, $totalExpanse) = $result->fetch_row())
                {
                    $response .= "
                                <div class='row' style='text-align: center'>
                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" . $type. "</div>
                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>" . $number . "</div>
                                    <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>" . $year . "</div>
                                    <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>" . $month . "</div>
                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" . $totalExpanse . "</div>
                                     <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" . $payments . "</div>
                                    <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
                                        <button class='btn btn-success btn-order'>בדוק חיוב</button>
                                    </div>
                                </div>";
                }

                // if the order has moved to archived table we need to loop again with the archived table
                $query2="SELECT B.`type`, B.`number`, B.`year`,B.`month`, B.`payments`, A.`totalExpanse` FROM `orders_archive` AS A JOIN `pots` AS B 
                        WHERE A.`orderNumber` = B.`customerNumber` AND A.`orderNumber` = '$orderNumber'";
                $result2 = $mysqli->query($query2);

                while (list($type, $number, $year, $month, $payments, $totalExpanse) = $result2->fetch_row())
                {
                    $response .= "
                                <div class='row' style='text-align: center'>
                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" . $type. "</div>
                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>" . $number . "</div>
                                    <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>" . $year . "</div>
                                    <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>" . $month . "</div>
                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" . $totalExpanse . "</div>
                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" . $payments . "</div>
                                    <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
                                        <button class='btn btn-success btn-order'>בדוק חיוב</button>
                                    </div>
                                </div>";
                }

                echo $response;
                break;
            }
            // display archived orders
        case 'arch_order';
            if (isset($mysqli->connect_error))
            {
                echo 'there is not a connection';
                break;
            }
            else
            {
                $_SESSION['offset_order']=0;
                $query="SELECT A.`orderNumber` , `name` , `phone` , `address` ,`city` ,`createTime` FROM `orders_archive` AS A JOIN `customers` AS B WHERE A.`customerNumber` = B.`id` ORDER BY `createTime` ASC limit 11";
                $result = $mysqli->query($query);
                $response = "
                        <div class='row' id='headline' style='text-align: center'>
                                <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
     הזמנה
                                </div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
                                שם לקוח
                                </div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
נייד
                                </div>
                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>
כתובת
                                </div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
עיר
                                </div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>

                                </div>
                            </div>";
                while (list($orderNumber, $name, $phone, $address, $city) = $result->fetch_row())
                {
                    $response .= "
                                <div class='row' style='text-align: center'>
                                    <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>" . $orderNumber . "</div>
                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" . $name . "</div>
                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" . $phone . "</div>
                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>" . $address . "</div>
                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" . $city . "</div> 
                                    <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
                                        <button class='btn btn-info btn-order' onclick='display_orders_more(".$orderNumber.")'>
                                        מידע נוסף
                                        </button>
                                    </div>
                                </div>";
                }
                $response.= "<button class='btn btn-success btn_next' onclick='next_print_arch_order()'>הבא</button>";
                echo $response;
                break;
            }
        // Displaying next 11 orders
        case 'arch_order_next';
            $_SESSION['offset_order']+=11;
            if (isset($mysqli->connect_error))
            {
                echo 'there is not a connection';
                break;
            }
            else
            {
                $query="SELECT A.`orderNumber` , `name` , `phone` , `address` ,`city` ,`createTime` FROM `orders_archive` AS A JOIN `customers` AS B WHERE A.`customerNumber` = B.`id` ORDER BY `createTime` ASC limit 11 offset ".$_SESSION['offset_order'];
                $result = $mysqli->query($query);
                $response = "
                        <div class='row' id='headline' style='text-align: center'>
                                <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
     הזמנה
                                </div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
                                שם לקוח
                                </div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
נייד
                                </div>
                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>
כתובת
                                </div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
עיר
                                </div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>

                                </div>
                            </div>";
                while (list($orderNumber, $name, $phone, $address, $city) = $result->fetch_row())
                {
                    $response .= "
                                <div class='row' style='text-align: center'>
                                    <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>" . $orderNumber . "</div>
                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" . $name . "</div>
                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" . $phone . "</div>
                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>" . $address . "</div>
                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" . $city . "</div> 
                                    <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
                                        <button class='btn btn-info btn-order' onclick='display_orders_more(".$orderNumber.")'>
                                        מידע נוסף
                                        </button>
                                    </div>
                                </div>";
                }
                $response.= "<button class='btn btn-success btn_prev' onclick='prev_print_arch_order()'>הקודם</button>";
                $response.= "<button class='btn btn-success btn_next' onclick='next_print_arch_order()'>הבא</button>";

                echo $response;
                break;
            }
        case 'arch_order_prev';
            // Displaying previous 11 orders
            if (isset($mysqli->connect_error))
            {
                echo 'there is not a connection';
                break;
            }
            else
            {
                if (($_SESSION['offset_order']>11) || ($_SESSION['offset_order']==11))
                {
                    $_SESSION['offset_order']-=11;
                }
                $query="SELECT A.`orderNumber` , `name` , `phone` , `address` ,`city` ,`createTime` FROM `orders_archive` AS A JOIN `customers` AS B WHERE A.`customerNumber` = B.`id` ORDER BY `createTime` ASC limit 11 offset ".$_SESSION['offset_order'];
                $result = $mysqli->query($query);
                $response = "
                        <div class='row' id='headline' style='text-align: center'>
                                <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
     הזמנה
                                </div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
                                שם לקוח
                                </div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
נייד
                                </div>
                                <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>
כתובת
                                </div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>
עיר
                                </div>
                                <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>

                                </div>
                            </div>";
                while (list($orderNumber, $name, $phone, $address, $city) = $result->fetch_row())
                {
                    $response .= "
                                <div class='row' style='text-align: center'>
                                    <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>" . $orderNumber . "</div>
                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" . $name . "</div>
                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" . $phone . "</div>
                                    <div class='col-lg-3 col-md-3 col-sm-3 col-xs-3'>" . $address . "</div>
                                    <div class='col-lg-2 col-md-2 col-sm-2 col-xs-2'>" . $city . "</div> 
                                    <div class='col-lg-1 col-md-1 col-sm-1 col-xs-1'>
                                        <button class='btn btn-info btn-order' onclick='display_orders_more(".$orderNumber.")'>
                                        מידע נוסף
                                        </button>
                                    </div>
                                </div>";
                }
                $response.= "<button class='btn btn-success btn_next' onclick='next_print_arch_order()'>הבא</button>";
                if (($_SESSION['offset_order']>11) || ($_SESSION['offset_order']==11))
                {
                    $response.= "<button class='btn btn-success btn_prev' onclick='prev_print_arch_order()'>הקודם</button>";
                }
                echo $response;
                break;
            }
        // calculating total sales last month
        case 'pie_income_orders_month1':
            if (isset($mysqli->connect_error))
            {
                echo 'there is not a connection';
                break;
            }
            else
            {
                $toDate = date('Y-m-d',time()+60*60*24);
                $lastMonthDate = date('Y-m-d',time() - 60 * 60 * 24 * 30);

                $query1 = "SELECT SUM(`totalExpanse`) AS TotalExpances FROM `orders` WHERE ((`createTime`>'$lastMonthDate') OR (`createTime`='$lastMonthDate')) AND ((`createTime`<'$toDate') OR (`createTime`='$toDate'))";


                $result1 = $mysqli->query($query1);
                $sum_of_orders_last_month = $result1->fetch_row()[0];


                $query2 = "SELECT SUM(`totalExpanse`) AS TotalExpances FROM `orders_archive` WHERE ((`createTime`>'$lastMonthDate') OR (`createTime`='$lastMonthDate')) AND ((`createTime`<'$toDate') OR (`createTime`='$toDate'))";

                $result2 = $mysqli->query($query2);
                $sum_of_arch_orders_last_month = $result2->fetch_row()[0];

                $sum_orders_last_month = $sum_of_orders_last_month + $sum_of_arch_orders_last_month;
                echo $sum_orders_last_month;

                break;
            }
        case 'pie_income_orders_month2':
            if (isset($mysqli->connect_error))
            {
                echo 'there is not a connection';
                break;
            }
            else
            {
                $toDate = date('Y-m-d',time() - 60 * 60 * 24 * 30);
                $lastMonthDate = date('Y-m-d',time() -2 * 60 * 60 * 24 * 30 );

                $query1 = "SELECT SUM(`totalExpanse`) AS TotalExpances FROM `orders` WHERE ((`createTime`>'$lastMonthDate') OR (`createTime`='$lastMonthDate')) AND ((`createTime`<'$toDate') OR (`createTime`='$toDate'))";


                $result1 = $mysqli->query($query1);
                $sum_of_orders_last_month = $result1->fetch_row()[0];


                $query2 = "SELECT SUM(`totalExpanse`) AS TotalExpances FROM `orders_archive` WHERE ((`createTime`>'$lastMonthDate') OR (`createTime`='$lastMonthDate')) AND ((`createTime`<'$toDate') OR (`createTime`='$toDate'))";

                $result2 = $mysqli->query($query2);
                $sum_of_arch_orders_last_month = $result2->fetch_row()[0];

                $sum_orders_last_month = $sum_of_orders_last_month + $sum_of_arch_orders_last_month;
                echo $sum_orders_last_month;

                break;
            }
        case 'pie_income_orders_month3':
            if (isset($mysqli->connect_error))
            {
                echo 'there is not a connection';
                break;
            }
            else
            {
                $toDate = date('Y-m-d',time() - 2 * 60 * 60 * 24 * 30 );
                $lastMonthDate = date('Y-m-d',time() -3 * 60 * 60 * 24 * 30 - 60 * 60 * 24 * 30);

                $query1 = "SELECT SUM(`totalExpanse`) AS TotalExpances FROM `orders` WHERE ((`createTime`>'$lastMonthDate') OR (`createTime`='$lastMonthDate')) AND ((`createTime`<'$toDate') OR (`createTime`='$toDate'))";


                $result1 = $mysqli->query($query1);
                $sum_of_orders_last_month = $result1->fetch_row()[0];


                $query2 = "SELECT SUM(`totalExpanse`) AS TotalExpances FROM `orders_archive` WHERE ((`createTime`>'$lastMonthDate') OR (`createTime`='$lastMonthDate')) AND ((`createTime`<'$toDate') OR (`createTime`='$toDate'))";

                $result2 = $mysqli->query($query2);
                $sum_of_arch_orders_last_month = $result2->fetch_row()[0];

                $sum_orders_last_month = $sum_of_orders_last_month + $sum_of_arch_orders_last_month;
                echo $sum_orders_last_month;

                break;
            }
    }
}

