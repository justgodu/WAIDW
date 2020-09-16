<?php 
if (isset($_POST['change-profile-banner-submit'])) {
    $companyName = $_POST['companyname'];
    if(isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0){
        
    $target_dir =   "/WAIDW/uploads/" . $companyName . "/";
    if(!file_exists($_SERVER['DOCUMENT_ROOT'] . $target_dir)){
        mkdir($_SERVER['DOCUMENT_ROOT'] . $target_dir);
    }
$target_file = $_SERVER['DOCUMENT_ROOT'] . $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$fileExists = 0;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
         
          $uploadOk = 1;
        } else {
           
          $uploadOk = 0;
        }
      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
        header("Location: ../company.php?error=wrongextension");
        exit();
        $uploadOk = 0;
      }
      
      // Check if file already exists
      if (file_exists($target_file)) {
        header("Location: ../company.php?error=alreadyexists");
        exit();
        $fileExists = 1;
      }
      
      // Check file size
      if ($_FILES["fileToUpload"]["size"] > 500000) {
        header("Location: ../company.php?error=toolarge");
        exit();
        $uploadOk = 0;
      }
      
      
      
      // Check if File exists if so set banner pic to that pic else upload picture and set it
      if ($fileExists !== 1) {

        require 'dbh.inc.php';
          $stmt = mysqli_stmt_init($conn);
          $sql = "UPDATE users SET bannerUrl=? WHERE uidUsers=?;";
          if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../company.php?error=sqlerror");
            exit();
        }
        else{
           
            mysqli_stmt_bind_param($stmt,"ss",$target_file,$companyName);
            mysqli_stmt_execute($stmt);
            header("Location: ../company.php?success=true");
            exit();
        }
        header("Location: ../company.php?error=error");
      // if everything is ok, try to upload file
      } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          require 'dbh.inc.php';
          $stmt = mysqli_stmt_init($conn);
          $sql = "UPDATE users SET bannerUrl=? WHERE uidUsers=?;";
          if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../company.php?error=sqlerror");
            exit();
        }
        else{
           
            mysqli_stmt_bind_param($stmt,"ss",$target_file,$companyName);
            mysqli_stmt_execute($stmt);
            header("Location: ../company.php?success=true");
            exit();
        }
          
        } else {
            header("Location: ../company.php?error=erroruploading");
        }
      }
    }

else if(isset($_POST['imgurl'])){
    require 'dbh.inc.php';
    $imgurl = $_POST['imgurl'];
          $stmt = mysqli_stmt_init($conn);
          $sql = "UPDATE companies SET bannerPicUrl=? WHERE uidCompanies=?;";
          if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../company.php?error=sqlerror");
            exit();
        }
        else{
           
            mysqli_stmt_bind_param($stmt,"ss",$imgurl,$companyName);
            mysqli_stmt_execute($stmt);
            header("Location: ../company.php?success=true");
            exit();
        }
} else header("Location: ../company.php?error=nofile");
}
else header("Location: ../company.php?error=wrong");