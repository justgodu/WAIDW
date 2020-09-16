<?php

$page = $_GET['page'] * 10;
$limitPage = $page + 10;
$company = array();
$companies = array();


if($page<0){
    echo 'error';


}else{
    require 'dbh.inc.php';
        $sql = "SELECT * FROM companies ORDER BY idCompanies ASC LIMIT ?, ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("Location: ../index.php?error=sqlerror");
        exit();
        }
        else{
            mysqli_stmt_bind_param($stmt, "ss", $page, $limitPage);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($result)){
                $company['compname'] = $row['uidCompanies'];   
                $company['slug'] = $row['slug']; 
                $company['profilepicurl'] = $row['profilePicUrl'];  
                array_push($companies, $company);
                }
                
            }
          
        
    }

echo json_encode($companies);