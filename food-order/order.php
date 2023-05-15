<?php
require_once('partials-front/menu.php');

if (isset($_GET['food_id'])) {
    $food_id = $_GET['food_id'];
    $sql = "SELECT * FROM `tbl_food` WHERE `id`=$food_id";
    $res = $conn->query($sql);
    $count = mysqli_num_rows($res);
    if ($count > 0) {
        $row = mysqli_fetch_assoc($res);
        $title = $row['title'];
        $description = $row['description'];
        $price = $row['price'];
        $image_name = $row['image_name'];
    } else {
        $_SESSION['Unauthorized'] = "<div class='error'>Unauthorized Access.</div>";
        header('LOCATION:' . SITEURL);
        exit();
    }
} else {
    $_SESSION['Unauthorized'] = "<div class='error'>Unauthorized Access.</div>";
    header('LOCATION:' . SITEURL);
    exit();
}

?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search">
    <div class="container">

        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <form action="" class="order" method="post">
            <fieldset>
                <legend>Selected Food</legend>

                <div class="food-menu-img">
                    <?php
                    if ($image_name != "") {
                        ?>
                        <img src="images/food/<?= $image_name ?>" alt="Chicke Hawain Pizza"
                            class="img-responsive img-curve">
                        <?php
                    } else {
                        echo "<div class='eror'>Image is not available.</div>";
                    }
                    ?>
                    <?php
                    message('image');
                    ?>

                </div>

                <div class="food-menu-desc">
                    <h3>
                        <?= $title ?>
                        <?php
                        message('Title');
                        ?>
                    </h3>
                    <p class="food-price">$
                        <?= $price ?>
                        <?php
                        message('Price');
                        ?>
                    </p>

                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>
                    <?php
                    message('Qty');
                    ?>

                </div>

            </fieldset>

            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="E.g. Vijay Thapa" class="input-responsive" required>
                <?php
                message('Name');
                ?>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>
                <?php
                message('phone');
                ?>

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>
                <?php
                message('email');
                ?>

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive"
                    required></textarea>
                <?php
                message('Address');
                ?>

                <input type="hidden" name='id' value='<?= $food_id ?>'>
                <input type="hidden" name='food' value='<?= $title ?>'>
                <input type="hidden" name='price' value='<?= $price ?>'>
                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>

        </form>

        <?php
        if (isset($_POST['submit'])) {
            $id = $_POST['id'];
            $food = $_POST['food'];
            $price = $_POST['price'];
            $qty = $_POST['qty'];
            $total = $qty * $price;
            $order_date = date('Y-m-d h:m:sa');
            $status = "ordered"; // ordered, on deilevery, delivered, cancelled
            $customer_name = $_POST['full-name'];
            $customer_contact = $_POST['contact'];
            $customer_email = $_POST['email'];
            $customer_address = $_POST['address'];

            $id = number_validation($conn, $id, "Id");
            $food = string_validation($conn, $food, "Food");
            $price = number_validation($conn, $price, "Price");
            $qty = number_validation($conn, $qty, "Qty");
            $total = number_validation($conn, $total, "Total");
            date_vallidation($order_date);
            $status = string_validation($conn, $status, "Status");
            $customer_name = string_validation($conn, $customer_name, "Name");
            $customer_contact = phone_validation($customer_contact);
            $customer_email = email_validation($conn, $customer_email);
            $customer_address = string_validation($conn, $customer_address, "Address");

            if (isset($_SESSION['Id'])) {
                unset($_SESSION['Id']);
                $_SESSION['Unauthorized'] = "<div class='error'>Unauthorized Access.</div>";
                header('LOCATION:' . SITEURL);
                exit();
            }
            if (isset($_SESSION['Food']) || isset($_SESSION['Price']) || isset($_SESSION['Qty']) || isset($_SESSION['Total']) || isset($_SESSION['date']) || isset($_SESSION['Status']) || isset($_SESSION['Name']) || isset($_SESSION['phone']) || isset($_SESSION['email']) || isset($_SESSION['Address'])) {
                header('LOCATION:' . SITEURL."order.php?id=$id");
                exit();
            }



            $sql2 = "INSERT INTO `tbl_order`(`food`, `price`, `qty`, `total`, `order_date`, `status`, `customer_name`, `customer_contact`, `customer_email`, `customer_address`) 
            VALUES ('$food','$price','$qty','$total','$order_date','$status','$customer_name','$customer_contact','$customer_email','$customer_address')";
            $res2 = $conn->query($sql2);
            if ($res2 == true) {
                $_SESSION['order'] = "<div class='success'>Orderd successfully.</div>";
                header('LOCATION:' . SITEURL);
            } else {
                $_SESSION['order'] = "<div class='error'>Failed to order, please try again.</div>";
                header('LOCATION:' . SITEURL);
            }
        }
        ?>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<!-- social Section Starts Here -->
<section class="social">
    <div class="container text-center">
        <ul>
            <li>
                <a href="#"><img src="https://img.icons8.com/fluent/50/000000/facebook-new.png" /></a>
            </li>
            <li>
                <a href="#"><img src="https://img.icons8.com/fluent/48/000000/instagram-new.png" /></a>
            </li>
            <li>
                <a href="#"><img src="https://img.icons8.com/fluent/48/000000/twitter.png" /></a>
            </li>
        </ul>
    </div>
</section>
<!-- social Section Ends Here -->
<?php
require_once('partials-front/footer.php');
?>