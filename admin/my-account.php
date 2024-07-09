<?php
session_start();

// Database configuration
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'ccwebsite';

// Create database connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    // Retrieve form data
    $productName = $_POST['productName'];
    $productImage = $_FILES['productImage']['name'];

    // Default values for size and price based on your requirements
    $defaultSizes = ['6x8', '9x12', '12x16'];
    $defaultPrices = [550, 700, 850];

    // File upload path
    $target_path = "uploads/" . basename($productImage);

    // Move uploaded file to destination
    if (move_uploaded_file($_FILES['productImage']['tmp_name'], $target_path)) {
    } else {
    }

    // Check if the product name is not empty
    if (!empty($productName)) {
        // Check if the product already exists in the database
        $existingProductQuery = "SELECT * FROM products WHERE productName = '$productName'";
        $existingProductResult = $conn->query($existingProductQuery);

        if ($existingProductResult->num_rows > 0) {
            echo "Product already exists in the database.";
        } else {
            // Insert product data into database with default size and price
            for ($i = 0; $i < count($defaultSizes); $i++) {
                $size = $defaultSizes[$i];
                $price = $defaultPrices[$i];

                // Check if size and price are not empty or equal to zero
                if (!empty($size) && $price > 0) {
                    $query = "INSERT INTO products (productName, productImage, size, price) VALUES ('$productName', '$productImage', '$size', '$price')";
                    $result = $conn->query($query);

                    if ($result) {
                        echo "Product added to the database successfully!";
                    } else {
                        echo "Error adding product to the database: " . $conn->error;
                    }
                }
            }
        }
    } else {
        echo "Product name cannot be empty.";
    }
}

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

        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ddd;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <!-- Breadcrumb Area Start Here -->
    <div class="breadcrumbs-area position-relative">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="breadcrumb-content position-relative section-content">
                        <h3 class="title-3">Admin Panel</h3>
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
                                        Manange User</a>
                                    <a href="#orders" data-bs-toggle="tab"><i class="fa fa-cart-arrow-down"></i>
                                        Manage Orders</a>
                                    <a href="#address-edit" data-bs-toggle="tab"><i class="fa fa-map-marker"></i>
                                        Manage Products</a>
                                    <a href="#account-info" data-bs-toggle="tab"><i class="fa fa-user"></i>
                                        Insert Products</a>
                                </div>
                            </div>
                            <!-- My Account Tab Menu End -->

                            <!-- My Account Tab Content Start -->
                            <div class="col-lg-9 col-md-8 col-custom">
                                <div class="tab-content" id="myaccountContent">
                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade show active" id="dashboad" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3 style="color: black !important;">Users</h3>
                                            <div class="dashboard-container">

                                                <?php
                                                // Fetch and display user information
                                                $query = "SELECT * FROM users";
                                                $result = $conn->query($query);

                                                // Check if there are users
                                                if ($result->num_rows > 0) {
                                                    echo "<table border='1'>";
                                                    echo "<tr><th>User ID</th><th>Username</th><th>Email</th></tr>";

                                                    // Output data of each row
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<tr><td>" . $row["id"] . "</td><td>" . $row["name"] . "</td><td>" . $row["email"] . "</td></tr>";
                                                    }

                                                    echo "</table>";
                                                } else {
                                                    echo "No users found";
                                                }
                                                ?>
                                                <br>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade" id="orders" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3 style="color: black !important;">Manage Orders</h3>
                                            <div class="myaccount-table table-responsive text-center">
                                                <table class="table table-bordered">
                                                    <thead class="thead-light">
                                                        <tr>
                                                            <th>User Name</th>
                                                            <th>User Email</th>
                                                            <th>Order ID</th>
                                                            <th>Product Name</th>
                                                            <th>Quantity</th>
                                                            <th>Size</th>
                                                            <th>Price</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        // Fetch orders from the database
                                                        $query = "SELECT * FROM orders";
                                                        $result = $conn->query($query);

                                                        // Check if orders are fetched successfully
                                                        if ($result->num_rows > 0) {
                                                            // Iterate through each order and display its details
                                                            while ($row = $result->fetch_assoc()) {
                                                                echo "<tr>";
                                                                echo "<td>{$row['user_name']}</td>";
                                                                echo "<td>{$row['user_email']}</td>"; // Assuming there is a 'user_id' field in the orders table
                                                                echo "<td>{$row['order_id']}</td>";
                                                                echo "<td>{$row['product_name']}</td>";
                                                                echo "<td>{$row['product_quantity']}</td>";
                                                                echo "<td>{$row['product_size']}</td>";
                                                                echo "<td>{$row['product_price']}</td>";
                                                                echo "</tr>";
                                                            }
                                                        } else {
                                                            // Handle case where no orders are found
                                                            echo "<tr><td colspan='6'>No orders found.</td></tr>";
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
                                            <h3 style="color: black !important;">Manage Products</h3>
                                            <div class="dashboard-container" style="height: 400px; overflow: auto;">
                                                <?php
                                                // Fetch product data from the database
                                                $query = "SELECT * FROM products";
                                                $result = $conn->query($query);

                                                // Check if products are fetched successfully and if there are rows
                                                if ($result && $result->num_rows > 0) {
                                                    // Display the table headers
                                                    echo "<table border='1'>";
                                                    echo "<tr><th>Product ID</th><th>Product Image</th><th>Product Name</th><th>Size</th><th>Price</th></tr>";

                                                    // Iterate through each product and display its details
                                                    while ($row = $result->fetch_assoc()) {
                                                        // Check if the necessary keys exist in the row
                                                        if (isset($row['product_id'], $row['productName'], $row['size'], $row['price'], $row['productImage'])) {
                                                            echo "<tr>";
                                                            echo "<td>{$row['product_id']}</td>";
                                                            echo "<td><img src='uploads/{$row['productImage']}' alt='Product Image' style='width: 100px; height: auto;'></td>";
                                                            echo "<td>{$row['productName']}</td>";
                                                            echo "<td>{$row['size']}</td>";
                                                            echo "<td>{$row['price']}</td>";
                                                            echo "</tr>";
                                                        } else {
                                                            echo "<tr><td colspan='5'>Incomplete data for this product.</td></tr>";
                                                        }
                                                    }

                                                    echo "</table>";
                                                } else {
                                                    // Handle case where no products are found or there's an error with the query
                                                    echo "No products found";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Single Tab Content End -->

                                    <div class="tab-pane fade" id="account-info" role="tabpanel">
                                        <div class="myaccount-content">
                                            <h3 style="color: black !important;">Manage Products</h3>
                                            <div class="dashboard-container">
                                                <form method="post" enctype="multipart/form-data">
                                                    <!-- Add content specific to inserting a product here -->
                                                    <label for="productName">Product Name:</label>
                                                    <input type="text" name="productName" required>

                                                    <label for="productImage">Product Image:</label>
                                                    <input type="file" name="productImage" required>
                                                    <br><br><br><br><br>
                                                    <button type="submit" name="submit">Submit</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- My Account Tab Content End -->
                        </div>
                    </div> <!-- My Account Page End -->
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

</body>

</html>