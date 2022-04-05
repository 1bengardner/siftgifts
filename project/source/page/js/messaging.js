function setContent(content) {
  document.querySelectorAll('.message-content')[0].innerHTML = "<p>" + content + "</p>";  
}

function setMessage(id) {
  var rq = new XMLHttpRequest();
  rq.open("GET", "/action/get-message?id=" + id, true);
  rq.setRequestHeader("Content-type","application/x-www-form-urlencoded");
  rq.onreadystatechange = function() {
    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
      clearTimeout(loading);
      setContent(rq.responseText);
    }
  }
  var loading = setTimeout(function() {
    setContent("Loading…");
  }, 500);
  rq.send();
}

document.querySelectorAll('.message-chooser-message').forEach(message => {
  message.onclick = function() {
    setMessage(message.id);
  }
});