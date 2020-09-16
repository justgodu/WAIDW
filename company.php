<?php 
    require "header.php";
    require "classes/company.class.php";
    if(isset($_GET['slug'])){
        $slug = $_GET['slug'];
             $company = new Company($slug);
         }else{
         if(!isset($_SESSION['compSlug'])){
         echo "no session id";
         header("Location: ../");
         exit();
         }else{
             $slug = $_SESSION['compSlug'];
             $company = new Company($slug);
         }
         }
    $compId = $company->getCompanyId();
     
     
?>

    <main>
        <div class="profile-container">
            <section class="profile-header">
               
                <div class="banner-container">
                <img class="banner-img" src="<?php echo $company->getBannerUrl(); ?>">
</div>

<div class="profile-pic-container">
                <img class="profile-img" src="<?php echo $company->getCompanyPictureUrl(); ?>" >
</div>
<h3 class="profile-name"><?php echo $company->getCompanyName();  ?></h3>
            </section>

        <?php if(isset( $_SESSION['compSlug']) && $slug == $_SESSION['compSlug']){?>
        <section class="profile-forms">
        <form class="form-profile-change" action="<?php echo $HOSTNAME; ?>includes/set-company-pic.inc.php"  method="POST" enctype="multipart/form-data">
        <h2>Change Profile Picture</h2>
        
        <input type="file" accept="image/*" name="fileToUpload" id="fileSelect"/>
        <input hidden="true" name="companyname" value = "<?php  echo $company->getCompanyName();?> "/>
        
        or
        <input type="text" name="imgurl">
        <input type="submit" name="change-profile-pic-submit" value="Upload"/>
</form>

<form class="form-banner-change" action="<?php echo $HOSTNAME; ?>includes/set-company-banner.inc.php"  method="POST" enctype="multipart/form-data">
        <h2>Change Banner Picture</h2>
        
        <input type="file" name="fileToUpload" id="fileSelect"/>
        <input hidden="true" name="companyname" value = "<?php  echo $company->getCompanyName();?> "/>
        or
        <input type="text" name="imgurl">
        <input type="submit" name="change-profile-banner-submit" value="Upload"/>
        
</form>
</section>

<?php }?>
<?php
  $isInterested = 0;
  require_once "classes/profile.class.php";
  if(isset($_SESSION['userId'])){
  $currProfile = new Profile($_SESSION['userId']);
  $interests = $currProfile->getInterests();
  
  foreach($interests as $interest){
    
    if($interest == $compId){
      $isInterested = 1;
      
    break;
    }
  }
}
if(isset($_SESSION['userId'])){ 
  ?>
  <div>
  <?php
    if($isInterested == false){

    
  ?>


<form style="margin:auto; width:80px; padding:10px; height:20px;" action="<?php echo $HOSTNAME; ?>includes/add-company-to-user-interests.inc.php" method="POST">
  
  <input type="hidden" name="id" value="<?php echo $company->getCompanyId() ?>" />
  <input type="hidden" name="slug" value="<?php echo $slug ?>" />
  <input class="button" type="submit" name="add-interest-submit" value="I'm Interested">
  </form>

<?php }else if($isInterested == true){ ?>
  <form style="margin:auto; width:100px; padding:10px; height:20px;" action="<?php echo $HOSTNAME; ?>includes/remove-company-from-user-interests.inc.php" method="POST">
  
  <input type="hidden" name="id" value="<?php echo $company->getCompanyId() ?>" />
  <input type="hidden" name="slug" value="<?php echo $slug ?>" />
  <input class="button" type="submit" name="remove-interest-submit" value="I'm not Interested">
  </form>
  <?php }
?>
</div>
<?php
}?>
<section class="company-posts" id="company-posts">
                <script>
          var isScrolledToBottom = true;
var pageCount = 1;
var oldpage = 0;

//when scrolled to bottom
window.onscroll = function (ev) {
  if (window.innerHeight + window.scrollY >= document.body.scrollHeight -300 ) {
    if (oldpage != pageCount) {
      oldpage = pageCount;
      loadUserPostsByPage(pageCount,<?php echo $company->getCompanyId(); ?>);
    }
    
  }
};
loadUserPostsByPage(0,<?php echo $company->getCompanyId(); ?>);
function loadUserPostsByPage(page, id) {
  var ajax = new XMLHttpRequest();
  var method = "GET";
  var url = 
    "<?php echo $HOSTNAME; ?>includes/get-every-company-posts.inc.php?page=" +
    page * 10 +
    "&targetid=" +
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

      document.getElementById("company-posts").innerHTML += html;
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