<?php
    require "header.php";
    if(isset($_GET['error'])){
    $err = $_GET['error'];
    if($err == "notloggedin"){
      $errorText = "You are not logged in!";
      $errorType = "notloggedin";
    }
    else if($err == "wrongpwd"){
      $errorText = "Wrong password";
      $errorType = "wrongpwd";
    }
    else{
      $errorText = "Unknow Error";
      $errorText = "unknownerror";
    }
  }
?>

    <main>
     <section id="every-post" class="every-post-conteiner">
     <?php
        
        if(isset($err)){
          
          ?>
          <div class="error <?php echo $errorType; ?>">
            <?php echo $errorText ?>
          </div>
          <?php
        }
        
             ?>

        <script>

var isScrolledToBottom = true;
var pageCount = 1;
var oldpage = 0;

//when scrolled to bottom
window.onscroll = function (ev) {
  if (window.innerHeight + window.scrollY >= document.body.scrollHeight -300 ) {
    
    if (oldpage != pageCount) {
     
      oldpage = pageCount;
      loadUserPostsByPage(pageCount);
    }
    
  }
};
loadUserPostsByPage(0);
function loadUserPostsByPage(page) {
  var ajax = new XMLHttpRequest();
  var method = "GET";
  var url =
    "<?php echo $HOSTNAME; ?>includes/get-every-post.inc.php?page=" +
    page;

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
        var category = data[i].categoryname;
        var slug = data[i].slug;
        var authorId = data[i].authorid;
        var authorpic = data[i].authorpic;
        var postId = data[i].postid;
        html += '<div class="single-post">';
          html += '<div class="post-title-container">';
            html += '<h3 class="post-title">';
                html += title;
            html += '<a  href = \"<?php echo $HOSTNAME; ?>c/'+category + '\"'; 
            
            html += '<span class="post-date">';
                html += category;
            html += "</span>";
            html += "</a>"
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

      document.getElementById("every-post").innerHTML += html;
      isScrolledToBottom = false;
      
      //go to next page
      if(data.length ==10){
    oldpage = pageCount;
    pageCount++;
      }
    }
  };
}

        </script>
       </section>
    </main>
    <?php
    require "footer.php";
?>
