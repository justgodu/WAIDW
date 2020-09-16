<?php

class Post extends Dbh{
    private $postId = "error";
    private $title  = "error";
    private $body = "error";
    private $date = "error";
    private $authorPicUrl = "error";
    private $authorId = "error";
    private $categoryId = "error";
    public $isBought;
    
    

    public function __construct($slug, $id){

        $this->getPostDetails($slug,$id);
    }

    public function getTitle(){
        return $this->title;
    }
    public function getBody(){
        return $this->body;
    }
    public function getProfilePicUrl(){
        return $this->authorPicUrl;
    }
    public function getAuthorId(){
        return $this->authorId;
    }
    
    public function getDate(){
        return $this->date;
    }
    public function getCategoryId(){
        return $this->categoryId;
    }

    public function getCategoryName(){
        
        require_once 'categories.class.php';
        $category = new Categories();
        return $category->getCategoryNameById($this->categoryId);
    }

    private function getPostDetails($slug,$id){
        require $_SERVER['DOCUMENT_ROOT'] . "/WAIDW/includes/dbh.inc.php";
        
        $sql = "SELECT * FROM posts WHERE slug=? AND idPost=?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            $this->title ="errorsql";   
            
    }
        else{
            mysqli_stmt_bind_param($stmt, "ss", $slug , $id );
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)){
                
                $this->title = $row['postTitle'];   
                $this->body = $row['postBody'];  
                $this->date = $row['postDate'];
                $this->categoryId = $row['idCategory'];
                
                $this->authorId = $row['idAuthor'];
                require_once $_SERVER['DOCUMENT_ROOT'] . '/WAIDW/classes/profile.class.php';
                $profile = new Profile($row['idAuthor']);
                $this->authorPicUrl = $profile->getProfilePictureUrl();
            }else{
                $this->title ="nopost";  
            }
        }
    }
    

    private function getTitleById(){
        require $_SERVER['DOCUMENT_ROOT'] . "/WAIDW/includes/dbh.inc.php";
        
        $sql = "SELECT * FROM posts WHERE idPost=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            return "mysqlerror";
        exit();
    }
        else{
            mysqli_stmt_bind_param($stmt, "s", $this->uId );
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)){
                
                return $row['postTitle'];
                
            }
            else{
                return "noid";
        
            }
    }
    }
    

    private function getBodyById(){
        require $_SERVER['DOCUMENT_ROOT'] . "/WAIDW/includes/dbh.inc.php";
        
        $sql = "SELECT * FROM posts WHERE idPost=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            return "mysqlerror";
        exit();
    }
        else{
            mysqli_stmt_bind_param($stmt, "s", $this->uId );
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)){
                
                return $row['postTitle'];
                
            }
            else{
                return "noid";
        
            }
    }
    }

    public function getPostComments(){
        require $_SERVER['DOCUMENT_ROOT'] . "/WAIDW/includes/dbh.inc.php";
        $sql = "SELECT * FROM comments WHERE commentPostId=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            return "mysqlerror";
            exit();
        }else{
            $comments = array();
            mysqli_stmt_bind_param($stmt, "i", $this->uId);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($reslut)){
                array_push($comments, $row);
            }
            if(isset($comments)){
                return $comments;
            }else{
                return "No Comments";
            }
        }
    }

    
    
}