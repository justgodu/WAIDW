<?php

class Profile{
    private $username;
    private $profilePictureUrl;
    private $bannerUrl;
    private $uId;
    private $interests = array();
    public function __construct ($id){
        $this->uId = $id;
      $this->username = $this->getUsernameById();
        $this->profilePictureUrl = $this->getProfilePictureUrlById();
        $this->bannerUrl = $this->getProfileBannerUrlById();
        $this->interests = $this->getInterestsById();
    }

    public function getUsername(){
        
        return $this->username;
    }
    public function getProfilePictureUrl(){
        return $this->profilePictureUrl;
    }
    public function getBannerUrl(){
        return $this->bannerUrl;
    }
    public function getInterests(){
        return $this->interests;
    }

    private function getUsernameById(){
        require $_SERVER['DOCUMENT_ROOT'] . "/WAIDW/includes/dbh.inc.php";
        
        if(isset($this->uId)){
            
            $sql = "SELECT * FROM users WHERE idUsers=?";
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
                        $userName = $row['uidUsers'];
                        return $userName;
            }else{
                return "nouser";
        
            }
        }
    }
        else{
            return "notloggedin";
        }
        
}
    private function getProfilePictureUrlById(){
        require $_SERVER['DOCUMENT_ROOT'] . "/WAIDW/includes/dbh.inc.php";
        
        $sql = "SELECT * FROM users WHERE idUsers=?";
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
                $profilePicUrl = $row['profileUrl'];
                if(isset($profilePicUrl) && $profilePicUrl !== ""){
                    return $profilePicUrl;
                }
                else {
                    return "https://st.depositphotos.com/1001911/1554/v/450/depositphotos_15540341-stock-illustration-thumb-up-emoticon.jpg";
                }
            }
            else{
                return "nouser";
        
            }
    }
    }

    private function getProfileBannerUrlById(){
        require $_SERVER['DOCUMENT_ROOT'] . "/WAIDW/includes/dbh.inc.php";
        
        $sql = "SELECT * FROM users WHERE idUsers=?";
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
                $bannerUrl = $row['bannerUrl'];
                if(isset($bannerUrl) && $bannerUrl !== ""){
                    return $bannerUrl;
                }
                else {
                    return "https://supertabthemes.com/wp-content/uploads/2019/02/1-95-758x426.jpg";
                }
            }
            else{
                return "nouser";
        
            }
    }
    }
    private function getInterestsById(){
        require $_SERVER['DOCUMENT_ROOT'] . "/WAIDW/includes/dbh.inc.php";
        
        $sql = "SELECT * FROM users WHERE idUsers=?";
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
                $interests = explode(",",$row['interests']);
                if(isset($interests) && $interests !== ""){
                    return $interests;
                }
                else {
                    return "0";
                }
            }
            else{
                return "nouser";
        
            }
    }
    }


    
}