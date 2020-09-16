<?php 
    require 'header.php';
    require_once './includes/globals.inc.php';
    require_once './classes/dbh.class.php';
    require_once './classes/categories.class.php';
    require_once './classes/displaycategories.class.php';
    require_once './classes/profile.class.php';
    $categories = new Categories();
    $displayCategories = new DisplayCategories();
    
    echo(isset($_GET['cname']) ? "1" : "0");
?>
<main>
  
  </section>
    <?php if(isset($_GET['cname'])){
        $cname = $_GET['cname']; 
        $catId =  $categories->getCategoryIdByName($cname); ?>
        <section class="about-category">
  <?php
  $isInterested = 0;
  require_once "classes/profile.class.php";
  if(isset($_SESSION['userId'])){
  $currProfile = new Profile($_SESSION['userId']);
  $interests = $currProfile->getInterests();
  
  foreach($interests as $interest){
    
    if($interest == $catId){
      $isInterested = 1;
      
    break;
    }
  }
}
if(isset($_SESSION['userId'])){ 
  ?>
  <?php
    if($isInterested == false){

    
  ?>
    <form style="margin:auto; width:80px; padding:10px; height:20px;" action="<?php echo $HOSTNAME; ?>includes/add-category-to-user-interests.inc.php" method="POST">
    
    <input type="hidden" name="id" value="<?php echo $catId; ?>" />
    <input type="hidden" name="catname" value="<?php echo $cname; ?>" />
    <input class="button" type="submit" name="add-interest-submit" value="I'm Interested">
    </form>

  <?php }else if($isInterested == true){ ?>
    <form style="margin:auto; width:100px; padding:10px; height:20px;" action="<?php echo $HOSTNAME; ?>includes/remove-category-from-user-interests.inc.php" method="POST">
    
    <input type="hidden" name="id" value="<?php echo $catId ?>" />
    <input type="hidden" name="catname" value="<?php echo $cname ?>" />
    <input class="button" type="submit" name="remove-interest-submit" value="I'm not Interested">
    </form>
    <?php }}
  ?>
        <section id="category-posts" class="single-category-container">
        
        <script>
          var isScrolledToBottom = true;
var pageCount = 1;
var oldpage = 0;

//when scrolled to bottom
window.onscroll = function (ev) {
  if (window.innerHeight + window.scrollY >= document.body.scrollHeight -300 ) {
    if (oldpage != pageCount) {
      oldpage = pageCount;
      loadUserPostsByPage(pageCount,<?php echo $categories->getCategoryIdByName($cname); ?>);
    }
    
  }
};
loadUserPostsByPage(0,<?php echo $categories->getCategoryIdByName($cname); ?>);
function loadUserPostsByPage(page, id) {
  var ajax = new XMLHttpRequest();
  var method = "GET";
  var url = 
    "<?php echo $HOSTNAME; ?>includes/get-category-posts-by-page.inc.php?page=" +
    page * 10 +
    "&categoryid=" +
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
            for(var a = 0; ((a<50) &&  (a<body.length) && (body[a] != '<')); a++){
            html += body[a];
            }
            if(a==50   || body[a]== '<' || a==body.length-1){
            html += "...";
            }
          html += "</div>";
          html += "</a>"
        html += "</div>";
      }

      document.getElementById("category-posts").innerHTML += html;
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
   

       
    <?php } else { ?>

        <section class="every-category-container">
            <?php $displayCategories->displayEveryCategories($HOSTNAME); ?>
            </section>
   


    <?php } ?>

        </main>
<?php 
    require 'footer.php';
?>


