<?php 
if (isset($_POST['change-profile-pic-submit'])) {
    $compName = $_POST['companyname'];
    if(isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == 0){
        
    $target_dir =   "/WAIDW/uploads/" . $compName . "/";
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
      
      
      // Check if file already exists
      if (file_exists($target_file)) {
        header("Location: ../company.php?error=alreadyexists");
        $fileExists = 1;
      }
      
      // Check file size
      if ($_FILES["fileToUpload"]["size"] > 500000) {
        header("Location: ../company.php?error=toolarge");
        $uploadOk = 0;
      }
      
      // Allow certain file formats
      if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" ) {
        header("Location: ../company.php?error=wrongextension");
        $uploadOk = 0;
      }
      
      // Check if File exists if so set profile pic to that pic else upload picture and set it
      if ($fileExists !== 1) {

        require 'dbh.inc.php';
          $stmt = mysqli_stmt_init($conn);
          $sql = "UPDATE companies SET profilePicUrl=? WHERE uidCompanies=?;";
          if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../company.php?error=sqlerror");
            exit();
        }
        else{
           
            mysqli_stmt_bind_param($stmt,"ss",$target_file,$compName);
            mysqli_stmt_execute($stmt);
            header("Location: ../company.php?success=true");
            exit();
        }
        
      // if everything is ok, try to upload 0
      } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          require 'dbh.inc.php';
          $stmt = mysqli_stmt_init($conn);
          $sql = "UPDATE companies SET profilePicUrl=? WHERE uidCompanies=?;";
          if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../company.php?error=sqlerror");
            exit();
        }
        else{
           
            mysqli_stmt_bind_param($stmt,"ss",$target_file,$compName);
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
          $sql = "UPDATE companies SET profilePicUrl=? WHERE uidCompanies=?;";
          if(!mysqli_stmt_prepare($stmt,$sql)){
            header("Location: ../company.php?error=sqlerror");
            exit();
        }
        else{
           
            mysqli_stmt_bind_param($stmt,"ss",$imgurl,$compName);
            mysqli_stmt_execute($stmt);
            header("Location: ../company.php?success=true");
            exit();
        }
} else header("Location: ../company.php?error=nofile");
}
else header("Location: ../company.php?error=wrong");