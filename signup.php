<?php
    require "header.php";
?>

    <main>
    <div>
        <section class="sign-up-section">
            <h2>Sign Up</h2>
            <?php

                if(isset($_GET['error'])){
                    if($_GET['error'] == "emptyfields"){
                        echo '<p class="sign-up-error"> Please fill in all fields</p>';

                    }
                    else if($_GET['error'] == "invalidmailuid"){
                        echo '<p class="sign-up-error">Invalid E-mail and Username</p>';

                    }
                    else if($_GET['error'] == "invalidmail"){
                        echo '<p class="sign-up-error">Invalid E-mail</p>';

                    }
                    else if($_GET['error'] == "invaliduid"){
                        echo '<p class="sign-up-error">Invalid Username</p>';

                    }
                    else if($_GET['error'] == "passwordcheck"){
                        echo "<p class='sign-up-error'>Passwords doesn't match</p>";

                    }
                    else if($_GET['error'] == "userTaken"){
                        echo "<p class='sign-up-error'>Username taken please choose another username</p>";

                    }
                    else if($_GET['signup'] == "success"){
                        echo "<p class='sign-up-success'>Sign up successful</p>";

                    }
                }
            ?>
            <form class="form-sign-up" action="includes/singup.inc.php" method="post">
                <input type="text" name="uid" placeholder="Username">
                <input type="text" name="mail" placeholder="E-mail">
                <input type="password" name="pwd" placeholder="Password">
                <input type="password" name="pwd-repeat" placeholder="Repeat password">
                <button type="submit" name="signup-submit">Sing Up</button>
            </form>
            <?php
                if(isset($_GET['newpwd'])){
                    if($_GET['newpwd'] == "password"){
                        echo '<p class="sign-up-success"> Your password has been reset!</p>';
                        
                    }
                }
            ?>

            <a class="reset-pwd" href="reset-password.php">Forgot your password?</a>
        </section> 
    </div>

    </main>
    <?php
    require "footer.php";
?>
