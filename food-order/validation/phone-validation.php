<?php
function phone_validation($phone)
{
    if(empty($phone))
    {
        $_SESSION['phone'] = "phone is required.";
    }
    if (!preg_match("/^01[0125][0-9]{8}$/", $phone)) {
        $_SESSION['phone'] = "Invalid phone number";
    }
    return $phone;
}
?>
