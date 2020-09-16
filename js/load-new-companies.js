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
  var url = "./includes/get-every-company.inc.php?page=" + page * 10;

  var asynchronous = true;

  ajax.open(method, url, asynchronous);

  ajax.send();
  var html = "";

  ajax.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      var data = JSON.parse(this.responseText);

      for (var i = 0; i < data.length; i++) {
        var username = data[i].compname;
        var slug = data[i].slug;
        var profileImgUrl = data[i].profilepicurl;

        html += '<a style="padding:5px;" ';
        html += 'href="c/' + slug + '"';
        html += ">";

        html += '<img style="display:block;" src="';
        html += profileImgUrl;
        html += '">';

        html += username;

        html += "</a>";
      }

      document.getElementById("companies-container").innerHTML += html;
    }
  };
}
