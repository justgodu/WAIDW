<?php
    require "header.php";
    if(isset($_GET['slug']) && isset($_GET['id'])){
        $postSlug = $_GET['slug'];
        $postId = $_GET['id'];
        require_once "./classes/dbh.class.php";
        require_once "./classes/post.class.php";
        require_once "./classes/displaypost.class.php";
        $post = new Post($postSlug,$postId); 
        $displayPost = new DisplayPostContent($postId);
        
    }else{
        header("Location: ./?err=wrongpost");
    }
    
?>

    <main>
     <section id="single-post" class="single-post-container">
     <?php
        
        if(isset($err)){
          
          ?>
          <div class="error <?php echo $errorType; ?>">
            <?php echo $errorText ?>
          </div>
          <?php
        }
        
             ?>
             <div class="full-single-post single-post">
          <div class="every-post-conteiner">
            <h3 class="post-title">
                <?php echo $post->getTitle(); ?>
            <a href="<?php echo $HOSTNAME ?>c/<?php  echo $post->getCategoryName();?>">
            <span class="post-date">
                <?php echo $post->getCategoryName(); ?>
            </span>
      </a>
            </h3>
            <a href="<?php echo $HOSTNAME; ?>u/<?php echo  $post->getAuthorId(); ?> "> 
            
            <img class="post-author-pic" src="<?php echo $post->getProfilePicUrl(); ?>"/>
            </a>
          </div>
          <div class="post-body">
            <?php echo $post->getBody(); ?>
          </div>
        </div>
        
        <?php if(isset($_SESSION['userId'])){
                  $displayPost->displayAddCommentForm();
         } 
         ?>
       </section>
    </main>
    <?php
    require "footer.php";
?>
