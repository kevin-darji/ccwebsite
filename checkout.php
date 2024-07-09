<?php

session_start();

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

// Retrieve the raw POST data
$jsonData = file_get_contents('php://input');

// Decode the JSON data
$orderDetails = json_decode($jsonData, true);

// Generate a unique order ID
$order_id = uniqid('ORDER');

// Retrieve user details from the session or request data
$userName = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : '';

// Insert order details into the database
$sql = "INSERT INTO orders (payment_id, order_id, user_name, user_email, total_amount, product_name, product_quantity, product_price, product_size) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Check if the prepare statement succeeded
if ($stmt === false) {
    die('Error preparing the statement.');
}

if (!empty($orderDetails['products']) && is_array($orderDetails['products'])) {
    // Iterate over each product
    foreach ($orderDetails['products'] as $product) {
        // Bind parameters for each product
        $paymentId = !empty($orderDetails['paymentId']) ? $orderDetails['paymentId'] : '';
        $totalAmount = !empty($orderDetails['totalAmount']) ? $orderDetails['totalAmount'] : '';
        $productName = !empty($product['name']) ? $product['name'] : '';
        $quantity = !empty($product['quantity']) ? $product['quantity'] : '';
        $price = !empty($product['price']) ? $product['price'] : '';
        $productSize = !empty($product['size']) ? $product['size'] : ''; // Assuming the size is provided in the product array

        $stmt->bind_param("ssssdssss", $paymentId, $order_id, $userName, $userEmail, $totalAmount, $productName, $quantity, $price, $productSize);
        $stmt->execute();
    }
}

// Close connections
$stmt->close();
$conn->close();

// Function to fetch user details based on user ID
function getUserDetails($userId)
{
    global $conn;

    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bind_param("d", $userId);
    $stmt->execute();

    // Fetch the result
    $result = $stmt->get_result();
    $userDetails = $result->fetch_assoc();

    // Close the statement
    $stmt->close();

    return $userDetails;
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" type="text/css" href="assets/css/custom-icons.css">

    <!-- Razorpay script -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <style>
        /* Add styling for the two-column layout */
        .order-container {
            display: flex;
            background-color: #f5f5f5;
            /* Set your preferred background color */
        }

        .left,
        .right {
            flex: 1;
            padding: 20px;
        }

        #order-summary-container,
        #order-calculation-container {
            margin-top: 20px;
            /* Adjust the value as needed */
        }

        .order-summary,
        .order-calculation {
            background-color: #fff;
            /* Set your preferred background color */
            border: 1px solid #ddd;
            /* Add border for better separation */
            border-radius: 5px;
            /* Optional: Add border-radius for rounded corners */
            margin: 41px;
            /* Adjust the margin as needed */
        }

        .order-summary {
            flex: 1;
            padding-right: 20px;
            /* Adjust spacing between columns */
        }

        .order-calculation {
            flex: 1;
            padding-left: 20px;
            /* Adjust spacing between columns */
        }

        /* Additional styles for table formatting */
        .your-order-table {
            width: 100%;
        }

        .your-order-table th,
        .your-order-table td {
            padding: 8px;
            text-align: center;
        }

        .order-calculation-table {
            width: 100%;
        }

        .order-calculation-table td {
            padding: 8px;
            text-align: left;
        }

        .order-calculation-table th {
            border-top: 5px solid #000000;
            border-bottom: 5px solid #000000;
            font-size: 20px;
            padding: 15px 0;
            font-weight: 600;
        }

        .order-calculation-table tbody tr {
            font-size: 14px;
        }

        .order-calculation-table tfoot tr {
            border-top: 5px solid #000000;
            border-bottom: 5px solid #000000;
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
                        <h3 class="title-3">Checkout</h3>
                        <ul>
                            <li>Cart</li>
                            <li>Checkout</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Container for Two-Column Layout -->
    <div class="order-container">
        <!-- Left side: Product Details -->
        <div class="order-summary left" id="order-summary-container">
            <!-- JavaScript will dynamically populate this container -->
        </div>

        <!-- Right side: Order Summary -->
        <div class="order-calculation right" id="order-calculation-container">

            <!-- JavaScript will dynamically populate this container -->
        </div>

    </div>

    <!-- Brand Logo Area End Here -->
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
    <div class="clear"></div>
    <script>
        // Function to retrieve cart data from localStorage
        function getCartData() {
            var cartData = localStorage.getItem('cartData');
            return cartData ? JSON.parse(cartData) : [];
        }

        // Function to calculate the sub-total, delivery charges, and total
        function calculateOrderSummary() {
            var cartData = getCartData();
            var subTotal = 0;

            // Create an array to store detailed product information
            var productDetails = [];

            // Iterate through cart items and calculate sub-total
            cartData.forEach(function(item) {
                subTotal += item.price * item.quantity;

                // Add detailed product information to the productDetails array
                productDetails.push({
                    name: item.name,
                    quantity: item.quantity,
                    size: item.size,
                    price: item.price,
                    total: (item.price * item.quantity).toFixed(2),
                });
            });

            // Example delivery charges
            var deliveryCharges = 100.00;

            // Calculate total
            var total = subTotal + deliveryCharges;

            // Display order summary
            var orderSummaryContainer = document.getElementById('order-summary-container');
            orderSummaryContainer.innerHTML = `
    <h1 align="center">Summary Of Order</h1>
        <div class="your-order">
            <div class="your-order-table table-responsive">
                <table class="table your-order-table">
                    <thead>
                        <tr>
                            <th class="cart-product-name">Product</th>
                            <th class="cart-product-size">Size</th>
                            <th class="cart-product-quantity">Quantity</th>
                            <th class="cart-product-price">Price</th>
                            <th class="cart-product-total">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${productDetails.map(product => `
                            <tr class="cart_item">
                                <td class="cart-product-name">${product.name}</td>
                                <td class="cart-product-size">${product.size}</td>
                                <td class="cart-product-quantity">${product.quantity}</td>
                                <td class="cart-product-price">₹${product.price.toFixed(2)}</td>
                                <td class="cart-product-total text-center">₹${product.total}</td>
                            </tr>
                        `).join('')}
                        
                    </tbody>
                    <tfoot>
    <tr class="cart-subtotal">
        <th col-md-6">Cart Subtotal</th>
        <th col-md-6"></th>
        <th col-md-6"></th>
        <th col-md-6"></th>
        <th>  
                <span class="amount">₹${subTotal.toFixed(2)}</span>
        </th>
    </tr>
</tfoot>
                </table>
            </div>
            <a href="cart.php" class="btn flosun-button primary-btn rounded-0 black-btn w-100">Update Cart</a> 
        </div>
    `;
        }

        // Function to calculate and display order calculation
        function displayOrderCalculation() {
            var cartData = getCartData();
            var subTotal = 0;

            // Iterate through cart items and calculate sub-total
            cartData.forEach(function(item) {
                subTotal += item.price * item.quantity;
            });

            // Example delivery charges
            var deliveryCharges = 100.00;

            // Calculate total
            var total = subTotal + deliveryCharges;

            // Display order calculation
            var orderCalculationContainer = document.getElementById('order-calculation-container');
            orderCalculationContainer.innerHTML = `
            <h1 align="center">Order Calculation</h1>
            <div class="your-order">
                <div class="order-calculation-table table-responsive">
                    <table class="table">
            <thead>
                <tr>
                    <th class="cart-product-name">Item</th>
                    <th class="cart-product-total">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Sub-Total:</td>
                    <td>₹${subTotal.toFixed(2)}</td>
                </tr>
                <tr>
                    <td>Delivery Charges:</td>
                    <td>₹${deliveryCharges.toFixed(2)}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td>Total:</td>
                    <td>₹${total.toFixed(2)}</td>
                </tr>
                </tfoot>
        </table>

    </div>
    <a href="#" class="btn flosun-button primary-btn rounded-0 black-btn w-100"
            onclick="initiateRazorpayPayment()">Proceed To Checkout</a>    
    </div>
`;
            // Assign total to a global variable
            window.totalAmountForRazorpay = total;
        }

        function initiateRazorpayPayment(totalAmount) {
            // Use the total amount when initializing Razorpay
            var options = {
                key: 'rzp_test_CDmgu0gG2r0TZJ',
                amount: window.totalAmountForRazorpay * 100, // Amount in paise
                currency: 'INR',
                name: 'Classic Creation',
                description: 'Payment for your order',
                image: 'logo.png',
                handler: function(response) {
                    // Handle the response
                    console.log('Payment ID:', response.razorpay_payment_id);
                    console.log('Order ID:', response.razorpay_order_id);
                    console.log('Signature:', response.razorpay_signature);
                    console.log('Payment Method:', response.method);

                    var orderDetails = {
                        paymentId: response.razorpay_payment_id,
                        orderId: response.razorpay_order_id,
                        signature: response.razorpay_signature,
                        totalAmount: window.totalAmountForRazorpay,
                        products: getCartData() // Include the product details from the cart
                    };

                    // Send the order details to the server using AJAX
                    fetch('checkout.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify(orderDetails),
                        })
                        .then(response => response.text())
                        .then(data => {
                            console.log('Response from server:', data);
                            // Handle the response from the server as needed
                            // For example, you can redirect to a success page
                            window.location.href = 'success.php?orderId=' + response.razorpay_order_id;
                        })
                        .catch(error => {
                            console.error('Error saving order to server:', error);
                        });
                },
            };

            var rzp = new Razorpay(options);
            rzp.open();
        }

        // Call the functions when the page loads
        window.addEventListener('DOMContentLoaded', function() {
            calculateOrderSummary();
            displayOrderCalculation();
        });
    </script>


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