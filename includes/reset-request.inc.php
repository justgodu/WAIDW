<?php
require 'globals.inc.php';
if(isset($_POST["reset-request-submit"])){
    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);
    $url = $HOSTNAME."create-new-password.php?selector=".$selector."&validator=" . bin2hex($token);

    $expires = date("U") + 1800;

    require 'dbh.inc.php';
    
    $userEmail = $_POST["email"];

    $sql = "DELETE FROM pwdReset WHERE pwdResetEmail=?;";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "There was an error! with prepare";
        exit();
    }
    else{
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);
    }

    $sql = "INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        echo "There was an error! with prepare2";
        exit();
    }
    else{
        $hasedToken = password_hash($token, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ssss", $userEmail, $selector, $hasedToken, $expires);
        
        mysqli_stmt_execute($stmt);
        
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);



    require_once 'vendor/autoload.php';
    $sendTo = $userEmail;

    $subject = "Reset your password for my website";

    $message = '<p>Hello please follow this link to reset your password</p>;

     <p>Here is your password reset link </br>;
    <a href = "'. $url .'">'. $url . '</a></p>';

    $headers = "From: mywebsite <nikkagoduadze@gmail.com>\r\n";
    $headers += "Reply-To: nikkagoduadze@gmail.com\r\n";
    $headers += "Content-Type: text/html\r\n";

    $mail = new PHPMailer\PHPMailer\PHPMailer();

// Settings
$mail->IsSMTP();
$mail->CharSet = 'UTF-8';

$mail->Host       = "smtp.gmail.com"; // SMTP server example
$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
$mail->SMTPAuth = true;                    // enable SMTP authentication
                  // set the SMTP port for the GMAIL server
$mail->Username   = ""; // SMTP account username example
$mail->Password   = "";        // SMTP account password example
$mail->SMTPSecure = "tls";                           
    //Set TCP port to connect to 
$mail->Port = 587;   
$mail->smtpConnect(
    array(
        "ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false,
            "allow_self_signed" => true
        )
    )
);
// Content
$mail->isHTML(true);                                  // Set email format to HTML
$mail->addAddress($sendTo, 'Tim'); 
$mail->setFrom('nikkagoduadze@gmail.com', 'Godu');
$mail->Subject = $subject;
$mail->Body    = $message;
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

$mail->send();
if(!$mail->Send())
{
   header("Location: ../reset-password.php?reset=failed");
}
else
{
    header("Location: ../reset-password.php?reset=success");
}


    



}
else{
    header("Location: ../index.php");
}