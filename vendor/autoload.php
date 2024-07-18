<?php
function loadAllFiles($files) {
    foreach ($files as $file) {
        if (file_exists($file)) {
            include_once $file;
        } else {
            echo "File $file not found!";
        }
    }
}

$filesToLoad = [
    './models/user-model.php',
    './models/category-model.php',
    './models/product-model.php',
    './models/comment-model.php',
    './models/banner-model.php',
    './models/cart-model.php',
    './models/order-model.php',
    './models/blog-model.php',
    './controllers/user-controller.php',
    './controllers/category-controller.php',
    './controllers/product-controller.php',
    './controllers/comment-controller.php',
    './controllers/banner-controller.php',
    './controllers/cart-controller.php',
    './controllers/order-controller.php',
    './controllers/blog-controller.php'
];

// Load all files
loadAllFiles($filesToLoad);