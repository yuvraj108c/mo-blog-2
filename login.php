<?php
    require "includes/Header.php";
    require "config.php";
    
    $header = new Header("Login","login.css");
    $header->output();

        require "includes/classes/Messages.php";

        session_start();

        if(isset($_GET['err'])){
            $err = $_GET['err'];

            if($err == '1'){
                Messages::setMsg("Invalid username or password.","error");
            }
        }
?>

<body>

    <?php
         include "includes/navbar.php";
     ?>

    <section id="login">

        <h2>Log in into your account</h2>

        <div class="ui card">

            <div class="content">

                <form method="POST" class="ui form" action="<?php echo SERVER_URL . '/server/user' ?>">

                    <input type="hidden" name="type" value="login" />

                    <!-- Username -->
                    <div class="field">
                        <label>Username</label>
                        <input type="text" name="username" placeholder="Username" value="John" required>
                    </div>

                    <!-- Password -->
                    <div class="field">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="Password" value="12345" required>
                    </div>

                    <!-- Message -->
                    <?php echo Messages::display(); ?>

                    <!-- Submit btn -->
                    <button class="ui fluid large button teal" type="submit" name="loginBtn">Login</button>

                </form>

                <div class="bottom">
                    Don't have an account? <a href="register.php">&nbsp;Sign up</a>
                </div>

            </div>

    </section>

</body>

</html>