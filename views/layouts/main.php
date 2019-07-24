<?php
 /* @var $this \app\controllers\Controller */
 /* @var $content string */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/css/template.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/index.js" defer></script>
    <title>Brand</title>
</head>
<body>
    <header>
        <div class="container header-flex">
            <div class="header-left">
                <a class ="logo" href="/"><img src="/assets/images/logo.png" alt="logo">
                    <div class="brand-name">bran<span>d</span></div>
                </a>
                <form class="header-form" action="#">
                    <div class="select" >
                        <div class="browse-container">
                            <a href="?c=products" class="browse"> <span>Browse</span></a>
                            <nav class="browse-items hide">
                                <div class="browse-menu">
                                    <h3><a href="?c=products">Women</a></h3>
                                    <ul>
                                        <li class="browse-menu-li"><a href="?c=products">Dresses</a></li>
                                        <li class="browse-menu-li"><a href="?c=products">Tops</a></li>
                                        <li class="browse-menu-li"><a href="?c=products">Sweaters/Knits</a></li>
                                        <li class="browse-menu-li"><a href="?c=products">Jackets/Coats</a></li>
                                        <li class="browse-menu-li"><a href="?c=products">Blazers</a></li>
                                        <li class="browse-menu-li"><a href="?c=products">Denim</a></li>
                                        <li class="browse-menu-li"><a href="?c=products">Leggings/Pants</a></li>
                                        <li class="browse-menu-li"><a href="?c=products">Skirts/Shorts</a></li>
                                        <li class="browse-menu-li"><a href="?c=products">Accessories</a></li>
                                    </ul>
                                </div>
                                <div class="browse-menu">
                                    <h3><a href="?c=products">Man</a></h3>
                                    <ul>
                                        <li class="browse-menu-li"><a href="?c=products">Tees/Tank tops</a></li>
                                        <li class="browse-menu-li"><a href="?c=products">Shirts/Polos</a></li>
                                        <li class="browse-menu-li"><a href="?c=products">Sweaters</a></li>
                                        <li class="browse-menu-li"><a href="?c=products">Sweatshirts/Hoodies</a></li>
                                        <li class="browse-menu-li"><a href="?c=products">Blazers</a></li>
                                        <li class="browse-menu-li"><a href="?c=products">Jackets/vests</a></li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                        <input type="text" class="search-text" placeholder="Search for Item...">
                        <a href="?c=products" class="find-btn search-button"><i class="fas fa-search"></i></a>
                    </div>
                </form>
            </div>
            <div class="header-right">
                <div class="cart-btn-block">
                    <a class="cart__button" href="cart.html">
                        <img class="cart-image" src="/assets/images/cart.svg" alt="cart">
                        <span class="cart-items-total">0</span>
                    </a>
                    <div class="cart-items">
                        <div class="cart__container top-block">
                            <!-- rendering cart goods from js -->
                        </div>
                        <div class="bottom-block">
                            <div class="cart-total-price">
                                <div class="cart-total__text"> TOTAL </div>
                                <div class="cart-total__price"></div>
                            </div>
                            <a href="checkout.html" class="cart-btn btn-check-out">Checkout</a>
                            <a href="cart.html" class="cart-btn btn-to-cart">Go to cart</a>
                        </div>
                    </div>
                </div>
                <div class="account__control">
                    <a href="#" class="my-account-btn">Login</a>
                    <i class="fas fa-sign-out-alt btn-logout hide"></i>
                </div>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="content">
            <?= $content ?>
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="footer-right">
                &copy;2017  Brand  All Rights Reserved.
            </div>
            <div class="footer-left">
                <a class="social-btn"><i class="fab fa-facebook-f"></i></a>
                <a class="social-btn"><i class="fab fa-twitter"></i></a>
                <a class="social-btn in"><i class="fab fa-linkedin-in"></i></a>
                <a class="social-btn"><i class="fab fa-pinterest-p"></i></a>
                <a class="social-btn"><i class="fab fa-google-plus-g"></i></a>
            </div>
        </div>
    </footer>
</body>
</html>