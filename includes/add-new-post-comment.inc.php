<?php


require_once 'dbh.inc.php';

if(isset($_POST['add-new-post-comment-submit'])){
    if($_SESSION['userId' === $_POST['userId']]){
    $authorId = $_POST['userid'];
    }else{
        header("Location: ../single-post.php?error=wrongid");
        exit();
    }
    $commentBody = $_POST['body'];
    $postId = $_POST['postid'];

    require_once $_SERVER['DOCUMENT_ROOT'] . '/WAIDW/classes/dbh.class.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/WAIDW/classes/post.class.php';
}