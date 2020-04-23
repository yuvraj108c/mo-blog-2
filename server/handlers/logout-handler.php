<?php
require("../classes/Constants.php");

session_start();

// Clear all sessions variables
unset($_SESSION['userLoggedIn']);

header("Location: " . Constants::$root_client . "login.php");