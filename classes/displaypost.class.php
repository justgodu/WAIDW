<?php 

class DisplayPostContent extends Post{
    private $uId;
    private $pId;
    function __construct($postId){
        if(isset($_SESSION['userId'])){
            $this->uId = $_SESSION['userId'];
        }
        $this->pId = $postId;
    }

    function displayComments(){

    }

    function displayAddCommentForm(){
    require $_SERVER['DOCUMENT_ROOT'] . '/WAIDW/includes/globals.inc.php';
        $html = 
        '<div class="add-comment-container">
            <form class="add-comment-form" action="'. $HOSTNAME .'includes/add-new-post-comment.inc.php" method="POST">
                <h2>Add new Comment</h2>

                <input type="hidden" name="userid" value = "'. $this->uId .'"/>
                <input type="hidden" name="postid" value = "'. $this->pId .'"/>
                <textarea  name="body" placeholder="Comment content"></textarea>
                <input class="button" type="submit" name="add-new-post-comment-submit" value="Post"/>
            </form>
        </div>';
    echo $html;
    }
}
