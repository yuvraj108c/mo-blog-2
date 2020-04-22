<?php
require("../classes/Constants.php");

session_start();

// Clear all sessions variables
unset($_SESSION['userLoggedIn']);

// Go to homepage
header("Location: " . Constants::$root_client . "login.php");