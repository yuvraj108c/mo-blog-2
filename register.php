<?php
    require("includes/Header.php");
    require "config.php";
    require "includes/classes/Messages.php";

    $header = new Header("Register","register.css");
    $header->output();

    
    session_start();
    
    if(isset($_GET['err'])){
        $err = $_GET['err'];
        $username = $_GET['username'];
        $email = $_GET['email'];
        
        if($err == '1'){
            Messages::setMsg("Your passwords don't match.","error");
        }elseif($err == '2'){
            Messages::setMsg("Username already exists.","error");
        }elseif($err == '3'){
            Messages::setMsg("Email already exists.","error");
        }elseif($err == '4'){
            Messages::setMsg("Invalid recaptcha.","error");
        }
    }else{
        $username = "john";
        $email = "john@gmail.com";
    }
?>

<body>
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>

    <?php include "includes/navbar.php"; ?>

    <section id="register">

        <div class="right">

            <h2>Create a new account</h2>

            <div class="ui card">

                <div class="content">

                    <form class="ui large form" method="POST"
                        action="<?php echo SERVER_URL . '/handlers/register-handler.php' ?>">

                        <!-- Username -->
                        <div class="field">
                            <label>Username</label>
                            <div class="ui icon input">
                                <input type="text" name="username" placeholder="Username"
                                    value="<?php echo($username)?>" required>
                            </div>
                        </div>

                        <!-- Email address -->
                        <div class="field">
                            <label>Email</label>
                            <div class="ui icon input">
                                <input type="email" name="email" placeholder="Email" value="<?php echo($email)?>"
                                    required>
                            </div>
                        </div>


                        <!-- Password -->
                        <div class="field">
                            <label>Password</label>
                            <div class="ui icon input">
                                <input type="password" name="pwd1" placeholder="Password" value="" required>
                            </div>
                        </div>

                        <!-- Confirm password -->
                        <div class="field">
                            <label>Confirm Password</label>
                            <div class="ui icon input">
                                <input type="password" name="pwd2" placeholder="Confirm password" value="" required>
                            </div>
                        </div>
                        <br>


                        <!-- Recaptcha -->
                        <div class="g-recaptcha" data-sitekey="6LeKFY4UAAAAAK_wO_RC5UvJpq2xIYi3kQ7unzkx"></div><br>

                        <!-- Message -->
                        <?php echo Messages::display(); ?>

                        <!-- Submit  -->
                        <button class="ui fluid large submit button teal" type="submit" name="registerBtn"
                            id="registerBtn">Sign up</button>

                    </form>

                    <div class="bottom">
                        Already have an account? <a href="login.php">&nbsp;Log In</a>
                    </div>

                </div>

            </div>

        </div>

    </section>

</body>

</html>