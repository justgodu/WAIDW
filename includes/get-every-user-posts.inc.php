<?php
if(isset($_SERVER['HTTP_REFERER'])){
require_once 'globals.inc.php';

if(strpos($_SERVER['HTTP_REFERER'],  $HOSTNAME .'u/') === false && strpos($_SERVER['HTTP_REFERER'],  $HOSTNAME .'profile.php') === false ){
    echo "Not cool dude";
    exit();
}

$page = $_GET['page'] * 10;
$uId = $_GET['userid'];
$limitPage = $page + 10;
$post = array();
$posts = array();


if($page<0){
    echo 'error';


}else{
    require 'dbh.inc.php';
        $sql = "SELECT * FROM posts  WHERE idAuthor=? ORDER BY postDate DESC LIMIT ?, ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../profile.php?error=sqlerror");
        exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "sss", $uId, $page, $limitPage);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($result)){
                $post['title'] = $row['postTitle'];   
                $post['body'] = $row['postBody'];  
                $post['date'] = $row['postDate'];
                $post['slug'] = $row['slug'];  
                $postStatus = $row['postStatus'];  
                $post['authorid'] = $row['idAuthor'];
                $post['postid'] = $row['idPost'];
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
}
else{
    echo "<h1 style=\"max-width: max-content; margin:auto; \">Who are you and what are you doing here?</h1>";
}