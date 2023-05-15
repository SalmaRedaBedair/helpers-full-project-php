<?php
require_once('partials/headers.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $id = number_validation($conn, $id, "Id");
    if (isset($_SESSION['Id'])) {
        $_SESSION['delete'] = "<div class='error'>Failed to delete admin, try again later!</div>";
        unset($_SESSION['Id']);
        header("LOCATION:" . SITEURL . "admin/manage-admin.php");
        // echo $_SESSION['Id'];
        exit();
    }
    $sql = "DELETE FROM `tbl_admin` WHERE `id`=$id";
    $res = mysqli_query($conn,$sql);
    if ($res >= 1) {
        $_SESSION['delete'] = "<div class='success'>Admin deleted successfully.</div>";
        header("LOCATION:" . SITEURL . "admin/manage-admin.php");
    } else {
        $_SESSION['delete'] = "<div class='error'>Failed to delete admin, try again later!</div>";
        header("LOCATION:" . SITEURL . "admin/manage-admin.php");
    }
} else {
    Unauthorized('manage-admin');
}
?>