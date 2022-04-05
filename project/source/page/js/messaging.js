function setContent(id) {
  var rq = new XMLHttpRequest();
  rq.open("GET", "/action/get-message?id=" + id, true);
  rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  rq.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      clearTimeout(loading);
      document.querySelectorAll('.message-content')[0].innerHTML = "<p>" + rq.responseText + "</p>";
    }
  }
  var loading = setTimeout(function() {
    document.querySelectorAll('.message-content')[0].innerHTML = "<p>" + "Loading…" + "</p>";
  }, 500);
  rq.send();
}

document.querySelectorAll('.message-chooser-message').forEach(message => {
  message.onclick = function() {
    setContent(message.id);
  }
});