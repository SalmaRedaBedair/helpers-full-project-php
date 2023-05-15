<?php
require_once('partials/headers.php');
if(isset($_GET['id']) && isset($_GET['image_name']))
{
    $id=$_GET['id'];
    $id = number_validation($conn, $id, "Id");
    if (isset($_SESSION['Id'])) {
        unset($_SESSION['Id']);
        header("LOCATION:" . SITEURL . "admin/manage-admin.php");
        exit();
    }
    $image_name=$_GET['image_name'];
    $image_name = image_validation($conn, $image_name);
    if (isset($_SESSION['image'])) {
        unset($_SESSION['image']);
        header("LOCATION:" . SITEURL . "admin/manage-admin.php");
        exit();
    }
    $path = '../images/food/'.$image_name;
    $remove = unlink($path);
    if($remove==false)
    {
        $_SESSION['delete_food']="<div class='error'>Can't delete the image.</div>";
        header('LOCATION:'.SITEURL.'admin/manage-food.php');
        die();
    }

    $sql="DELETE FROM `tbl_food` WHERE `id`=$id";
    $res=mysqli_query($conn,$sql);
    if($res==true)
    {
        $_SESSION['delete_food']="<div class='success'>Food deleted successfully.</div>";
        header('LOCATION:'.SITEURL.'admin/manage-food.php');
    }
    else{
        $_SESSION['delete_food']="<div class='error'>Can't delete the food.</div>";
        header('LOCATION:'.SITEURL.'admin/manage-food.php');
        die();
    }
}else{
    Unauthorized('manage-food');
}
?>