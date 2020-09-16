
<?php
if (isset($_POST['login-submit'])) {

    require 'dbh.inc.php';
    $mailuid = $_POST['mailuid'];
    $password = $_POST['pwd'];
    $rememberMe = $_POST['rememberme'];
    $cookieName = 'loggedin';
    
    if(empty($mailuid) || empty($password)){
        header("Location: ../?error=emptyfields");
        exit();
    }
    else{
        $sql = "SELECT * FROM users WHERE uidUsers=? OR emailUsers=?;";
       
        $stmt = mysqli_stmt_init($conn);
       
        if(!mysqli_stmt_prepare($stmt, $sql) ){
            header("Location: ../?error=sqlerror");
        exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)){
                $pwdCheck = password_verify($password, $row['pwdUsers']);
                if($pwdCheck == false){
                    header("Location: ../?error=wrongpwd");
                exit();
                }else if($pwdCheck == true){
                    session_start();
                    $_SESSION['userId'] = $row['idUsers'];
                    $_SESSION['userUId'] = $row['uidUsers'];
                    if($rememberMe === 'loggedin'){
                        
                        setcookie($cookieName, $row['idUsers'], time() + (86400 * 30), "/");
                        header("Location: ../?login=cookiesuccess");
                        exit();
                    }
                    header("Location: ../?login=success");
                    exit();
                }
                else{
                    header("Location: ../?error=wrongpwd");
                    exit();
                }
                
            }else{
            
                $sql = "SELECT * FROM companies WHERE uidCompanies=? OR emailCompanies=?;";
       
                $stmt = mysqli_stmt_init($conn);
               
                if(!mysqli_stmt_prepare($stmt, $sql) ){
                    header("Location: ../?error=sqlerror");
                exit();
                }
                else{
                    mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if($row = mysqli_fetch_assoc($result)){
                        $pwdCheck = password_verify($password, $row['pwdCompanies']);
                        if($pwdCheck == false){
                            header("Location: ../?error=wrongpwd");
                        exit();
                        }else if($pwdCheck == true){
                            session_start();
                            $_SESSION['compSlug'] = $row['slug'];
                            $_SESSION['compUid'] = $row['uidCompanies'];
                            if($rememberMe === 'loggedin'){
                                
                                setcookie($cookieName, $row['idCompanies'], time() + (86400 * 30), "/");
                                header("Location: ../?login=cookiesuccess");
                                exit();
                            }
                            header("Location: ../?login=success");
                            exit();
                        }
                        else{
                            header("Location: ../?error=compwrongpwd");
                            exit();
                        }
                        
                    }else{
                        header("Location: ../?error=nouser");
                            exit();
                    }
            }
        }
        
}
}}
else{
    header("Location: ../index.php");
    exit();
}