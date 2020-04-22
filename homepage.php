<?php

    require("includes/Header.php");
    session_start();

    $header = new Header("homepage","homepage.css");
    $header->output();
?>

<body>

    <?php include "includes/navbar.php"; ?>

    <h1>Home</h1>

</body>

</html>