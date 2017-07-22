<?php
/**
 * Created by PhpStorm.
 * User: danielgontar
 * Date: 6/16/17
 * Time: 4:31 PM
 */
session_start();
$username = $_SESSION['username'];
session_destroy();
echo "bye bye ".$username;