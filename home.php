<?php
session_start();

// Check if the user is logged in
$userLoggedIn = isset($_SESSION['name']);

// Check if the user is not logged in
if (!isset($_SESSION['name'])) {
    // Redirect the user to the login page
    header("Location: login.php");
    exit(); // Make sure to exit after redirection
}

// Check if there's a product to be added to the cart after login
if (isset($_SESSION['productToAdd'])) {
    // Retrieve the product information
    $productId = $_SESSION['productToAdd'];

    // Add the product to the cart using your existing logic
    // ...

    // Clear the stored product information
    unset($_SESSION['productToAdd']);
}

// Function to get the user's name and email if logged in
function getUserDetails()
{
    $userDetails = array();
    if (isset($_SESSION['name']) && isset($_SESSION['email'])) {
        $userDetails['name'] = $_SESSION['name'];
        $userDetails['email'] = $_SESSION['email'];
    }
    return $userDetails;
}

// Check if the user is logged in and get user details
$userDetails = getUserDetails();

if (isset($_GET['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the home page or any other page after logout
    header("Location: home.php");
    exit();
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <link rel="stylesheet" type="text/css" href="assets/css/custom-icons.css">

    <style>

    </style>

</head>

<body>
    <!-- Header Area Start Here -->
    <header class="main-header-area">
        <!-- Main Header Area Start -->
        <div class="main-header header-transparent header-sticky">
            <div class="container-fluid">
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
                                    <a class="active" href="#">
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
                                    </ul>
                                </li>
                            </ul>
                            <ul class="nav">
                                <li class="minicart-wrap">
                                    <a href="#" class="minicart-btn toolbar-btn" id="viewCartBtn">
                                        <i class="fa fa-shopping-cart"></i>
                                        <span class="cart-item_count" id="cart-item-count">0</span>
                                    </a>
                                    <div class="cart-item-wrapper dropdown-sidemenu dropdown-hover-2 ">
                                        <h4 class="cart-header">Shopping Cart</h4>
                                        <hr>
                                        <p id="cart-empty-message">Your cart is empty.</p>
                                        <div id="cart-items-row" id="cart-row">
                                            <!-- Cart items will be displayed here -->

                                        </div>
                                        <ion-icon name="trash"></ion-icon>
                                        <div class="cart-price-total d-flex justify-content-between" id="cart-total-amount">
                                            <h4>Total:</h4>
                                            <h4><span class="inr-sign">0.00</span></h4>
                                        </div>
                                        <div class="cart-links d-flex justify-content-between">
                                            <a class="btn product-cart button-icon flosun-button dark-btn" href="cart.php">View cart</a>
                                        </div>
                                    </div>
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
    
    
    <!-- Slider/Intro Section Start -->
    <div class="intro11-slider-wrap section">
        <div class="intro11-slider swiper-container">
            <div class="swiper-wrapper">
                <div class="intro11-section swiper-slide slide-1 slide-bg-1 bg-position">
                    <!-- Intro Content Start -->
                    <div class="intro11-content text-left">
                        <h3 class="title">Welcome to Classic Creation</h3>
                        <h5>This small business is all about glass paintings.<h5>
                                <p>Your ideas and our skills will meet here.</p>
                                <p>Will take any kind of ideas for painting i.e.</p>
                                <p>1. Illustration of photos.</p>
                                <p>2. Amine painting.</p>
                                <p>3. Any cartoon character.</p>
                                <p>4. Any pinterest pictures.</p>
                                <p class="desc-content1"></p>
                                <div style="text-align: right;">
                                    <a href="#product" class="btn flosun-button secondary-btn theme-color  rounded-0">Shop Now</a>
                                </div>
                    </div>
                    <!-- Intro Content End -->
                </div>
            </div>
            <!-- Slider pagination -->
        </div>
    </div>
    <!-- Slider/Intro Section End -->
    <!--Product Area Start-->
    <div class="product-area mt-text-2" id="product">
        <div class="container custom-area-2 overflow-hidden">
            <div class="row">
                <!--Section Title Start-->
                <div class="col-12 col-custom">
                    <div class="section-title text-center mb-30">
                        <h3 class="section-title-1">Products</h3>
                    </div>
                </div>
                <!--Section Title End-->
            </div>
            <div class="row product-row">
                <div class="col-12 col-custom">
                    <div class="product-slider swiper-container anime-element-multi">
                        <div class="swiper-wrapper">
                            <div class="single-item swiper-slide">
                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model1" data-bs-toggle="modal" data-bs-target="#model1">
                                            <img src="assets/newimages/product1.jpg" alt="1" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"><b>Radha Krishna</b></h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>
                                    </div>
                                </div>

                                <!--Single Product End-->
                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model2" data-bs-toggle="modal" data-bs-target="#model2">
                                            <img src="assets/newimages/product2.jpg" alt="2" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"><b>Candid Photo</b></h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>
                                    </div>
                                </div>
                                <!--Single Product End-->

                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model3" data-bs-toggle="modal" data-bs-target="#model3">
                                            <img src="assets/newimages/product3.jpg" alt="3" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"><b>Anime Drawing
                                                    Painting</b></h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>
                                    </div>
                                </div>
                                <!--Single Product End-->
                            </div>
                            <div class="single-item swiper-slide">
                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model4" data-bs-toggle="modal" data-bs-target="#model4">
                                            <img src="assets/newimages/product4.jpg" alt="4" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">


                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"><b>Cartoon Drawing Painting</b></h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>
                                    </div>
                                </div>
                                <!--Single Product End-->
                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model5" data-bs-toggle="modal" data-bs-target="#model5">
                                            <img src="assets/newimages/product5.jpg" alt="5" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">


                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"> <b>Ganapti Painting</b>
                                            </h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>

                                    </div>
                                </div>
                                <!--Single Product End-->

                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model6" data-bs-toggle="modal" data-bs-target="#model6">
                                            <img src="assets/newimages/product6.jpg" alt="6" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">
                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"> <b>Group Photo Painting</b>
                                            </h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>

                                    </div>
                                </div>
                                <!--Single Product End-->
                            </div>
                            <div class="single-item swiper-slide">
                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model7" data-bs-toggle="modal" data-bs-target="#model7">
                                            <img src="assets/newimages/product7.jpg" alt="7" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">


                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"> <b>Bestie Photo
                                                    Painting</b>
                                            </h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>

                                    </div>
                                </div>
                                <!--Single Product End-->
                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model8" data-bs-toggle="modal" data-bs-target="#model8">
                                            <img src="assets/newimages/product8.jpg" alt="8" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">


                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"> <b>Candid Painting</b>
                                            </h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>
                                    </div>
                                </div>
                                <!--Single Product End-->
                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model9" data-bs-toggle="modal" data-bs-target="#model9">
                                            <img src="assets/newimages/product9.jpg" alt="9" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">


                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"> <b>BTS Painting</b></h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>
                                    </div>
                                </div>
                                <!--Single Product End-->
                            </div>
                            <div class="single-item swiper-slide">
                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model10" data-bs-toggle="modal" data-bs-target="#model10">
                                            <img src="assets/newimages/product10.jpg" alt="10" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">


                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"> <b>Anime Eye Painting</b>
                                            </h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>

                                    </div>
                                </div>
                                <!--Single Product End-->
                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model11" data-bs-toggle="modal" data-bs-target="#model11">
                                            <img src="assets/newimages/product11.jpg" alt="11" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">


                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"> <b>Lady In Pink</b>
                                            </h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>
                                    </div>
                                </div>
                                <!--Single Product End-->
                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model12" data-bs-toggle="modal" data-bs-target="#model12">
                                            <img src="assets/newimages/product12.jpg" alt="12" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">


                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"> <b>Royal Lion</b></h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>
                                    </div>
                                </div>
                                <!--Single Product End-->
                            </div>
                            <div class="single-item swiper-slide">
                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model13" data-bs-toggle="modal" data-bs-target="#model13">
                                            <img src="assets/newimages/product13.jpg" alt="13" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">


                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"> <b>Couple Painting</b>
                                            </h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>

                                    </div>
                                </div>
                                <!--Single Product End-->
                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model14" data-bs-toggle="modal" data-bs-target="#model14">
                                            <img src="assets/newimages/product14.jpg" alt="14" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">


                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"> <b>Friends Selfie</b></h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>

                                    </div>
                                </div>
                                <!--Single Product End-->
                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model15" data-bs-toggle="modal" data-bs-target="#model15">
                                            <img src="assets/newimages/product15.jpg" alt="15" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">


                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"> <b>Anime Painting</b></h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>

                                    </div>
                                </div>
                                <!--Single Product End-->
                            </div>
                            <div class="single-item swiper-slide">
                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model16" data-bs-toggle="modal" data-bs-target="#model16">
                                            <img src="assets/newimages/product16.jpg" alt="16" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">


                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"> <b>Anime Painting</b>
                                            </h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>

                                    </div>
                                </div>
                                <!--Single Product End-->
                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model17" data-bs-toggle="modal" data-bs-target="#model17">
                                            <img src="assets/newimages/product17.jpg" alt="17" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">


                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"> <b>Family Painting</b>
                                            </h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>
                                    </div>
                                </div>
                                <!--Single Product End-->
                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model18" data-bs-toggle="modal" data-bs-target="#model18">
                                            <img src="assets/newimages/product18.jpg" alt="18" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">


                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"> <b>Lady in Traditional</b>
                                            </h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>

                                    </div>
                                </div>
                                <!--Single Product End-->
                            </div>

                            <div class="single-item swiper-slide">
                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model19" data-bs-toggle="modal" data-bs-target="#model19">
                                            <img src="assets/newimages/product19.jpg" alt="19" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">


                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"> <b>Candid Painting</b></h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>
                                    </div>
                                </div>
                                <!--Single Product End-->
                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model20" data-bs-toggle="modal" data-bs-target="#model20">
                                            <img src="assets/newimages/product20.jpg" alt="20" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">


                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"> <b>Side Face Painting</b>
                                            </h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>

                                    </div>
                                </div>
                                <!--Single Product End-->

                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model21" data-bs-toggle="modal" data-bs-target="#model21">
                                            <img src="assets/newimages/product21.jpg" alt="21" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">


                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"> <b>Bestie's Painting</b>
                                            </h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>

                                    </div>
                                </div>
                                <!--Single Product End-->
                            </div>
                            <div class="single-item swiper-slide">
                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model22" data-bs-toggle="modal" data-bs-target="#model22">
                                            <img src="assets/newimages/product22.jpg" alt="22" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">


                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"> <b>Friendship Painting</b>
                                            </h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>

                                    </div>
                                </div>
                                <!--Single Product End-->
                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model23" data-bs-toggle="modal" data-bs-target="#model23">
                                            <img src="assets/newimages/product23.jpg" alt="23" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">


                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"> <b>Trip Memories</b></h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>

                                    </div>
                                </div>
                                <!--Single Product End-->

                                <!--Single Product Start-->
                                <div class="single-product position-relative mb-30">
                                    <div class="product-image">
                                        <a class="d-block" href="#model24" data-bs-toggle="modal" data-bs-target="#model24">
                                            <img src="assets/newimages/product24.jpg" alt="24" class="product-image-1 w-100">
                                        </a>
                                        <div class="add-action d-flex flex-column position-absolute">


                                        </div>
                                    </div>
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title-2"> <b>Selfie Painting</b></h4>
                                        </div>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                        <div class="product-price">
                                            <!-- Price in INR -->
                                            <span class="inr-sign">550.00 INR</span>
                                            <!-- You can customize this format as needed -->
                                        </div>

                                    </div>
                                </div>
                                <!--Single Product End-->
                            </div>
                        </div>
                        <!-- Slider pagination -->
                        <div class="swiper-pagination default-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Product Area End-->

    <!-- Testimonial Area Start Here -->
    <div class="testimonial-area mt-text-2">
        <div class="container custom-area">
            <div class="row">
                <!--Section Title Start-->
                <div class="col-12 col-custom">
                    <div class="section-title text-center">
                        <span class="section-title-1">We Love Our Clients</span><br>
                        <h3 class="section-title-3">What They’re Saying</h3>
                    </div>
                </div>
                <!--Section Title End-->
            </div>
            <div class="row">
                <div class="testimonial-carousel swiper-container intro11-carousel-wrap col-12 col-custom">
                    <div class="swiper-wrapper">
                        <div class="single-item swiper-slide">
                            <!--Single Testimonial Start-->
                            <section id="testimonials">
                                <!--heading--->
                                <!--testimonials-box-container------>
                                <div class="testimonial-box-container">
                                    <!--BOX-1-------------->
                                    <div class="testimonial-box">
                                        <!--top------------------------->
                                        <div class="box-top">
                                            <!--profile----->
                                            <div class="profile">
                                                <!--name-and-username-->
                                                <div class="name-user">
                                                    <strong>Afifah Shaikh</strong>
                                                </div>
                                            </div>
                                            <!--reviews------>
                                            <div class="reviews">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i><!--Empty star-->
                                            </div>
                                        </div>
                                        <!--Comments---------------------------------------->
                                        <div class="client-comment">
                                            <p>Heyyy

                                                I received my order

                                                It was fabulous

                                                Thank you so much

                                                My brother liked the gift so

                                                much

                                                Thank you ❤️</p>
                                        </div>
                                    </div>
                                </div>
                                <!--Single Testimonial End-->
                        </div>
                        <div class="single-item swiper-slide">
                            <!--Single Testimonial Start-->
                            <section id="testimonials">
                                <!--testimonials-box-container------>
                                <div class="testimonial-box-container">
                                    <!--BOX-1-------------->
                                    <div class="testimonial-box">
                                        <!--top------------------------->
                                        <div class="box-top">
                                            <!--profile----->
                                            <div class="profile">
                                                <!--name-and-username-->
                                                <div class="name-user">
                                                    <strong>Saakshi</strong>
                                                </div>
                                            </div>
                                            <!--reviews------>
                                            <div class="reviews">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-o"></i><!--Empty star-->
                                            </div>
                                        </div>
                                        <!--Comments---------------------------------------->
                                        <div class="client-comment">
                                            <p>Hey! Thank you so much for such a wonderful painting. I really loved
                                                it. And I really appreciate your hard work.
                                                The painting was so perfect! So clear, the lining of the painting
                                                the glass it was really excellent! I have decided that from next
                                                time onwards I will tell you only about paintings! Thank you for
                                                such a great work.</p>
                                        </div>
                                    </div>
                                </div>
                                <!--Single Testimonial End-->
                        </div>
                        <div class="single-item swiper-slide">
                            <!--Single Testimonial Start-->
                            <section id="testimonials">

                                <!--testimonials-box-container------>
                                <div class="testimonial-box-container">
                                    <!--BOX-1-------------->
                                    <div class="testimonial-box">
                                        <!--top------------------------->
                                        <div class="box-top">
                                            <!--profile----->
                                            <div class="profile">
                                                <!--name-and-username-->
                                                <div class="name-user">
                                                    <strong>Pratham Soni</strong>
                                                </div>
                                            </div>
                                            <!--reviews------>
                                            <div class="reviews">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-o"></i><!--Empty star-->
                                            </div>
                                        </div>
                                        <!--Comments---------------------------------------->
                                        <div class="client-comment">
                                            <p>Hello

                                                The painting was just like I really like that and it was amazing and
                                                the photo very amazing work done by classic creations first time I
                                                ordered from classic Creations and the experience was mind-blowing
                                                the painting was so professionally done it just blows my mind really
                                                appreciated and sure I'll always come for glass painting 2 classic
                                                creations only</p>
                                        </div>
                                    </div>
                                </div>
                                <!--Single Testimonial End-->
                        </div>
                        <div class="single-item swiper-slide">
                            <!--Single Testimonial Start-->
                            <section id="testimonials">

                                <!--testimonials-box-container------>
                                <div class="testimonial-box-container">
                                    <!--BOX-1-------------->
                                    <div class="testimonial-box">
                                        <!--top------------------------->
                                        <div class="box-top">
                                            <!--profile----->
                                            <div class="profile">
                                                <!--name-and-username-->
                                                <div class="name-user">
                                                    <strong>Ankita Mishra</strong>
                                                </div>
                                            </div>
                                            <!--reviews------>
                                            <div class="reviews">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star-o"></i><!--Empty star-->
                                            </div>
                                        </div>
                                        <!--Comments---------------------------------------->
                                        <div class="client-comment">
                                            <p>Heyy, as I received my painting I was completely shocked with the
                                                deatiles, final touch and the contrast of all the colors it was
                                                soooo beautiful n unique I wanted to gift it to my brother n no
                                                doubt I don't regret it Thank you soooo much for the lovely painting
                                                wish you all the very best.</p>
                                        </div>
                                    </div>
                                </div>
                                <!--Single Testimonial End-->
                        </div>
                    </div>

                    <!-- Slider Navigation -->
                    <div class="home1-slider-prev swiper-button-prev main-slider-nav"><i class="lnr lnr-arrow-left"></i>
                    </div>
                    <div class="home1-slider-next swiper-button-next main-slider-nav"><i class="lnr lnr-arrow-right"></i></div>
                    <!-- Slider pagination -->
                    <div class="swiper-pagination default-pagination"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial Area End Here -->



    <!-- Blog Area Start Here -->
    <div class="blog-post-area mt-text-3">
        <div class="container custom-area">
            <div class="row">
                <!--Section Title Start-->
                <div class="col-12">
                    <div class="section-title text-center mb-30">
                        <span class="section-title-1">About Founder</span>
                    </div>
                </div>
                <!--Section Title End-->
            </div>
            <div class="single-blog">
                <div class="row">
                    <div class="col-md-8">
                        <div class="blog-content">
                            <div class="blog-text">
                                <p>
                                    Welcome to Classic Creation! I'm Prerna Prasad, the founder and creative mind behind
                                    this artistic venture. Painting has been my lifelong passion, and fm thrilled to
                                    have
                                    turned it into a reality with Classic Creation.
                                </p>
                                <p>
                                    Over the years, I've poured my heart into honing my skills in gifting customized
                                    paintings. Each stroke of the brush is filled with love and creativity, making every
                                    artwork a unique masterpiece.
                                </p>
                                <p>
                                    At Classic Creation, we take pride in providing you with the finest personalized
                                    paintings for your loved ones. Whether it's capturing a cherished memory, an
                                    anime-inspired artwork, or a beloved cartoon character, we bring your ideas to life
                                    on the canvas of glass.
                                </p>
                                <p>
                                    Join us on this exciting journey of art and imagination. Connect with us on our
                                    Instagram handle @classiccreation to explore the magic of glass paintings. Let's
                                    create
                                    cherished moments together with the charm of Classic Creation.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex justify-content-center align-items-center">
                        <div class="blog-image">
                            <a class="d-block">
                                <img src="assets/newimages/Blog.jpg" alt="Blog Image" class="rounded-circle custom-image1">
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Blog Area End Here -->
    <!-- Brand Logo Area Start Here -->
    </div>

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

    <!-- Modal -->
    <div class="modal flosun-modal fade" id="model1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product1.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle1">Radha Krishna</h4>
                                        </div>
                                        <span id="priceDisplay1">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect1">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect1">
                                                    <option value="6x8" data-price="550.00" data-image="assets/newimages/product1.jpg">6x8 inch</option>
                                                    <option value="9x12" data-price="700.00" data-image="assets/newimages/product1.jpg">9x12 inch</option>
                                                    <option value="12x16" data-price="850.00" data-image="assets/newimages/product1.jpg">12x16 inch</option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect1">1</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="add-to_btn">
                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(1)" class="add-to-cart" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal flosun-modal fade" id="model2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product2.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle2">Candid Photo</h4>
                                        </div>
                                        <span id="priceDisplay2">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect2">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect2">
                                                    <option value="6x8" data-price="550.00" data-image="assets/newimages/product2.jpg">6x8 inch</option>
                                                    <option value="9x12" data-price="700.00" data-image="assets/newimages/product2.jpg">9x12 inch</option>
                                                    <option value="12x16" data-price="850.00" data-image="assets/newimages/product2.jpg">12x16 inch</option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect2">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to_btn">
                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(2)" class="addToCartBtn" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal flosun-modal fade" id="model3" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product3.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle3">Anime Drawing Painting</h4>
                                        </div>
                                        <span id="priceDisplay3">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect3">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect3">
                                                    <option value="6x8" data-price="550.00" data-image="assets/newimages/product3.jpg">6x8 inch</option>
                                                    <option value="9x12" data-price="700.00" data-image="assets/newimages/product3.jpg">9x12 inch</option>
                                                    <option value="12x16" data-price="850.00" data-image="assets/newimages/product3.jpg">12x16 inch</option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect3">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to_btn">
                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(3)" class="addToCartBtn" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal flosun-modal fade" id="model4" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product4.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle4">Cartoon Drawing
                                                Painting</h4>
                                        </div>
                                        <span id="priceDisplay4">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect4">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect4">
                                                    <option value="6x8" data-price="550.00" data-image="assets/newimages/product4.jpg">6x8 inch</option>
                                                    <option value="9x12" data-price="700.00" data-image="assets/newimages/product4.jpg">9x12 inch</option>
                                                    <option value="12x16" data-price="850.00" data-image="assets/newimages/product4.jpg">12x16 inch</option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect4">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to_btn">
                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(4)" class="addToCartBtn" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal flosun-modal fade" id="model5" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product5.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle5">Ganapti Painting</h4>
                                        </div>
                                        <span id="priceDisplay5">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect5">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect5">
                                                    <option value="6x8" data-price="550.00" data-image="assets/newimages/product5.jpg">6x8 inch</option>
                                                    <option value="9x12" data-price="700.00" data-image="assets/newimages/product5.jpg">9x12 inch</option>
                                                    <option value="12x16" data-price="850.00" data-image="assets/newimages/product5.jpg">12x16 inch</option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect5">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to_btn">
                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(5)" class="addToCartBtn" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal flosun-modal fade" id="model6" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product6.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle6">Group Photo Painting</h4>
                                        </div>
                                        <span id="priceDisplay6">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect6">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect6">
                                                    <option value="6x8" data-price="550.00" data-image="assets/newimages/product6.jpg">6x8 inch</option>
                                                    <option value="9x12" data-price="700.00" data-image="assets/newimages/product6.jpg">9x12 inch</option>
                                                    <option value="12x16" data-price="850.00" data-image="assets/newimages/product6.jpg">12x16 inch</option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect6">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to_btn">
                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(6)" class="addToCartBtn" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal flosun-modal fade" id="model7" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product7.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle7">Bestie Photo
                                                Painting</h4>
                                        </div>
                                        <span id="priceDisplay7">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect7">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect7">
                                                    <<option value="6x8" data-price="550.00" data-image="assets/newimages/product7.jpg">6x8 inch</option>
                                                        <option value="9x12" data-price="700.00" data-image="assets/newimages/product7.jpg">9x12 inch
                                                        </option>
                                                        <option value="12x16" data-price="850.00" data-image="assets/newimages/product7.jpg">12x16 inch
                                                        </option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect7">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to_btn">

                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(7)" class="addToCartBtn" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal flosun-modal fade" id="model8" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product8.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle8">Candid Painting</h4>
                                        </div>
                                        <span id="priceDisplay8">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect8">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect8">
                                                    <<option value="6x8" data-price="550.00" data-image="assets/newimages/product8.jpg">6x8 inch</option>
                                                        <option value="9x12" data-price="700.00" data-image="assets/newimages/product8.jpg">9x12 inch
                                                        </option>
                                                        <option value="12x16" data-price="850.00" data-image="assets/newimages/product8.jpg">12x16 inch
                                                        </option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect8">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to_btn">

                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(8)" class="addToCartBtn" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal flosun-modal fade" id="model9" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product9.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle9">BTS Painting</h4>
                                        </div>
                                        <span id="priceDisplay9">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect9">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect9">
                                                    <<option value="6x8" data-price="550.00" data-image="assets/newimages/product9.jpg">6x8 inch</option>
                                                        <option value="9x12" data-price="700.00" data-image="assets/newimages/product9.jpg">9x12 inch
                                                        </option>
                                                        <option value="12x16" data-price="850.00" data-image="assets/newimages/product9.jpg">12x16 inch
                                                        </option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect9">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to_btn">

                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(9)" class="addToCartBtn" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal flosun-modal fade" id="model10" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product10.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle10">Anime Eye Painting</h4>
                                        </div>
                                        <span id="priceDisplay10">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect10">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect10">
                                                    <<option value="6x8" data-price="550.00" data-image="assets/newimages/product10.jpg">6x8 inch</option>
                                                        <option value="9x12" data-price="700.00" data-image="assets/newimages/product10.jpg">9x12 inch
                                                        </option>
                                                        <option value="12x16" data-price="850.00" data-image="assets/newimages/product10.jpg">12x16 inch
                                                        </option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect10">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to_btn">

                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(10)" class="addToCartBtn" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal flosun-modal fade" id="model11" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product11.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle11">Lady In Pink</h4>
                                        </div>
                                        <span id="priceDisplay11">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect11">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect11">
                                                    <<option value="6x8" data-price="550.00" data-image="assets/newimages/product11.jpg">6x8 inch</option>
                                                        <option value="9x12" data-price="700.00" data-image="assets/newimages/product11.jpg">9x12 inch
                                                        </option>
                                                        <option value="12x16" data-price="850.00" data-image="assets/newimages/product11.jpg">12x16 inch
                                                        </option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect11">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to_btn">

                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(11)" class="addToCartBtn" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal flosun-modal fade" id="model12" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product12.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle12">Royal Lion</h4>
                                        </div>
                                        <span id="priceDisplay12">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect12">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect12">
                                                    <<option value="6x8" data-price="550.00" data-image="assets/newimages/product12.jpg">6x8 inch</option>
                                                        <option value="9x12" data-price="700.00" data-image="assets/newimages/product12.jpg">9x12 inch
                                                        </option>
                                                        <option value="12x16" data-price="850.00" data-image="assets/newimages/product12.jpg">12x16 inch
                                                        </option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect12">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to_btn">

                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(12)" class="addToCartBtn" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal flosun-modal fade" id="model13" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product13.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle13">Couple Painting</h4>
                                        </div>
                                        <span id="priceDisplay13">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect13">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect13">
                                                    <<option value="6x8" data-price="550.00" data-image="assets/newimages/product13.jpg">6x8 inch</option>
                                                        <option value="9x12" data-price="700.00" data-image="assets/newimages/product13.jpg">9x12 inch
                                                        </option>
                                                        <option value="12x16" data-price="850.00" data-image="assets/newimages/product13.jpg">12x16 inch
                                                        </option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect13">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to_btn">

                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(13)" class="addToCartBtn" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal flosun-modal fade" id="model14" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product14.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle14">Friends Selfie</h4>
                                        </div>
                                        <span id="priceDisplay14">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect14">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect14">
                                                    <<option value="6x8" data-price="550.00" data-image="assets/newimages/product14.jpg">6x8 inch</option>
                                                        <option value="9x12" data-price="700.00" data-image="assets/newimages/product14.jpg">9x12 inch
                                                        </option>
                                                        <option value="12x16" data-price="850.00" data-image="assets/newimages/product14.jpg">12x16 inch
                                                        </option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect14">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to_btn">

                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(14)" class="addToCartBtn" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal flosun-modal fade" id="model15" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product15.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle15">Anime Painting</h4>
                                        </div>
                                        <span id="priceDisplay15">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect15">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect15">
                                                    <<option value="6x8" data-price="550.00" data-image="assets/newimages/product15.jpg">6x8 inch</option>
                                                        <option value="9x12" data-price="700.00" data-image="assets/newimages/product15.jpg">9x12 inch
                                                        </option>
                                                        <option value="12x16" data-price="850.00" data-image="assets/newimages/product15.jpg">12x16 inch
                                                        </option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect15">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to_btn">

                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(15)" class="addToCartBtn" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal flosun-modal fade" id="model16" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product16.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle16">Anime Painting</h4>
                                        </div>
                                        <span id="priceDisplay16">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect16">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect16">
                                                    <<option value="6x8" data-price="550.00" data-image="assets/newimages/product16.jpg">6x8 inch</option>
                                                        <option value="9x12" data-price="700.00" data-image="assets/newimages/product16.jpg">9x12 inch
                                                        </option>
                                                        <option value="12x16" data-price="850.00" data-image="assets/newimages/product16.jpg">12x16 inch
                                                        </option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect16">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to_btn">

                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(16)" class="addToCartBtn" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal flosun-modal fade" id="model17" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product17.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle17">Family Painting</h4>
                                        </div>
                                        <span id="priceDisplay17">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect17">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect17">
                                                    <<option value="6x8" data-price="550.00" data-image="assets/newimages/product17.jpg">6x8 inch</option>
                                                        <option value="9x12" data-price="700.00" data-image="assets/newimages/product17.jpg">9x12 inch
                                                        </option>
                                                        <option value="12x16" data-price="850.00" data-image="assets/newimages/product17.jpg">12x16 inch
                                                        </option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect17">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to_btn">

                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(17)" class="addToCartBtn" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal flosun-modal fade" id="model18" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product18.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle18">Lady in Traditional</h4>
                                        </div>
                                        <span id="priceDisplay18">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect18">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect18">
                                                    <<option value="6x8" data-price="550.00" data-image="assets/newimages/product18.jpg">6x8 inch</option>
                                                        <option value="9x12" data-price="700.00" data-image="assets/newimages/product18.jpg">9x12 inch
                                                        </option>
                                                        <option value="12x16" data-price="850.00" data-image="assets/newimages/product18.jpg">12x16 inch
                                                        </option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect18">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to_btn">

                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(18)" class="addToCartBtn" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal flosun-modal fade" id="model19" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product19.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle19">Candid Painting</h4>
                                        </div>
                                        <span id="priceDisplay19">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect19">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect19">
                                                    <<option value="6x8" data-price="550.00" data-image="assets/newimages/product19.jpg">6x8 inch</option>
                                                        <option value="9x12" data-price="700.00" data-image="assets/newimages/product19.jpg">9x12 inch
                                                        </option>
                                                        <option value="12x16" data-price="850.00" data-image="assets/newimages/product19.jpg">12x16 inch
                                                        </option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect19">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to_btn">

                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(19)" class="addToCartBtn" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal flosun-modal fade" id="model20" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product20.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle20">Side Face Painting</h4>
                                        </div>
                                        <span id="priceDisplay20">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect20">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect20">
                                                    <<option value="6x8" data-price="550.00" data-image="assets/newimages/product20.jpg">6x8 inch
                                                        </option>
                                                        <option value="9x12" data-price="700.00" data-image="assets/newimages/product20.jpg">9x12 inch
                                                        </option>
                                                        <option value="12x16" data-price="850.00" data-image="assets/newimages/product20.jpg">12x16 inch
                                                        </option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect20">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to_btn">

                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(20)" class="addToCartBtn" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal flosun-modal fade" id="model21" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product21.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle21">Bestie's Painting</h4>
                                        </div>
                                        <span id="priceDisplay21">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect21">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect21">
                                                    <<option value="6x8" data-price="550.00" data-image="assets/newimages/product21.jpg">6x8 inch
                                                        </option>
                                                        <option value="9x12" data-price="700.00" data-image="assets/newimages/product21.jpg">9x12 inch
                                                        </option>
                                                        <option value="12x16" data-price="850.00" data-image="assets/newimages/product21.jpg">12x16 inch
                                                        </option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect21">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to_btn">

                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(21)" class="addToCartBtn" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal flosun-modal fade" id="model22" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product22.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle22">Friendship Painting</h4>
                                        </div>
                                        <span id="priceDisplay22">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect22">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect22">
                                                    <<option value="6x8" data-price="550.00" data-image="assets/newimages/product22.jpg">6x8 inch
                                                        </option>
                                                        <option value="9x12" data-price="700.00" data-image="assets/newimages/product22.jpg">9x12 inch
                                                        </option>
                                                        <option value="12x16" data-price="850.00" data-image="assets/newimages/product22.jpg">12x16 inch
                                                        </option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect22">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to_btn">

                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(22)" class="addToCartBtn" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal flosun-modal fade" id="model23" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product23.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle23">Trip Memories</h4>
                                        </div>
                                        <span id="priceDisplay23">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect23">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect23">
                                                    <<option value="6x8" data-price="550.00" data-image="assets/newimages/product23.jpg">6x8 inch
                                                        </option>
                                                        <option value="9x12" data-price="700.00" data-image="assets/newimages/product23.jpg">9x12 inch
                                                        </option>
                                                        <option value="12x16" data-price="850.00" data-image="assets/newimages/product23.jpg">12x16 inch
                                                        </option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect23">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to_btn">

                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(23)" class="addToCartBtn" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal flosun-modal fade" id="model24" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close close-button" data-bs-dismiss="modal" aria-label="Close">
                    <span class="close-icon" aria-hidden="true">x</span>
                </button>
                <div class="modal-body">
                    <div class="container-fluid custom-area">
                        <div class="row">
                            <div class="col-md-6 col-custom">
                                <div class="modal-product-img">
                                    <a class="w-100" href="#">
                                        <img class="w-100" src="assets/newimages/product24.jpg" alt="Product">
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-custom">
                                <div class="modal-product">
                                    <div class="product-content">
                                        <div class="product-title">
                                            <h4 class="title" id="productTitle24">Selfie Painting</h4>
                                        </div>
                                        <span id="priceDisplay24">Price: <strong>$550.00</strong></span>
                                        <div class="product-rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>1 Review</span>
                                        </div>
                                        <form class="d-flex flex-column w-100" action="#">
                                            <div class="form-group">
                                                <label for="sizeSelect24">Select Size:</label>
                                                <select class="form-control nice-select w-100" id="sizeSelect24">
                                                    <<option value="6x8" data-price="550.00" data-image="assets/newimages/product24.jpg">6x8 inch
                                                        </option>
                                                        <option value="9x12" data-price="700.00" data-image="assets/newimages/product24.jpg">9x12 inch
                                                        </option>
                                                        <option value="12x16" data-price="850.00" data-image="assets/newimages/product24.jpg">12x16 inch
                                                        </option>
                                                </select>
                                            </div>
                                        </form>
                                        <div class="quantity-with-btn">
                                            <div class="quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="cart-plus-minus-box">
                                                        <span class="quantityValue" id="quantitySelect24">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="add-to_btn">

                                                <a class="btn product-cart button-icon flosun-button dark-btn" onclick="addToCart(24)" class="addToCartBtn" data-product-index="1">
                                                    Add to Cart
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
        document.addEventListener('DOMContentLoaded', function() {
            // Select all quantity containers
            const quantityContainers = document.querySelectorAll('.quantity');

            // Function to create quantity control for a container
            function createQuantityControl(container) {
                const quantityValue = container.querySelector('.quantityValue');
                const incrementButton = container.querySelector('.qtybutton.inc');
                const decrementButton = container.querySelector('.qtybutton.dec');
                let currentValue = 1;

                function updateQuantityDisplay() {
                    quantityValue.textContent = currentValue;
                }

                function incrementQuantity() {
                    if (currentValue < 10) {
                        currentValue++;
                        updateQuantityDisplay();
                    }
                }

                function decrementQuantity() {
                    if (currentValue > 1) {
                        currentValue--;
                        updateQuantityDisplay();
                    }
                }

                incrementButton.addEventListener('click', incrementQuantity);
                decrementButton.addEventListener('click', decrementQuantity);
                updateQuantityDisplay();
            }

            // Apply the quantity control code to all 25 products
            quantityContainers.forEach(createQuantityControl);
        });
    </script>

    <script>
        // Define a global cart variable and initialize it with cart data from storage
        var cart = getCartFromStorage() || [];

        // Function to get cart data from localStorage or sessionStorage
        function getCartFromStorage() {
            var storage = sessionStorage || localStorage; // Choose storage type
            var cartData = storage.getItem('cartData');
            return cartData ? JSON.parse(cartData) : [];
        }

        // Function to update the cart item count.
        function updateCartItemCount() {
            var cartItemCountElement = document.getElementById('cart-item-count');
            cartItemCountElement.textContent = cart.length;
        }

        // Common function to add a product to the cart.
        function addToCart(productIndex) {

            function checkLoginStatus(callback) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'check_login.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        callback(response.loggedIn);
                    }
                };
                xhr.send();
            }

            // Example AJAX request for loading dynamic content
            function loadContent() {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', 'content.php', true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        document.getElementById('home-content').innerHTML = xhr.responseText;
                    }
                };
                xhr.send();
            }

            // Example usage of the checkLoginStatus function
            checkLoginStatus(function(loggedIn) {
                if (loggedIn) {
                    console.log('User is logged in');
                    // Additional logic if the user is logged in

                    // Load dynamic content
                    loadContent();
                } else {
                    console.log('User is not logged in');
                    // Additional logic if the user is not logged in
                }
            });

            // Get the selected product details.
            var productName = document.getElementById('productTitle' + productIndex).textContent;
            var selectedSize = document.getElementById('sizeSelect' + productIndex).value;
            var selectedSizePrice = parseFloat(document.querySelector('#sizeSelect' + productIndex + ' option:checked').getAttribute('data-price'));
            var selectedImage = document.querySelector('#sizeSelect' + productIndex + ' option:checked').getAttribute('data-image');

            // Get the selected quantity from the user's input.
            var selectedQuantity = parseInt(document.getElementById('quantitySelect' + productIndex).textContent, 10);

            // Create a product object with the selected information, including the user-selected quantity.
            var product = {
                name: productName,
                size: selectedSize,
                price: selectedSizePrice,
                image: selectedImage,
                quantity: selectedQuantity,
            };

            // Check if the product is already in the cart and update the quantity or add it to the cart.
            var existingProduct = cart.find((item) => item.name === productName && item.size === selectedSize);
            if (existingProduct) {
                existingProduct.quantity += selectedQuantity;
            } else {
                cart.push(product);
            }

            // Update the cart display.
            updateCartDisplay();

            // Update the cart item count.
            updateCartItemCount();

            // Store the cart data in sessionStorage
            saveCartToStorage();

            // Store the cart data in localStorage
            localStorage.setItem('cartData', JSON.stringify(cart));
        }

        // Function to update the cart display.
        function updateCartDisplay() {
            var cartContainer = document.getElementById('cart-items-row');
            var cartEmptyMessage = document.getElementById('cart-empty-message');

            // Clear existing content
            cartContainer.innerHTML = '';

            if (cart.length === 0) {
                cartEmptyMessage.style.display = 'block';

                // Set the total amount to 0 when the cart is empty
                var cartTotalAmount = document.getElementById('cart-total-amount');
                var inrSign = cartTotalAmount.querySelector('.inr-sign');
                inrSign.textContent = '0.00'; // Update to 0.00
            } else {
                cartEmptyMessage.style.display = 'none';

                var total = 0; // Initialize the total variable.

                for (var i = 0; i < cart.length; i++) {
                    var product = cart[i];
                    var productContainer = document.createElement('div');
                    productContainer.className = 'cart-product-container'; // Add a class for styling

                    var productItem = document.createElement('div');
                    productItem.className = 'cart-product'; // Add a class to style each product

                    productItem.innerHTML = `
        <div class="product-image">
            <img class="cart-product-image" src="${product.image}" alt="Product">
        </div>
        <div class="product-details">
            <h4>${product.name}</h4>
            <p>Size: ${product.size}</p>
            <p>Quantity: ${product.quantity}</p>
            <p>Price: ₹${(product.price * product.quantity).toFixed(2)}</p>
        </div>
        <div class="remove-button">
            <button class="remove-from-cart" data-index="${i}">
                <i class="lnr lnr-trash"></i>
            </button>
        </div>
    `;
                    total += product.price * product.quantity; // Update the total for each product.

                    productContainer.appendChild(productItem);
                    cartContainer.appendChild(productContainer);
                }

                // Update the total amount in the HTML with the Rupee symbol (₹).
                var cartTotalAmount = document.getElementById('cart-total-amount');
                var inrSign = cartTotalAmount.querySelector('.inr-sign');
                inrSign.textContent = total.toFixed(2); // Format the total with "₹"
            }

            // Store the cart data in localStorage
            localStorage.setItem('cartData', JSON.stringify(cart));
        }

        // Initialize the cart item count
        updateCartItemCount();

        // Function to update the cart item count.
        function updateCartItemCount() {
            var cartItemCountElement = document.getElementById('cart-item-count');
            cartItemCountElement.textContent = cart.length;
        }

        // Function to remove a product from the cart.
        function removeFromCart(index) {
            console.log('Removing product at index:', index); // Debugging
            cart.splice(index, 1);

            // Check if the cart is now empty and update the display accordingly
            if (cart.length === 0) {
                // Clear the cart entirely
                cart.length = 0;

                // Update the cart display to show that it's empty
                var cartEmptyMessage = document.getElementById('cart-empty-message');
                cartEmptyMessage.style.display = 'block';
            }

            // Update the cart item count.
            updateCartItemCount();

            // Store the cart data in sessionStorage
            saveCartToStorage();

            // Update the cart display.
            updateCartDisplay();

            // Store the cart data in localStorage
            localStorage.setItem('cartData', JSON.stringify(cart));
        }

        // Event delegation: Listen for "click" events on the common ancestor of product elements.
        document.addEventListener('click', function(event) {
            var target = event.target;

            // Handle clicks on the trash can icon within the "Remove from Cart" button.
            if (target.classList.contains('lnr-trash')) {
                // Get the parent button element (the "Remove from Cart" button).
                var button = target.closest('.remove-from-cart');

                if (button) {
                    var index = parseInt(button.getAttribute('data-index'), 10);
                    if (!isNaN(index)) {
                        removeFromCart(index);
                    }
                }
            }
        });

        // Function to save the cart data to sessionStorage
        function saveCartToStorage() {
            sessionStorage.setItem('cartData', JSON.stringify(cart));
        }

        // Restore cart data from sessionStorage when the page loads
        function restoreCartFromStorage() {
            cart = getCartFromStorage() || [];
            updateCartDisplay();
            updateCartItemCount();
        }

        // Restore cart data when the page loads
        restoreCartFromStorage();
    </script>
    <script>
        function setupProduct(productNumber) {
            const sizeSelect = document.getElementById('sizeSelect' + productNumber);
            const priceDisplay = document.getElementById('priceDisplay' + productNumber);

            function updatePrice() {
                const selectedPrice = sizeSelect.options[sizeSelect.selectedIndex].getAttribute('data-price');
                priceDisplay.innerHTML = "Price: <strong>₹" + selectedPrice + "</strong>";
            }

            // Add an event listener to call updatePrice when the page loads
            window.addEventListener('load', updatePrice);
            sizeSelect.addEventListener('change', updatePrice);
        }

        // Call the setupProduct function for each product (1 to 25)
        for (let productNumber = 1; productNumber <= 25; productNumber++) {
            setupProduct(productNumber);
        }
    </script>
    <script>
        // Assume you have the userLoggedIn variable available here

        document.getElementById('viewCartBtn').addEventListener('click', function() {
            // Check if the user is logged in using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'check_login.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);

                    if (response.loggedIn) {
                        // User is logged in, proceed to view cart
                        window.location.href = 'cart.php';
                    } else {
                        // User is not logged in, redirect to login
                        window.location.href = 'login.php?redirectToCart=true';
                    }
                }
            };
            xhr.send();
        });
    </script>
</body>

</html>