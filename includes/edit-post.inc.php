<?php 

$pUserId = $_POST['userid'];
$userid = $_SESSION['userId'];
$postId = $_POST['postid'];
$newPostBody = $_POST['body'];
if($userid === $pUserId){
    require 'dbh.inc.php';

    $sql = "UPDATE posts SET body = ? WHERE idPost = ? AND idAuthor = ?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt,$sql)){
        header("Location: ../single-post.php?res=sqlerror");
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt,"sss", $newPostBody, $postId, $userid);
        mysqli_stmt_execute($stmt);
        if(!mysqli_stmt_affected_rows($stmt) > 0){
            header("Location: ../single-post.php?res=error");
            exit();
        }
        else{
            header("Location: ../single-post.php?res=success");
            exit();
        }
    }
}
else {
    exit();
}