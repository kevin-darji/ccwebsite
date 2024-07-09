<?php
session_start();

// Check if the user is logged in
$userLoggedIn = isset($_SESSION['name']);
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

    <style>
        /* Add some basic styles to center the modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fefefe;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 400px;
            /* Set a maximum width if needed */
        }

        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            position: absolute;
            top: -5px;
            right: 10px;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }

        .cart-update {
            margin-right: 10px;
            /* Adjust the spacing as needed */
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
                        <h3 class="title-3">Shopping Cart</h3>
                        <ul>
                            <li>Home</li>
                            <li>Shopping Cart</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cart-main-wrapper mt-no-text">
        <div class="container custom-area">
            <div class="row">
                <div class="col-lg-12 col-custom">
                    <div id="cart-details-container">
                        <!-- Cart items will be displayed here -->
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="cart-update mt-sm-16">
                                <a href="home.php" class="btn flosun-button primary-btn rounded-0 black-btn">Browse More</a>
                            </div>
                        </div>
                        <div class="col-sm-6 d-flex justify-content-end">
                            <div class="cart-update mt-sm-16">
                                <a href="checkout.php" class="btn flosun-button primary-btn rounded-0 black-btn">Checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add a modal HTML structure at the end of your HTML body -->
    <div id="emptyCartModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEmptyCartModal()">&times;</span>
            <p>Your cart is empty. Please add items before proceeding to checkout.</p>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>

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

    <!-- This is in cart.html -->
    <script>
        // Function to retrieve cart data from localStorage
        function getCartData() {
            var cartData = localStorage.getItem('cartData');
            return cartData ? JSON.parse(cartData) : [];
        }

        // Function to display cart details on cart.html
        function displayCartDetails() {
            var cartData = getCartData();
            var cartDetailsContainer = document.getElementById('cart-details-container');

            // Clear any existing content
            cartDetailsContainer.innerHTML = '';

            var table = document.createElement('table');
            table.classList.add('cart-table');
            table.style.width = '100%';

            // Create table header
            var thead = document.createElement('thead');
            var headerRow = document.createElement('tr');
            headerRow.innerHTML = `
    <th style="text-align: center;">Image</th>
    <th style="text-align: center;">Product Name</th>
    <th style="text-align: center;">Quantity</th>
    <th style="text-align: center;">Size</th>
    <th style="text-align: center;">Price</th>
    <th style="text-align: center;">Remove</th>
`;
            thead.appendChild(headerRow);
            table.appendChild(thead);

            if (cartData.length === 0) {
                // If no products are added, display a message
                var tbody = document.createElement('tbody');
                var emptyRow = document.createElement('tr');
                emptyRow.innerHTML = '<td colspan="6" style="text-align: center;">Your cart is empty</td>';
                tbody.appendChild(emptyRow);
                table.appendChild(tbody);
            } else {
                // Example delivery charges
                var deliveryCharges = 100.00;

                // Calculate sub-total
                var subTotal = 0;
                cartData.forEach(function(item) {
                    subTotal += item.price * item.quantity;
                });

                // Create table body
                var tbody = document.createElement('tbody');
                var total = 0;

                cartData.forEach(function(item, index) {
                    var row = document.createElement('tr');
                    row.innerHTML = `
            <td><img class="cart-image" src="${item.image}" alt="${item.name}" width="50"></td>
            <td>${item.name}</td>
            <td>${item.quantity}</td>
            <td>${item.size}</td>
            <td>₹${(item.price * item.quantity).toFixed(2)}</td>
            <td>
                <div class="remove-button">
                    <button class="remove-from-cart" data-index="${index}">
                        <i class="lnr lnr-trash"></i>
                    </button>
                </div>
            </td>
        `;

                    total += item.price * item.quantity;
                    tbody.appendChild(row);
                });

                // Add delivery charges to get the total
                var total = subTotal + deliveryCharges;

                table.appendChild(tbody);
            }

            cartDetailsContainer.appendChild(table);

            // Display sub-total
            var subTotalElement = document.getElementById('sub-total');
            subTotalElement.textContent = subTotal.toFixed(2);

            // Display total
            var cartTotalElement = document.getElementById('cart-total');
            cartTotalElement.textContent = total.toFixed(2);
        }

        // Display cart items when cart.html loads
        window.addEventListener('DOMContentLoaded', function() {
            displayCartDetails();
        });

        // Define the removeFromCart function
        function removeFromCart(index) {
            var cartData = getCartData();
            cartData.splice(index, 1);
            localStorage.setItem('cartData', JSON.stringify(cartData));
            displayCartDetails();
        }

        // Event delegation: Listen for "click" events on the common ancestor of product elements.
        document.addEventListener('click', function(event) {
            var target = event.target;

            // Handle clicks on the trash can icon within the "Remove from Cart" button.
            if (target.classList.contains('lnr-trash')) {
                var button = target.closest('.remove-from-cart');
                if (button) {
                    var index = parseInt(button.getAttribute('data-index'), 10);
                    if (!isNaN(index)) {
                        removeFromCart(index);
                    }
                }
            }
        });
    </script>
    <script>
        function proceedToCheckout() {
            // Perform a check to see if the cart is empty
            if (isCartEmpty()) {
                // Show the empty cart modal
                openEmptyCartModal();
            } else {
                // Redirect to checkout.php if the cart is not empty
                window.location.href = "checkout.php";
            }
        }

        function isCartEmpty() {
            // Implement your logic to check if the cart is empty
            var cartData = getCartData();
            return cartData.length === 0;
        }

        function openEmptyCartModal() {
            var modal = document.getElementById('emptyCartModal');
            modal.style.display = 'block';
        }

        function closeEmptyCartModal() {
            var modal = document.getElementById('emptyCartModal');
            modal.style.display = 'none';
        }

        // Close the modal if the user clicks outside of it
        window.onclick = function(event) {
            var modal = document.getElementById('emptyCartModal');
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        };
    </script>
    <script>
        function buildCartQuery() {
            var cartData = getCartData();

            // If the cart is not empty, build the query parameters
            if (cartData.length > 0) {
                var query = "amount=" + calculateTotalAmount(cartData);

                // You can add more details to the query if needed, such as product IDs, quantities, etc.

                return query;
            }

            // If the cart is empty, return an empty string or handle it according to your needs
            return "";
        }

        // Function to calculate the total amount based on cart data
        function calculateTotalAmount(cartData) {
            var total = 0;

            cartData.forEach(function(item) {
                total += item.price * item.quantity;
            });

            // Example delivery charges
            var deliveryCharges = 100.00;

            // Add delivery charges to get the total
            total += deliveryCharges;

            return total.toFixed(2);
        }
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