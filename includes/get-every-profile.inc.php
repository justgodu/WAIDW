<?php

$page = $_GET['page'] * 10;
$limitPage = $page + 10;
$user = array();
$users = array();


if($page<0){
    echo 'error';


}else{
    require 'dbh.inc.php';
        $sql = "SELECT * FROM users ORDER BY idUsers ASC LIMIT ?, ?;";
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
                $user['username'] = $row['uidUsers'];   
                $user['id'] = $row['idUsers'];  
                $user['profileimgurl'] = $row['profileUrl'];  
                array_push($users, $user);
                }
                
            }
          
        
    }

echo json_encode($users);