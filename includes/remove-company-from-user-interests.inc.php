<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_POST['remove-interest-submit']) ){
    if(isset($_POST['id']) && isset($_POST['slug'])){
    $cId = $_POST['id'];
    $slug = $_POST['slug'];
    $uUId = $_SESSION['userUId'];
    require 'dbh.inc.php';

    $sql = "UPDATE users SET interests=REPLACE(interests,?,'') WHERE uidUsers=?;";
    $stmt = mysqli_stmt_init($conn);
    
    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("Location: ../error=sqlerror");
        exit();
    }
    else{
        
        $compId = $cId . ","; 
        mysqli_stmt_bind_param($stmt,"ss",$compId,$uUId);
        mysqli_stmt_execute($stmt);
        if(mysqli_affected_rows($conn) >0){
        header("Location: ../c/". $slug ."?success=intadded");
        exit();

        }
        else{
            header("Location: ../c/". $slug ."?error=notexc");
            exit();
        }
    }
}else{
        header("Location: ../?error=noid");
        exit();
    }
}
else{
    header("Location: ../");
}


