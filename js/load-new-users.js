var isScrolledToBottom = true;
var pageCount = 1;
var oldpage = 0;

//when scrolled to bottom
window.onscroll = function (ev) {
  if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
    if (oldpage != pageCount) {
      oldpage = pageCount;
      loadUsersByPage(pageCount);
    }
    isScrolledToBottom = false;
    oldpage = pageCount;
    pageCount++;
  }
};
loadUsersByPage(0);
function loadUsersByPage(page) {
  var ajax = new XMLHttpRequest();
  var method = "GET";
  var url = "./includes/get-every-profile.inc.php?page=" + page * 10;

  var asynchronous = true;

  ajax.open(method, url, asynchronous);

  ajax.send();
  var html = "";

  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var data = JSON.parse(this.responseText);

      for (var i = 0; i < data.length; i++) {
        var username = data[i].username;
        var id = data[i].id;
        var profileImgUrl = data[i].profileimgurl;
        html += '<div class="user-name-image-container">';
        html += "<a ";
        html += 'href="u/' + id + '"';
        html += ">";

        html += '<img src="';
        html += profileImgUrl;
        html += '">';
        html += "<h4>";
        html += username;
        html += "</h4>";
        html += "</a>";
        html += "</div>";
      }

      document.getElementById("users-container").innerHTML += html;
    }
  };
}
