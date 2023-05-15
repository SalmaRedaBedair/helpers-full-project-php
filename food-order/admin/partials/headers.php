<?php 
require_once('../config/constants.php');
foreach (glob("../validation/*.php") as $filename) {
    require_once $filename;
}
require_once("partials/unauthorized-access-redirect.php");
?>