<?php 
function slugify($text)
{
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, '-');

  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}

function getCompanyNameById($id){
  require "dbh.inc.php";
        
        
  $sql = "SELECT * FROM companies WHERE idCompanies=?";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)){
      return "mysqlerror";
  exit();

  }
  else{
          mysqli_stmt_bind_param($stmt, "s", $id );
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);
          if($row = mysqli_fetch_assoc($result)){
              $companyName = $row['uidCompanies'];
              return $companyName;
  }else{
      return "unidentified company";

  }

}

}