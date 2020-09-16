var isScrolledToBottom = true;
var pageCount = 1;
var oldpage = 0;

//when scrolled to bottom
window.onscroll = function (ev) {
  if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
    if (oldpage != pageCount) {
      oldpage = pageCount;
      loadUserPostsByPage(pageCount);
    }
    isScrolledToBottom = false;
    oldpage = pageCount;
    pageCount++;
  }
};
loadUserPostsByPage(0);
function loadUserPostsByPage(page, id) {
  var ajax = new XMLHttpRequest();
  var method = "GET";
  var url =
    "./includes/get-every-company-posts.inc.php?page=" +
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
        html += '<div class="single-post">';
        html += '<div class="single-title-container">';
        html += '<h3 class="post-title">';
        html += title;
        html += '<span class="post-date">';
        html += date;
        html += "</span>";
        html += "</h3>";
        html += "</div>";
        html += '<p class="post-body">';
        html += body;
        html += "</p>";
        html += "</div>";
      }

      document.getElementById("company-posts").innerHTML += html;
    }
  };
}
