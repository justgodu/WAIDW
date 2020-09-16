<?php
    require "header.php";
?>

    <main>
    <div>
        <section class="sign-up-section">
           <h1>Reset your password</h1>
           <p>An e-mail be send to you with instruction on how to reset your password</p>
           <form class="form-sign-up" action="includes/reset-request.inc.php" method="post">
                <input type="text" name="email" placeholder="Enter you e-mail address.">
                <button type="submit" name="reset-request-submit">Receive new password by e-mail</button>

           </form>
           <?php 
            if(isset($_GET["reset"])){
                if($_GET["reset"]== "success"){
                    echo '<p> Check you E-mail!</p>';
                }
            }
            if(isset($_GET["url"])){
            $url = $_GET["err"];
            echo $url;
            //echo  urldecode($url);
            }
           ?>
        </section> 
    </div>

    </main>
    <?php
    require "footer.php";
?>
