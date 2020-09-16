<?php

class Company{
    private $companyName;
    private $slug;
    private $companyPictureUrl;
    private $bannerUrl;
    private $id;

    public function __construct ($slug){
      $this->companyName = $this->getCompanyNameById($slug);
        $this->companyPictureUrl = $this->getCompanyPictureUrlById($slug);
        $this->bannerUrl = $this->getCompanyBannerUrlById($slug);
        $this->id = $this->getCompanyIdBySlug($slug);
    }

    public function getCompanyName(){
        return $this->companyName;
    }
    public function getCompanyPictureUrl(){
        return $this->companyPictureUrl;
    }
    public function getBannerUrl(){
        return $this->bannerUrl;
    }
    public function getCompanyId(){
        return $this->id;
    }

    private function getCompanyIdBySlug($slug){
        require "includes/dbh.inc.php";
        
        
            $sql = "SELECT * FROM companies WHERE slug=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                return "mysqlerror";
            exit();

            }
            else{
                    mysqli_stmt_bind_param($stmt, "s", $slug );
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if($row = mysqli_fetch_assoc($result)){
                        $compId = $row['idCompanies'];
                        return $compId;
            }else{
                return "nouser";
        
            }
        
    }
        
    }
    private function getCompanyNameById($slug){
        require "includes/dbh.inc.php";
        
        
            $sql = "SELECT * FROM companies WHERE slug=?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                return "mysqlerror";
            exit();

            }
            else{
                    mysqli_stmt_bind_param($stmt, "s", $slug );
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if($row = mysqli_fetch_assoc($result)){
                        $companyName = $row['uidCompanies'];
                        return $companyName;
            }else{
                return "nouser";
        
            }
        
    }
        
        
}
// private function getCompanySlugById($slug){
//     require "includes/dbh.inc.php";
    
    
//         $userId = $_SESSION['userId'];
//         $sql = "SELECT * FROM companies WHERE slug=?";
//         $stmt = mysqli_stmt_init($conn);
//         if(!mysqli_stmt_prepare($stmt, $sql)){
//             return "mysqlerror";
//         exit();

//         }
//         else{
//                 mysqli_stmt_bind_param($stmt, "s", $slug );
//                 mysqli_stmt_execute($stmt);
//                 $result = mysqli_stmt_get_result($stmt);
//                 if($row = mysqli_fetch_assoc($result)){
//                     $companyName = $row['slug'];
//                     return $companyName;
//         }else{
//             return "nouser";
    
//         }
//     }

    
//}
    private function getCompanyPictureUrlById($slug){
        require "includes/dbh.inc.php";
        
        $sql = "SELECT * FROM companies WHERE slug=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            return "mysqlerror";
        exit();
    }
        else{
            mysqli_stmt_bind_param($stmt, "s", $slug );
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)){
                
              
                if(isset($row['profilePicUrl']) && $row['profilePicUrl'] !== ""){
                    $profilePicUrl = $row['profilePicUrl'];
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

    private function getCompanyBannerUrlById($slug){
        require "includes/dbh.inc.php";
        
        $sql = "SELECT * FROM companies WHERE slug=?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            return "mysqlerror";
        exit();
    }
        else{
            mysqli_stmt_bind_param($stmt, "s", $slug);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($result)){
                $bannerUrl = $row['bannerPicUrl'];
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
    
}