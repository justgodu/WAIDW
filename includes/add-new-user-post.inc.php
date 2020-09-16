<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_POST['add-new-user-post-submit']) && isset($_SESSION['userId'])){
    $categoryid = $_POST['categoryid'];
    $userId = $_POST['userid'];
    
    $currentUserId = $_SESSION['userId'];
    $postTitle = $_POST['title'];
    $postBody = $_POST['body'];

    if($categoryid == "0"){
header("Location: ../profile.php?error=target0");
exit();
    }
    else if($currentUserId == $userId){
        require 'dbh.inc.php';
        $sql = "INSERT INTO posts(idAuthor,idCategory,postTitle,postBody,postDate,slug) VALUES (?,?,?,?,?,?)";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../profile.php?error=sqlerror");
            exit();
        }else{
            
            require_once 'functions.inc.php';
            $slug = slugify($postTitle);
            $date = date('Y-m-d H:i:s');
            mysqli_stmt_bind_param($stmt,"ssssss",$userId,$categoryid, $postTitle,$postBody ,$date, $slug);
            mysqli_stmt_execute($stmt);
            header("Location: ../profile.php?signup=success");
            exit();
        }
    }
    else{
        header("Location: ../profile.php?error=wronguser" . $currentUserId . $userId);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
else{
    header("Location: ../profile.php?error=usernotset");
    exit();
}