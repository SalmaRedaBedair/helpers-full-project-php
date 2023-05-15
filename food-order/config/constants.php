<?php 
session_start();
// create contants to store non repeating information
define('SITEURL','http://localhost/helpers/web-design-course-restaurant-master/');
define('HOST','http://'.$_SERVER['HTTP_HOST']);
define('LOCALHOST','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','food-order');
try{
    $conn= new mysqli(LOCALHOST,DB_USERNAME,DB_PASSWORD);
    $db_select=mysqli_select_db($conn,DB_NAME);
}
catch(exception $e)
{
    echo $e->getMessage();
}

?>