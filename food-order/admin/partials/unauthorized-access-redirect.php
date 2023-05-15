<?php
function Unauthorized($filename)
{
    $_SESSION['Unauthorized'] = "<div class='error'>Unauthorized Access.</div>";
    header('LOCATION:' . SITEURL . "admin/$filename.php");
    exit();
}
function Unauthorized2()
{
    $_SESSION['login-check'] = "<div class='error'>please, login first!</div>";
    header('LOCATION:' . SITEURL . 'admin/login.php');
    exit();
}
?>