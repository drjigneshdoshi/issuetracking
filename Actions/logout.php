<?php
include_once "../Functions/BaseURL.php";
/**
 * Created by PhpStorm.
 * User: Mihir
 * Date: 9/24/2016
 * Time: 12:10 AM
 */
session_start();
session_destroy();
header("Location: ".BaseURLConcat("Login"));