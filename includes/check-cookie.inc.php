<?php

function checkCoockie(){
$cookie_name = "loggedin";
if(!isset($_COOKIE[$cookie_name]) && !isset($_SESSION['userId'])) {
    return 0;
  } else if(isset($_COOKIE[$cookie_name])) {
    $cookie_value = $_COOKIE[$cookie_name];
    require 'dbh.inc.php';
    $sql = "SELECT * FROM users WHERE idUsers=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: .. /index.php?error=sqlerror");
    exit();
    }
    else{
        mysqli_stmt_bind_param($stmt, "s", $cookie_value);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($result)){
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
                $_SESSION['userId'] = $row['idUsers'];
                $_SESSION['userUId'] = $row['uidUsers'];
                
                header("Location: " .$_SERVER['PHP_SELF']);
                exit();
            }
        else{
            $sql = "SELECT * FROM companies WHERE idCompanies=?";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("Location: .. /index.php?error=sqlerror");
    exit();
    }
    else{
        mysqli_stmt_bind_param($stmt, "s", $cookie_value);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($result)){
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
                $_SESSION['compSlug'] = $row['slug'];
                $_SESSION['compUId'] = $row['uidCompanies'];
                
                header("Location: " .$_SERVER['PHP_SELF']);
                exit();
            }
        else{
            header("Location: ../index.php?error=nouser");
            exit();
        }
        }
    exit();
        }
    }
  }
  
  }