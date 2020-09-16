<?php 
    session_start();
    require "includes/check-cookie.inc.php";
    if(!isset($_SESSION['userId']) && !isset($_SESSION['compSlug'])){
        if(count($_COOKIE) > 0){
            
            checkCoockie();
        } 
    }
    require 'includes/globals.inc.php';
    
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="utf-8">
    <meta name="description" content="The best website for new ideas for great companies">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <title>WAIDW</title>
    <link rel="stylesheet" href="<?php echo $HOSTNAME; ?>/styles/styles.css">
    <link rel="icon" type="image/ico" href="./favicon.ico"/>
    </head>


    <body>
    <div class="form-login-logout">
            <?php 
            
                if(isset($_SESSION['userId']) || isset($_SESSION['compSlug'])){
                    echo '<form class="form-signup" action="'. $HOSTNAME .'/includes/logout.inc.php" method="post">
                    
                        <button type="submit" name="logout-submit">Logout</button>

                    </form>';
                }
                else {
        
                    echo '<button onclick="showForm()">Login</button>';
                }
               
            ?>
                
                
            </div>
        
    

    <header>
        <div class="header-container">
            
            <nav>
            <a href="<?php echo $HOSTNAME; ?>">
                <img class="logo" src="<?php echo $HOSTNAME; ?>img/logo.png" alt="logo" >
            </a>
            <ul>
                <li><a href="<?php echo $HOSTNAME; ?>">Home</a></li>
                <li><a href="<?php echo $HOSTNAME; ?>c/">Categories</a></li>
                <li><a href="<?php echo $HOSTNAME; ?>every-user.php">Users</a></li>
<li><a href="<?php if(isset($_SESSION["compSlug"])){echo "<?php echo $HOSTNAME; ?>c/";}else{echo $HOSTNAME."u/";} ?><?php if(isset($_SESSION['userId'])){echo $_SESSION['userId'];}else if(isset($_SESSION['compSlug'])){echo $_SESSION['compSlug'];}else echo '0' ?>">Profile</a></li>
    
            </ul>
           
            </nav>
           
            
            
        </div>
    </header>

    <?php 
                if(!isset($_SESSION['userId']) && !isset($_SESSION['compSlug'])){

                ?>
                <div class="login-container" id="loginContainer" style="display: none">
                <form class="form-sign-up" action="<?php echo $HOSTNAME; ?>includes/login.inc.php"  method="post">
                            <input type="text" name="mailuid" placeholder="Username/E-mail">
                            <input type="password" name="pwd" placeholder="Password">
                            <button type="submit" name="login-submit">Login</button>
                            <div style="display: flex;">
                            <?php if(count($_COOKIE) > 0) { ?>
                            <input type="checkbox" name="rememberme" value="loggedin">
                            <label for="rememberme">Remember me</label><br>

                            <?php }else{ ?>
                                <p class="warning">Cookies not enabled</p>
                            <?php } ?>
                </div>
                        </form>
                        <button onclick="hideForm()">Cancel</button>
                        <a class="reset-pwd" href="reset-password.php">Forgot your password?</a>
                        <a href="signup.php">Sign Up</a> 
                        <a href="signup-company.php">Sign Up a Company</a> 

                </div>
                <script>
                    function showForm(){
                        document.getElementById("loginContainer").style.display = "flex";
                        }
                    function hideForm(){
                        document.getElementById("loginContainer").style.display = "none";
                    }
                </script>
                <?php } ?>