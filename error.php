<?php 
    require 'header.php';
    $error = $_SERVER['REDIRECT_STATUS'];

    $error_title = '';
    $error_content = '';

    if($error == 404){
        $error_title = "404 Page not found";
        $error_content = "Requested page/document couldn't be found";
    }
?>
    <section class="error-section">
        <h1><?php echo $error_title; ?></h1>
        <h3><?php echo $error_content; ?></h1>

    </section>

<?php 
    require 'footer.php';
?>