<?php 

    $interests;
    require_once "header.php";
    require_once "classes/profile.class.php";
    require_once "classes/dbh.class.php";
    require_once "classes/categories.class.php";
    
    if(isset($_GET['id']) && $_GET['id'] !="0" ){
       $uId = $_GET['id'];
            $profile = new Profile($uId);
        }else{
        if(!isset($_SESSION['userId'])){
        echo "no session id";
        header("Location: ../?error=notloggedin");
        exit();
        }else{
          
            $uId = $_SESSION['userId'];
            $profile = new Profile($uId);
            
        }
        }
    
        $cats = new Categories();
        
        $interests = $cats->getEveryCategories(); 
        
      /*
      $interests = $profile->getInterests();
      unset($interests[count($interests)-1]);
      */
       
?>

    <main>
        <div class="profile-container">
            <section class="profile-header">
               
                <div class="banner-container">
                <img class="banner-img" src="<?php echo $profile->getBannerUrl(); ?>">
</div>

<div class="profile-pic-container">
                <img class="profile-img" src="<?php echo $profile->getProfilePictureUrl(); ?>" >
                
</div>
<h3 class="profile-name"><?php echo $profile->getUsername();  ?></h3>
            </section>

            <?php if(isset( $_SESSION['userId']) && $uId == $_SESSION['userId']){?>
            <section class="profile-forms">
        
        <form class="form-profile-change" action="<?php echo $HOSTNAME; ?>includes/set-profile-pic.inc.php"  method="POST" enctype="multipart/form-data">
        <h2>Change Profile Picture</h2>
        
        <input type="file" accept="image/*" name="fileToUpload" id="fileSelect"/>
        <input hidden="true" name="username" value = "<?php  echo $profile->getUsername();?> "/>
        
        or
        <input type="text" name="imgurl">
        <input class="button" type="submit" name="change-profile-pic-submit" value="Upload"/>
</form>

            <form class="form-banner-change" action="<?php echo $HOSTNAME; ?>includes/set-profile-banner.inc.php"  method="POST" enctype="multipart/form-data">
                    <h2>Change Banner Picture</h2>
                    
                    <input type="file" name="fileToUpload" id="fileSelect"/>
                    <input hidden="true" name="username" value = "<?php  echo $profile->getUsername();?> "/>
                    <snap style="margin: auto;"> OR </snap>
                    <input type="text" name="imgurl">
                    
                    <input class="button" type="submit" name="change-profile-banner-submit" value="Upload"/>
                    
            </form>
                

            <form class="add-post-form" action="<?php echo $HOSTNAME; ?>includes/add-new-user-post.inc.php" method="POST">
                <h2>Add new Post</h2>
                
                <label for="catSelect">Choose Category: </label>
                <select id="catSelect" name="categoryid">
                    <?php foreach($interests as $interest){ ?>  
                      <option value="<?php echo $interest['categoryUid'];?>"><?php require_once './includes/functions.inc.php'; echo $interest['categoryName'];  ?></option>

                    <?php }?>
                </select>
                <input type="hidden" name="userid" value = "<?php  echo $uId?>"/>
                <input type="text" name="title" placeholder="Title"  maxlength="40"/>
                <textarea  name="body" placeholder="Post content">Add Post content here</textarea>
                <input class="button" type="submit" name="add-new-user-post-submit" value="Post"/>
            </form>
            
            </section>
            <?php }?>
            <section class="profile-posts" id="profile-posts">
           
                <script>
            
            var isScrolledToBottom = true;
var pageCount = 1;
var oldpage = 0;


//when scrolled to bottom
window.onscroll = function (ev) {
  if (window.innerHeight + window.scrollY >= document.body.scrollHeight -300 ) {
    
    if (oldpage != pageCount) {
     
      oldpage = pageCount;
      loadUserPostsByPage(pageCount, <?php  echo $uId ?>);
    }
    
  }
};
loadUserPostsByPage(0, <?php  echo $uId ?> );
function loadUserPostsByPage(page, id) {
  var ajax = new XMLHttpRequest();
  var method = "GET";
  var url =
    "<?php echo $HOSTNAME; ?>includes/get-every-user-posts.inc.php?page=" +
    page * 10 +
    "&userid=" +
    id;

  var asynchronous = true;

  ajax.open(method, url, asynchronous);

  ajax.send();
  var html = "";

  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var data = JSON.parse(this.responseText);

      for (var i = 0; i < data.length; i++) {
        var title = data[i].title;
        var body = data[i].body;
        var date = data[i].date;
        var slug = data[i].slug;
        var authorId = data[i].authorid;
        var authorpic = data[i].authorpic;
        var postId = data[i].postid;
        html += '<div class="single-post">';
          html += '<div class="post-title-container">';
            html += '<h3 class="post-title">';
                html += title;
            
            html += '<span class="post-date">';
                html += date;
            html += "</span>";
            
            html += "</h3>";
            html += '<a href="';
            html += "<?php echo $HOSTNAME; ?>u/" + authorId + '"> ';
            
            html += '<img class="post-author-pic"';
            html += "src='";
            html += authorpic;
            html += "'>"
            html += '</a>'
          html += "</div>";
          html += '<a href="'
          html += "<?php echo $HOSTNAME; ?>p/" + slug + "/" + postId +'"> ';
          html += '<div class="post-body">';
             console.log(title + " " + body.length);
             var a;
            for( a = 0; ((a<50) &&  (a<body.length) && (body[a] != '<')); a++){
            html += body[a];
            }
            if(a==50 || body[a]== '<' || a==body.length-1){
            html += "...";
            }
          html += "</div>";
          html += "</a>"
        html += "</div>";
      }

      document.getElementById("profile-posts").innerHTML += html;
      isScrolledToBottom = false;
      if(data.length ==10){
        oldpage = pageCount;
        pageCount++;
      }
    }
  };
}
</script>   
            </section>
</div>
    </main>


<?php 
    require "footer.php";
?>