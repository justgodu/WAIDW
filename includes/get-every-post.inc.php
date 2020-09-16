<?php

$page = $_GET['page'] * 10;
$limitPage = $page + 10;
$post = array();
$posts = array();


if($page<0){
    echo 'error';
}else{
    require 'dbh.inc.php';
    
        $sql = "SELECT * FROM posts ORDER BY postDate DESC LIMIT ?, ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../index.php?error=sqlerror");
        exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "ss",$page, $limitPage);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            require_once  $_SERVER['DOCUMENT_ROOT'] . '/WAIDW/classes/dbh.class.php';
            require_once  $_SERVER['DOCUMENT_ROOT'] . '/WAIDW/classes/categories.class.php';
            while($row = mysqli_fetch_assoc($result)){
                $post['title'] = $row['postTitle'];   
                $post['body'] = $row['postBody'];  
                $post['date'] = $row['postDate'];
                $post['slug'] = $row['slug'];  
                $postStatus = $row['postStatus'];  
                $post['authorid'] = $row['idAuthor'];
                $post['postid'] = $row['idPost'];
                $category = new Categories();
                $post['categoryname'] = $category->getCategoryNameById($row['idCategory']);                
                require_once $_SERVER['DOCUMENT_ROOT'] . '/WAIDW/classes/profile.class.php';
                $profile = new Profile($post['authorid']);
                $post['authorpic'] = $profile->getProfilePictureUrl();

                
                if($postStatus == "published"){
                    array_push($posts, $post);
                }
            }
                
            }
          
        
    }

echo json_encode($posts);