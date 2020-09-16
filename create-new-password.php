<?php
    require "header.php";
?>

    <main>
    <div>
        <section class="sign-up-section">
            <?php 
                $selector = $_GET["selector"];
                $validator = $_GET["validator"];

                if(empty($selector) || empty($validator)){
                    echo "couldn't validate your request";

                }
                else{
                    if(ctype_xdigit($selector) !== false && ctype_xdigit($validator)){

                        ?>
                            <form action="includes/reset-password.inc.php" method="post">
                                <input type="hidden" name="selector" value="<?php echo $selector ?>">
                                <input type="hidden" name="validator" value="<?php echo $validator ?>">
                                <input type="password" name="pwd" placeholder="Enter a new password...">
                                <input type="password" name="pwd-repeat" placeholder="Repeat new password...">
                                <button type="submit" name="reset-password-submit">Reset passwrod</button>
                            </form>

                        <?php
                    }
                }
            ?>
        </section> 
    </div>

    </main>
    <?php
    require "footer.php";
?>