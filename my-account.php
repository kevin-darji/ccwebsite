<?php
session_start();

// Check if the user is logged in
$userLoggedIn = isset($_SESSION['name']);

// Database configuration
$host = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'ccwebsite';

// Create connection
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch user details by name
function fetchUserDetails($conn, $name)
{
    // Prepare and execute SQL query to fetch user details
    $sql = "SELECT * FROM users WHERE name = '$name'";
    $result = $conn->query($sql);

    // Check if user details are found
    if ($result->num_rows == 1) {
        // Fetch user details
        $row = $result->fetch_assoc();
        return $row;
    } else {
        // User not found
        return null;
    }
}

// Fetch user's address data
$userAddress = fetchUserAddress($conn);

// Function to fetch address for a user by name
function fetchUserAddress($conn)
{
    // Prepare SQL query to fetch the user's address
    $userName = $_SESSION['name'];
    $sql = "SELECT * FROM user_addresses WHERE name='$userName'";

    // Execute the query
    $result = $conn->query($sql);

    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Fetch the address data
        $userAddress = $result->fetch_assoc();
        return $userAddress;
    } else {
        // No address found for the user
        return null;
    }
}

// Function to fetch orders for a user by name
function fetchOrdersForUser($conn, $name)
{
    // Prepare and execute SQL query to fetch orders for the user
    $sqlOrders = "SELECT order_id, product_name, product_quantity, product_size, product_price FROM orders WHERE user_name = '$name'";
    $resultOrders = $conn->query($sqlOrders);

    // Initialize an empty array to store orders
    $orders = array();

    // Check if orders are found
    if ($resultOrders->num_rows > 0) {
        // Output data of each row
        while ($rowOrder = $resultOrders->fetch_assoc()) {
            // Append each order to the $orders array
            $orders[] = $rowOrder;
        }
    }

    // Return the array of orders
    return $orders;
}

// Fetch orders for the logged-in user
if ($userLoggedIn) {
    $name = $_SESSION['name'];
    $userDetails = fetchUserDetails($conn, $name);
    $orders = fetchOrdersForUser($conn, $name);
} else {
    echo "User not logged in.";
}

// Close database connection
$conn->close();

?>


<!doctype html>
<html class="no-js" lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Classic Creation</title>
    <meta name="robots" content="noindex, follow" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="CC LOGO in small.png">

    <!-- CSS
	============================================ -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/vendor/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="assets/css/vendor/font.awesome.min.css">
    <!-- Linear Icons CSS -->
    <link rel="stylesheet" href="assets/css/vendor/linearicons.min.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="assets/css/plugins/swiper-bundle.min.css">
    <!-- Animation CSS -->
    <link rel="stylesheet" href="assets/css/plugins/animate.min.css">
    <!-- Jquery ui CSS -->
    <link rel="stylesheet" href="assets/css/plugins/jquery-ui.min.css">
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="assets/css/plugins/nice-select.min.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="assets/css/plugins/magnific-popup.css">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <style>
        /* CSS styles for the address form */
        .address-form {
            width: 300px;
            margin: 0 auto;
            padding-bottom: 50px;
            /* Add padding to the bottom to prevent overlapping with footer */
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: #007bff;
        }

        button[type="submit"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <!-- Header Area Start Here -->
    <header class="main-header-area">
        <!-- Main Header Area Start -->
        <div class="main-header header-sticky">
            <div class="container custom-area">
                <div class="row align-items-center">
                    <div class="col-lg-2 col-xl-2 col-md-6 col-6 col-custom">
                        <div class="header-logo d-flex align-items-center">
                            <a href="home.php">
                                <img class="img-full" src="project-logo.png" alt="Header Logo">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-8 d-none d-lg-flex justify-content-center col-custom">
                        <nav class="main-nav d-none d-lg-flex">
                            <ul class="nav">
                                <li>
                                    <a class="active" href="home.php">
                                        <span class="menu-text">Home</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="#product">
                                        <span class="menu-text">Products</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#contact-us">
                                        <span class="menu-text">Contact Us</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-lg-2 col-md-6 col-6 col-custom">
                        <div class="header-right-area main-nav">
                            <ul class="nav">
                                <li class="minicart-wrap">
                                    <div class="greeting-container">
                                        <?php
                                        if (isset($_SESSION['userLoggedIn']) && $_SESSION['userLoggedIn']) {
                                            echo '<p class="user-greeting">Hi, ' . $_SESSION['name'] . '</p>';
                                        } else {
                                            echo '<p class="user-greeting">Hi, Guest</p>';
                                        }
                                        ?>
                                    </div>
                                    <a href="#" class="minicart-btn toolbar-btn" id="userBtn">
                                        <i class="fa fa-user"></i>
                                    </a>
                                    </a>
                                    <ul class="dropdown-submenu dropdown-hover" id="userDropdown">
                                        <li><a href="my-account.php" id="myAccountLink">My Account</a></li>
                                        <?php
                                        if (isset($_SESSION['name'])) {
                                            echo '<li><a href="home.php?logout">Logout</a></li>';
                                        } else {
                                            echo '<li><a href="login.php">Login/Register</a></li>';
                                        }
                                        ?>
                                        <li><a href="admin\login.php">Admin Login</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main Header Area End -->
    </header>
    <!-- Header Area End Here -->
    <!-- Breadcrumb Area Start Here -->
    <div class="breadcrumbs-area position-relative">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="breadcrumb-content position-relative section-content">
                        <h3 class="title-3">My Account</h3>
                        <ul>
                            <li><a href="home.php">Home</a></li>
                            <li>My Account</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End Here -->
    <br>
    <!-- my account wrapper start -->
    <div class="my-account-wrapper mt-no-text">
        <div class="container container-default-2 custom-area">
            <div class="row">
                <div class="col-lg-12 col-custom">
                    <!-- My Account Page Start -->
                    <div class="myaccount-page-wrapper">
                        <!-- My Account Tab Menu Start -->
                        <div class="row">
                            <div class="col-lg-3 col-md-4 col-custom">
                                <div class="myaccount-tab-menu nav" role="tablist">
                                    <a href="#dashboad" class="active" data-bs-toggle="tab"><i class="fa fa-dashboard"></i>
                                        Dashboard</a>
                                    <a href="#orders" data-bs-toggle="tab"><i class="fa fa-cart-arrow-down"></i>
                                        Orders</a>
                                    <a href="#address-edit" data-bs-toggle="tab"><i class="fa fa-map-marker"></i>
                                        address</a>
                                    <a href="#account-info" data-bs-toggle="tab"><i class="fa fa-user"></i> Account
                                        Details</a>
                                </div>
                            </div>
                            <!-- My Account Tab Menu End -->

                            <!-- My Account Tab Content Start -->
                            <div class="col-lg-9 col-md-8 col-custom">
                                <div class="tab-content" id="myaccountContent">
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3 style="color: black !important;">Dashboard</h3>

                                            <div class="welcome">
                                                <?php
                                                if ($userLoggedIn) {
                                                    echo '<p>Hello, <strong>' . $_SESSION['name'] . '</strong></p>';
                                                } else {
                                                    echo '<p>Hello, Guest</p>';
                                                }
                                                ?>
                                            </div>
                                            <p class="mb-0">From your account dashboard. you can easily check & view
                                                your recent orders, manage your shipping and billing addresses and edit
                                                your password and account details.</p>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="orders" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3 style="color: black !important;">Orders</h3>
                                            <div class="myaccount-table table-responsive text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>Order</th>
                                                            <th>Product Name</th>
                                                            <th>Quantity</th>
                                                            <th>Size</th>
                                                            <th>Price</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        // Check if orders are fetched successfully
                                                        if ($userLoggedIn && isset($orders) && $orders !== null) {
                                                            // Iterate through each order and display its details
                                                            foreach ($orders as $order) {
                                                                echo "<tr>";
                                                                echo "<td>{$order['order_id']}</td>";
                                                                echo "<td>{$order['product_name']}</td>";
                                                                echo "<td>{$order['product_quantity']}</td>";
                                                                echo "<td>{$order['product_size']}</td>";
                                                                echo "<td>{$order['product_price']}</td>";
                                                                echo "</tr>";
                                                            }
                                                        } else {
                                                            // Handle case where no orders are found for the user
                                                            echo "<tr><td colspan='5'>No orders found.</td></tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="address-edit" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3 style="color: black !important;">Billing Address</h3>
                                            <?php if ($userLoggedIn) : ?>
                                                <?php if ($userAddress) : ?>
                                                    <!-- Display user's address -->
                                                    <address>
                                                        <p><strong><?php echo $userAddress['name']; ?></strong></p>
                                                        <p><?php echo $userAddress['address']; ?><br>
                                                            <?php echo $userAddress['city']; ?>, <?php echo $userAddress['zipcode']; ?></p>
                                                        <p>Mobile: <?php echo $userAddress['phone']; ?></p>
                                                    </address>
                                                <?php else : ?>
                                                    <!-- Display message when no address is found -->
                                                    <p>No address found.</p>
                                                <?php endif; ?>
                                                <!-- Edit Address Button -->
                                                <a href="#" class="btn flosun-button secondary-btn theme-color rounded-0" id="edit-address-btn"><i class="fa fa-edit mr-2"></i><?php echo isset($userAddress) ? 'Edit Address' : 'Add Address'; ?></a>
                                                <!-- Display edit form -->
                                                <!-- HTML for the address form -->
                                                <div id="edit-address-form" style="display: none;">
                                                    <br>
                                                    <h4>Update Address</h4>
                                                    <form action="update_address.php" method="POST" class="address-form">
                                                        <div class="form-group">
                                                            <label for="name">Full Name</label>
                                                            <!-- Pre-fill the full name input field with the user's name -->
                                                            <input type="text" id="name" name="name" placeholder="Enter your full name" value="<?php echo $name; ?>" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="address">Address</label>
                                                            <input type="text" id="address" name="address" placeholder="Enter your address" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="city">City</label>
                                                            <input type="text" id="city" name="city" placeholder="Enter your city" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="zipcode">Zipcode</label>
                                                            <input type="text" id="zipcode" name="zipcode" placeholder="Enter your zipcode" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="phone">Phone</label>
                                                            <input type="text" id="phone" name="phone" placeholder="Enter your phone number" required>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary">Save Address</button>
                                                    </form>
                                                </div>

                                            <?php else : ?>
                                                <!-- User not logged in -->
                                                <p>Please log in to view or edit your address.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>


                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="account-info" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3 style="color: black !important;">Account Details</h3>
                                            <div class="account-details-form">
                                                <form action="#">

                                                    <div class="single-input-item mb-3">
                                                        <label for="display-name" class="required mb-1">User Name</label>
                                                        <input type="text" id="display-name" placeholder="User Name" value="<?php echo isset($userDetails['name']) ? $userDetails['name'] : ''; ?>" readonly />
                                                    </div>

                                                    <div class="single-input-item mb-3">
                                                        <label for="email" class="required mb-1">Email Address</label>
                                                        <input type="email" id="email" placeholder="Email Address" value="<?php echo isset($userDetails['email']) ? $userDetails['email'] : ''; ?>" readonly />
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div> <!-- Single Tab Content End -->
                                </div>
                            </div> <!-- My Account Tab Content End -->
                        </div>
                    </div> <!-- My Account Page End -->
                </div>
            </div>
        </div>
    </div>
    <!-- my account wrapper end -->
    <!-- Brand Logo Area End Here -->
    <br>
    <br>
    <br>
    <!--Footer Area Start-->
    <footer class="footer-area">
        <div class="footer-copyright-area1">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12 col-custom">
                        <div class="section-title2 text-left mb-30" id="contact-us">
                            <p class="section-title-2">Contact Us</p>
                        </div>
                    </div>
                    <div class="col-lg-6 d-none d-lg-flex justify-content-center col-custom">
                        <!-- This column is empty and will only appear on larger screens to adjust the layout -->
                    </div>
                    <div class="col-lg-3 col-md-6 col-12 col-custom">
                        <div class="footer-contact-info">
                            <ul>
                                <li>
                                    <i class="fa fa-envelope"></i>
                                    <a href="mailto:classiccreation@gmail.com">classiccreation@gmail.com</a>
                                </li>
                            </ul>
                        </div>

                        <div class="footer-social-info">
                            <ul>
                                <li>
                                    <div class="widget-social">
                                        <a class="instagram-color-bg fab fa-instagram" title="Instagram" href="https://www.instagram.com/classiccreation_/"></a>
                                        <a href="https://www.instagram.com/classiccreation_/">classiccreation_
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <footer class="footer-area">
        <div class="footer-copyright-area">
            <div class="container custom-area">
                <div class="row">
                    <div class="col-12 text-center col-custom">
                        <div class="copyright-content">
                            <b>
                                <p>Copyright © 2023 <a href="https://www.instagram.com/classiccreation_/" title="Instagram">ClassicCreation</a></p>
                            </b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--Footer Area End-->


    <!-- JS
============================================ -->


    <!-- jQuery JS -->
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <!-- jQuery Migrate JS -->
    <script src="assets/js/vendor/jquery-migrate-3.3.2.min.js"></script>
    <!-- Modernizer JS -->
    <script src="assets/js/vendor/modernizr-3.7.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="assets/js/vendor/bootstrap.bundle.min.js"></script>


    <!-- Swiper Slider JS -->
    <script src="assets/js/plugins/swiper-bundle.min.js"></script>
    <!-- nice select JS -->
    <script src="assets/js/plugins/nice-select.min.js"></script>
    <!-- Ajaxchimpt js -->
    <script src="assets/js/plugins/jquery.ajaxchimp.min.js"></script>
    <!-- Jquery Ui js -->
    <script src="assets/js/plugins/jquery-ui.min.js"></script>
    <!-- Jquery Countdown js -->
    <script src="assets/js/plugins/jquery.countdown.min.js"></script>
    <!-- jquery magnific popup js -->
    <script src="assets/js/plugins/jquery.magnific-popup.min.js"></script>

    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

    <script>
        // JavaScript code to handle the animation
        document.getElementById('edit-address-btn').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default behavior of the anchor tag

            var addressForm = document.getElementById('edit-address-form');
            if (addressForm.style.display === 'none' || addressForm.style.display === '') {
                slideDown(addressForm); // Apply sliding animation
            } else {
                slideUp(addressForm); // Apply sliding animation
            }
        });

        // Function to apply sliding down animation
        function slideDown(element) {
            var height = 0;
            var interval = setInterval(function() {
                if (height >= 550) { // Adjust 200 to the desired height of the form
                    clearInterval(interval);
                } else {
                    height += 10; // Adjust the sliding speed by changing this value
                    element.style.height = height + 'px';
                }
            }, 10); // Adjust the interval for smoother or faster animation
            element.style.display = 'block';
        }

        // Function to apply sliding up animation
        function slideUp(element) {
            var height = 200; // Adjust 200 to the desired height of the form
            var interval = setInterval(function() {
                if (height <= 0) {
                    clearInterval(interval);
                    element.style.display = 'none';
                } else {
                    height -= 10; // Adjust the sliding speed by changing this value
                    element.style.height = height + 'px';
                }
            }, 10); // Adjust the interval for smoother or faster animation
        }
    </script>


</body>

</html>