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
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

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

    <!-- Other meta tags and stylesheets -->

    <!-- Meta tag for redirection -->
    <meta http-equiv="refresh" content="5;url=home.php">

    <style>
        .order-summary {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 5px;
            background-color: #fff;
        }

        .order-summary h3 {
            margin-top: 0;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .order-details {
            font-size: 16px;
        }

        .order-details strong {
            font-weight: bold;
        }

        .product-list {
            margin-top: 20px;
        }

        .product {
            margin-bottom: 10px;
        }

        .product-name {
            font-weight: bold;
        }

        .product-details {
            display: flex;
            justify-content: space-between;
        }

        .product-quantity,
        .product-price {
            font-size: 14px;
            color: #777;
        }

        .total-amount {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
        }

        .col-lg-6-1 {
            width: 78% !important;
        }

        .order-table {
            border-collapse: collapse;
            width: 100%;
        }

        .order-table th,
        .order-table td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        .order-table th {
            background-color: #f2f2f2;
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
                        <h3 class="title-3">Order</h3>
                        <ul>
                            <li>Payment</li>
                            <li>Order</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Area End Here -->
    <br>
    <!-- Checkout Area Start Here -->
    <div class="container custom-container">
        <div class="row">
            <div class="col-lg-6-1 col-12 col-custom">
                <div class="your-order">
                    <div class="order-summary">
                        <div class="order-details">
                            <div class="order-id">

                                <?php
                                // Database configuration
                                $host = 'localhost';
                                $dbUsername = 'root';
                                $dbPassword = '';
                                $dbName = 'ccwebsite';

                                // Create database connection
                                $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

                                // Check connection
                                if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                // Query to fetch the latest order ID and its details including user name and email
                                $sql_latest_order_details = "SELECT o.order_id, o.user_name, o.user_email, o.product_name, o.product_quantity, o.product_price, o.product_size
    FROM orders o
    WHERE o.order_id = (SELECT DISTINCT order_id FROM orders ORDER BY order_id DESC LIMIT 1)";

                                $result_latest_order_details = $conn->query($sql_latest_order_details);

                                // Check if the latest order details are found
                                if ($result_latest_order_details->num_rows > 0) {
                                    $row = $result_latest_order_details->fetch_assoc();

                                    // Initialize variables to keep track of total amount for the latest order
                                    $totalAmount = 0;

                                    // Start container for order details table
                                    echo '<div class="order-details">';
                                    echo '<div class="order">';
                                    echo '<h3>Order Summary</h3>';
                                    echo '<table>';
                                    echo '<tr>';
                                    echo '<th style="border-color: inherit; border-style: solid; border-width: 0; border-bottom: 1px solid #000000;">Sr No.</th>';
                                    echo '<th style="border-color: inherit; border-style: solid; border-width: 0; border-bottom: 1px solid #000000;">Product Name</th>';
                                    echo '<th style="border-color: inherit; border-style: solid; border-width: 0; border-bottom: 1px solid #000000;">Product Size</th>';
                                    echo '<th style="border-color: inherit; border-style: solid; border-width: 0; border-bottom: 1px solid #000000;">Product Quantity</th>';
                                    echo '<th style="border-color: inherit; border-style: solid; border-width: 0; border-bottom: 1px solid #000000;">Product Price</th>';
                                    echo '</tr>';

                                    // Process each order detail
                                    $count = 1;
                                    do {
                                        echo '<tr>';
                                        echo '<td>' . $count . '.</td>';
                                        echo '<td>' . $row['product_name'] . '</td>';
                                        echo '<td>' . $row['product_size'] . '</td>';
                                        echo '<td>' . $row['product_quantity'] . '</td>';
                                        echo '<td>₹' . $row['product_price'] . '</td>';
                                        echo '</tr>';

                                        // Calculate total amount for the latest order
                                        $productTotal = $row['product_quantity'] * $row['product_price'];
                                        $totalAmount += $productTotal;

                                        $count++;
                                    } while ($row = $result_latest_order_details->fetch_assoc());

                                    // Display total amount for the latest order
                                    echo '<tr>';
                                    echo '<td colspan="4" style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;"><strong>Total Amount:</strong></td>';
                                    echo '<td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000;"><strong>₹' . number_format($totalAmount, 2) . '</strong></td>';
                                    echo '</tr>';
                                    echo '</table>';

                                    // End container for order details table
                                    echo '</div>';
                                    echo '</div>';
                                } else {
                                    // Display message if no latest order details are found
                                    echo "<p>No latest order details found.</p>";
                                }

                                // Close database connection
                                $conn->close();
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

    <!-- Checkout Area End Here -->
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
                                        <a class="instagram-color-bg fa fa-instagram" title="Instagram" href="https://www.instagram.com/classiccreation_/"></a>
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