<?php
if(!isset($_SESSION["user"])){ // Nếu chưa khởi tạo session 
    session_start();
}
session_unset();
session_destroy();
header("Location: ?auth=login");